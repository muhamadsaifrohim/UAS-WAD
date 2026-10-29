<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockTransactionRequest;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class StockTransactionController extends Controller
{
    // READ: riwayat transaksi + filter jenis dan produk
    public function index(Request $request): View
    {
        $transactions = StockTransaction::with(['product', 'user'])
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->type))
            ->when($request->filled('product_id'), fn ($q) => $q->where('product_id', $request->product_id))
            ->latest('transaction_date')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('stock.index', [
            'transactions' => $transactions,
            'products'     => Product::orderBy('name')->get(),
        ]);
    }

    public function create(Request $request): View
    {
        return view('stock.create', [
            'products' => Product::orderBy('name')->get(),
            // memungkinkan link seperti /stock-transactions/create?product_id=3
            'selectedProduct' => $request->query('product_id'),
        ]);
    }

    // CREATE: catat transaksi dan ubah stok dalam SATU database transaction
    public function store(StockTransactionRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $request) {
            // lockForUpdate: kunci baris produk agar dua transaksi bersamaan
            // tidak membaca stok yang sama (mencegah race condition)
            $product = Product::lockForUpdate()->findOrFail($data['product_id']);

            // Transaksi keluar tidak boleh melebihi stok yang ada
            if ($data['type'] === 'out' && $data['quantity'] > $product->stock) {
                throw ValidationException::withMessages([
                    'quantity' => "Stok tidak cukup. Stok {$product->name} saat ini: {$product->stock}.",
                ]);
            }

            StockTransaction::create([
                'product_id'       => $product->id,
                'user_id'          => $request->user()->id, // dari session, BUKAN dari input form
                'type'             => $data['type'],
                'quantity'         => $data['quantity'],
                'note'             => $data['note'] ?? null,
                'transaction_date' => $data['transaction_date'],
            ]);

            $data['type'] === 'in'
                ? $product->increment('stock', $data['quantity'])
                : $product->decrement('stock', $data['quantity']);
        });

        return redirect()->route('stock-transactions.index')
            ->with('success', 'Transaksi stok berhasil dicatat.');
    }
}
