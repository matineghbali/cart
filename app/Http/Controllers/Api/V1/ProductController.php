<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\DTO\CreateProductDTO;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Requests\CreateProductRequest;

/**
 * Class ProductController
 *
 * @package App\Http\Controllers\Api\V1
 */
class ProductController extends Controller
{
    /**
     * ProductController constructor.
     *
     * @param ProductService $productService
     */
    public function __construct(private ProductService $productService)
    {
    }

    /**
     * @param CreateProductRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateProductRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $dto = app()->make(CreateProductDTO::class)->fromRequest($request);
            $product = $this->productService->createProduct($dto);
            DB::commit();

            return $this->successResponse(
                trans('messages.successfully'),
                $this->productService->getView($product, ProductResource::class)
            );
        } catch (Exception $exception) {
            DB::rollBack();
dd($exception);
            return $this->failureResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }
}
