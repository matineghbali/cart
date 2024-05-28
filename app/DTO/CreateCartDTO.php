<?php

namespace App\DTO;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\Contracts\FromRequestDTOInterface;

/**
 * Class CreateCartDTO
 *
 * @property-read string|null $product_id
 * @property-read string|null $token
 *
 * @package App\DTO
 */
class CreateCartDTO implements FromRequestDTOInterface
{
    /**
     * CreateCartDTO constructor.
     *
     * @param string|null $product_id
     * @param string|null $token
     */
    public function __construct(
        public ?string $product_id = null,
        public ?string $token = null,
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
            product_id: $request->input('product_id'),
            token: $request->input('token')
        );
    }
}
