<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ProductController extends Controller
{

    /**
     * @OA\Get(
     *     path="/rest/products",
     *     summary="Obtener todos los productos",
     *     tags={"Products"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de productos",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     )
     * )
     */
    public function index()
    {
        $product = Product::all();
        return response()->json($product);
    }

    public function mostrar()
    {
        $products = Product::all();
        $categories = ProductCategory::all();
        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required',
            'product_category_id' => 'required|exists:product_category,id',
        ]);


        $product = Product::create($validatedData);
        return redirect()->route('products.index');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }
    
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|integer|min:0',
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required',
            'product_category_id' => 'required|exists:product_category,id',
        ]);

        $id = $validatedData['product_id'];
        $product = Product::findOrFail($id);
        $product->update($validatedData);
        
        return redirect()->route('products.index');
    }

    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|numeric|min:0',
        ]);
        $id = $validatedData['product_id'];
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index');
    }

    /**
     * @OA\Get(
     *     path="/rest/products/{id}",
     *     summary="Obtener un producto por ID",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del producto",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }
}