<?php

namespace App\Services;

use Exception;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use App\DTO\CreateCartDTO;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Services\Contracts\BaseService;
use App\Repositories\Contracts\CartRepositoryInterface;

/**
 * Class CartService
 *
 * @package App\Services
 */
class CartService extends BaseService
{
    /**
     * CartService constructor.
     *
     * @param CartRepositoryInterface $repository
     */
    public function __construct(CartRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param CreateCartDTO $dto
     *
     * @return Cart
     *
     * @throws Exception
     */
    public function createCart(CreateCartDTO $dto): Cart
    {
        $product = Product::query()->find($dto->product_id);
        $this->checkProductInventory($product);

        $cart = $this->getCart($dto);
        $this->checkProductDuplication($cart, $product);

        if (!isset($cart)) {
            $cart = $this->createNewCart();
        }

        $this->createCartItem($cart, $product);
        $this->updateCartTotalPrice($cart);

        return $cart;
    }

    /**
     * @param Product $product
     *
     * @throws Exception
     */
    private function checkProductInventory(Product $product): void
    {
        if ($product->inventory <= 0) {
            throw new Exception(trans('messages.product_inventory_is_zero'), 406);
        }
    }

    /**
     * @param CreateCartDTO $dto
     *
     * @return Cart|null
     */
    private function getCart(CreateCartDTO $dto): ?Cart
    {
        return $this->findCartByToken($dto) ?: $this->findCartByUser();
    }

    /**
     * @param CreateCartDTO $dto
     *
     * @return Cart|null
     */
    private function findCartByToken(CreateCartDTO $dto): ?Cart
    {
        return $dto->token ? $this->repository->findBy('token', $dto->token) : null;
    }

    /**
     * @return Cart|null
     */
    private function findCartByUser(): ?Cart
    {
        return Auth::check() ? $this->repository->findBy('user_id', Auth::id()) : null;
    }

    /**
     * @param Cart|null $cart
     * @param Product $product
     *
     * @throws Exception
     */
    private function checkProductDuplication(?Cart $cart, Product $product): void
    {
        if ($cart) {
            $cartItem = $cart->items()->where('product_id', $product->id)->first();
            if ($cartItem) {
                throw new Exception(trans('messages.product_is_duplicated'), 406);
            }
        }
    }

    /**
     * @return Cart
     */
    private function createNewCart(): Cart
    {
        return $this->repository->create($this->prepareCreateData());
    }

    /**
     * @return array
     */
    private function prepareCreateData(): array
    {
        return [
            'status' => Cart::OPEN_STATUS,
            'user_id' => Auth::id(),
            'token' => time() .''. Str::random(10),
            'total_price' => 0
        ];
    }

    /**
     * @param Cart $cart
     * @param Product $product
     */
    private function createCartItem(Cart $cart, Product $product): void
    {
        CartItem::query()->create($this->prepareCreateCartItemData($cart, $product));
    }

    /**
     * @param Cart $cart
     * @param Product $product
     *
     * @return array
     */
    private function prepareCreateCartItemData(Cart $cart, Product $product): array
    {
        return [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'price' => $product->price,
        ];
    }

    /**
     * @param Cart $cart
     */
    private function updateCartTotalPrice(Cart $cart): void
    {
        $cart->total_price = $cart->items()->sum('price');
        $cart->save();
    }

    /**
     * @param Cart $cart
     *
     * @return void
     */
    public function delete(Cart $cart): void
    {
        $this->repository->delete($cart);
    }
}
