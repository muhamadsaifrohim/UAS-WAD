<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // exists: pastikan ID kategori/supplier benar-benar ada di database
            'category_id' => ['required', 'exists:categories,id'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'sku' => [
                'required', 'string', 'max:50',
                Rule::unique('products', 'sku')->ignore($this->route('product')),
            ],
            'name'      => ['required', 'string', 'max:150'],
            'price'     => ['required', 'integer', 'min:0', 'max:1000000000'],
            'min_stock' => ['required', 'integer', 'min:0', 'max:100000'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori tidak valid.',
            'supplier_id.required' => 'Supplier wajib dipilih.',
            'supplier_id.exists'   => 'Supplier tidak valid.',
            'sku.required'         => 'SKU wajib diisi.',
            'sku.unique'           => 'SKU sudah dipakai produk lain.',
            'name.required'        => 'Nama produk wajib diisi.',
            'price.required'       => 'Harga wajib diisi.',
            'price.integer'        => 'Harga harus berupa angka bulat.',
            'price.min'            => 'Harga tidak boleh negatif.',
            'min_stock.required'   => 'Stok minimum wajib diisi.',
            'min_stock.integer'    => 'Stok minimum harus berupa angka bulat.',
            'min_stock.min'        => 'Stok minimum tidak boleh negatif.',
        ];
    }
}
