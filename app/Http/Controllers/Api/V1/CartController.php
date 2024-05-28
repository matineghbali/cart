<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Models\Cart;
use App\DTO\CreateCartDTO;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Requests\CreateCartRequest;

/**
 * Class CartController
 *
 * @package App\Http\Controllers\Api\V1
 */
class CartController extends Controller
{
    /**
     * CartController constructor.
     *
     * @param CartService $cartService
     */
    public function __construct(private CartService $cartService)
    {
    }

    /**
     * @param CreateCartRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateCartRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $dto = app()->make(CreateCartDTO::class)->fromRequest($request);
            $cart = $this->cartService->createCart($dto);
            DB::commit();

            return $this->successResponse(
                trans('messages.successfully'),
                $this->cartService->getView($cart, CartResource::class)
            );
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->failureResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }

    /**
     * @param Cart $cart
     *
     * @return JsonResponse
     */
    public function show(Cart $cart)
    {
        return $this->successResponse(
            trans('messages.successfully'),
            $this->cartService->getView($cart, CartResource::class)
        );
    }

    /**
     * @param Cart $cart
     *
     * @return JsonResponse
     */
    public function destroy(Cart $cart): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->cartService->delete($cart);
            DB::commit();

            return $this->successResponse(
                trans('messages.successfully')
            );
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->failureResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }
}
