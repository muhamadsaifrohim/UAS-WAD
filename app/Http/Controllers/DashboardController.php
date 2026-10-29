<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\Supplier;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'totalProducts'   => Product::count(),
            'totalCategories' => Category::count(),
            'totalSuppliers'  => Supplier::count(),
            'totalStock'      => Product::sum('stock'),
            'lowStock'        => Product::lowStock()->with('category')->orderBy('stock')->get(),
            // with() = eager loading, menghindari masalah N+1 query
            'recent'          => StockTransaction::with(['product', 'user'])
                                    ->latest('transaction_date')->latest('id')->take(5)->get(),
        ]);
    }
}
