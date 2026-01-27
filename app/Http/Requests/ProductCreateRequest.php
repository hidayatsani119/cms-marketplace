<?php

namespace App\Http\Requests;

use App\Enum\ProductStatusEnum;
use App\Models\Product;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProductCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string','required','max:100'],
            'description' => ['string','required'],
            'price' => ['int','gt:0','required'],
            'quantity' =>['int','gte:0','required'],
            'image' => ['file','mimes:jpg,jpeg,png','max:1024','nullable'],
            'status' => [Rule::enum(ProductStatusEnum::class), 'nullable'],
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "errors" => $validator->getMessageBag()
        ],400));
    }
}
