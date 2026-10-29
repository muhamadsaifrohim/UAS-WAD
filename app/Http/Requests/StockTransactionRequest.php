<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // admin dan staff sama-sama boleh mencatat transaksi
    }

    public function rules(): array
    {
        return [
            'product_id'       => ['required', 'exists:products,id'],
            'type'             => ['required', 'in:in,out'],
            'quantity'         => ['required', 'integer', 'min:1', 'max:100000'],
            'transaction_date' => ['required', 'date', 'before_or_equal:today'],
            'note'             => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required'            => 'Produk wajib dipilih.',
            'product_id.exists'              => 'Produk tidak valid.',
            'type.required'                  => 'Jenis transaksi wajib dipilih.',
            'type.in'                        => 'Jenis transaksi tidak valid.',
            'quantity.required'              => 'Jumlah wajib diisi.',
            'quantity.integer'               => 'Jumlah harus berupa angka bulat.',
            'quantity.min'                   => 'Jumlah minimal 1.',
            'transaction_date.required'      => 'Tanggal wajib diisi.',
            'transaction_date.date'          => 'Format tanggal tidak valid.',
            'transaction_date.before_or_equal' => 'Tanggal tidak boleh di masa depan.',
            'note.max'                       => 'Catatan maksimal 255 karakter.',
        ];
    }
}
