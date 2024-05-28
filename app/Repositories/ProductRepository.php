<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\ProductRepositoryInterface;

/**
 * Class ProductRepository
 *
 * @package App\Repositories
 */
class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    /**
     * ProductRepository constructor.
     *
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }
}
