<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\CartRepositoryInterface;

/**
 * Class CartRepository
 *
 * @package App\Repositories
 */
class CartRepository extends BaseRepository implements CartRepositoryInterface
{
    /**
     * CartRepository constructor.
     *
     * @param Cart $model
     */
    public function __construct(Cart $model)
    {
        parent::__construct($model);
    }
}
