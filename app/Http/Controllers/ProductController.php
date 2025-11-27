<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class ProductController extends Controller
{

   public function index(Request $request)
{
    $search = $request->input('search');
    $rating = $request->input('rating');
    
    $products = Product::query()
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('price', 'like', "%{$search}%");
            });
        })
        ->when($rating, function ($query, $rating) {
            $query->whereIn('id', function ($subQuery) use ($rating) {
                $subQuery->select('product_id')
                    ->from('reviews')
                    ->where('is_approved', true)
                    ->groupBy('product_id')
                    ->havingRaw('AVG(rating) >= ?', [$rating]);
            });
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();
    
    return view('products.index', compact('products', 'search', 'rating'));
}

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }


    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }


    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }


    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }


    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Download product details as PDF.
     */
    public function downloadPdf(Product $product)
    {
        $pdf = Pdf::loadView('products.pdf', compact('product'));

        return $pdf->download('product-' . $product->id . '-' . Str::slug($product->name) . '.pdf');
    }
}
