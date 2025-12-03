<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $cloudinaryService;

    public function __construct(CloudinaryService $cloudinaryService)
    {
        $this->cloudinaryService = $cloudinaryService;
    }

    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $productData = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id, 
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $uploadResult = $this->cloudinaryService->upload($request->file('image'), 'products');
            $productData['image_url'] = $uploadResult['url'];
            $productData['image_public_id'] = $uploadResult['public_id'];
        }

        Product::create($productData);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $productData = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_public_id) {
                $this->cloudinaryService->delete($product->image_public_id);
            }

            $uploadResult = $this->cloudinaryService->upload($request->file('image'), 'products');
            $productData['image_url'] = $uploadResult['url'];
            $productData['image_public_id'] = $uploadResult['public_id'];
        }

        // Handle image removal
        if ($request->has('remove_image') && $request->remove_image == '1') {
            if ($product->image_public_id) {
                $this->cloudinaryService->delete($product->image_public_id);
            }
            $productData['image_url'] = null;
            $productData['image_public_id'] = null;
        }

        $product->update($productData);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete image from Cloudinary
        if ($product->image_public_id) {
            $this->cloudinaryService->delete($product->image_public_id);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Download product as PDF.
     */
    public function downloadPdf(Product $product)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('products.pdf', compact('product'));

        return $pdf->download($product->name . '.pdf');
    }
}
