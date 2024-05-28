<?php

namespace App\Services;

use App\Events\CreateProductEvent;
use Exception;
use App\Models\Product;
use App\DTO\CreateProductDTO;
use App\Services\Contracts\BaseService;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class ProductService
 *
 * @package App\Services
 */
class ProductService extends BaseService
{
    /**
     *  ProductService constructor.
     *
     * @param ProductRepositoryInterface $repository
     *
     * @throws BindingResolutionException
     */
    public function __construct(ProductRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param CreateProductDTO $dto
     *
     * @return Product
     *
     * @throws Exception
     */
    public function createProduct(CreateProductDTO $dto): Product
    {
        $product = $this->repository->create($dto->toArray());
        CreateProductEvent::dispatch($product);

        return $product;
    }
}
