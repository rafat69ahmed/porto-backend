<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * list of products
     */
    public function index()
    {
        try {
            $products = Product::paginate(10);
            return response()->json([
                'status' => 'success',
                'message' => 'fetched product list successfully',
                'data' => $products,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
        // $products = Product::all();
        // // $products = Product::paginate(10);
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'fetched product list successfully',
        //     'data' => $products,
        // ]);
    }

    /**
     * store a product
     */
    public function store(Request $request)
    {
        // try {
        //     $request->validate([
        //         'title' => 'required|string|max:255',
        //         'description' => 'required|string|max:255',
        //     ]);
        // } catch (ValidationException $e) {
        //     // Handle the failed validation...
        //     return response()->json($e->errors(), 422);
        // }
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
                'image' => 'required|string',
                'sku' => 'required|string',
            ]);
            $product = Product::create([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'price' => $request->price,
                'stock' => $request->stock,
                'image' => $request->image,
                'sku' => $request->sku,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully',
                'data' => $product,
            ]);
        } catch (ValidationException $e) {
            // Handle the failed validation...
            return response()->json($e->errors(), 422);
        } catch (AuthenticationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'description' => 'required|string|max:255',
        //     'category' => 'required|string|max:255',
        //     'price' => 'required|numeric',
        //     'stock' => 'required|numeric',
        //     'image' => 'required|string',
        //     'sku' => 'required|string',
        // ]);

        // $request->validate([
        //     'email' => 'required|string|email',
        //     'password' => 'required|string',
        // ]);

        // $product = Product::create([
        //     'title' => $request->title,
        //     'description' => $request->description,
        //     'category' => $request->category,
        //     'price' => $request->price,
        //     'stock' => $request->stock,
        //     'image' => $request->image,
        //     'sku' => $request->sku,
        // ]);

        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Product created successfully',
        //     'data' => $product,
        // ]);
    }

    public function show($id)
    {
        $product = Product::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $product,
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully',
            'data' => $product,
        ]);
    }
}
