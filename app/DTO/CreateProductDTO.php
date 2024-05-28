<?php

namespace App\DTO;

use Exception;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use App\DTO\Contracts\ToArrayDTOInterface;
use Illuminate\Foundation\Http\FormRequest;
use App\DTO\Contracts\FromRequestDTOInterface;

/**
 * Class CreateProductDTO
 *
 * @property-read string|null $title
 * @property-read string|null $description
 * @property-read integer|null $price
 * @property-read integer|null $inventory
 *
 * @package App\DTO
 */
class CreateProductDTO implements FromRequestDTOInterface, ToArrayDTOInterface
{
    /**
     * CreateProductDTO constructor.
     *
     * @param string|null $title
     * @param string|null $description
     * @param int|null $price
     * @param int|null $inventory
     */
    public function __construct(
        public ?string $title = null,
        public ?string $description = null,
        public ?int $price = 0,
        public ?int $inventory = 0,
    ) {
    }

    /**
     * @param FormRequest $request
     *
     * @return FromRequestDTOInterface
     */
    public function fromRequest(FormRequest $request): FromRequestDTOInterface
    {
        return new self(
            title: $request->input('title'),
            description: $request->input('description'),
            price: $request->input('price'),
            inventory: $request->input('inventory'),
        );
    }

    /**
     * @param Product|Model|null $model
     *
     * @return array
     *
     * @throws Exception
     */
    public function toArray(?Model $model = null): array
    {
        return [
            'status' => Product::ACTIVE_STATUS,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'inventory' => $this->inventory
        ];
    }
}
