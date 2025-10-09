<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function getProducts(Request $request, $format = null) {
        $products = Product::query()->with("company")->get();

        if ($format === '.json' || $request->wantsJson()) {
            return ProductResource::collection($products);
        }

        return view("products")->with('products', $products->toArray());
    }

    public function getProduct(Request $request, $GTIN, $format = null) {
        $cleanGTIN = str_replace(".json", "", $GTIN);
        $product = Product::query()->with("company")->where('GTIN', $cleanGTIN)->first();

        if (!$product) {
            return redirect("/products")->with("error", "Product not found");
        }

        if ($format === '.json' || str_ends_with($GTIN, ".json") || $request->wantsJson()) {
            return new ProductResource($product);
        }

        return view("product")->with('product', $product->toArray());
    }

    public function createProduct(Request $request) {
        $data = $request->validate([
            "GTIN" => "required|string",
            "name" => "required|string",
            "name_fr" => "required|string",
            "description" => "required|string",
            "description_fr" => "required|string",
            "brand_name" => "required|string",
            "country" => "required|string",
            "gross_weight" => "required",
            "net_weight" => "required",
            "weight_unit" => "required|string",
        ]);

        $exist = Product::query()->where('GTIN', $data['GTIN'])->exists();
        if ($exist) {
            return redirect()->back()->with(["error", "GTIN already exists"]);
        }

        if (strlen($data["GTIN"]) > 14 || strlen($data["GTIN"]) < 13) {
            return redirect()->back()->with(["error", "GTIN is invalid"]);
        }

        try {
            Product::query()->create($data);
            return redirect()->back()->with(["success", "Product created"]);
        } catch (\Exception $e) {
            return redirect()->back()->with(["error", "Product creation failed"]);
        }
    }

    public function updateProduct(Request $request, $GTIN) {
        $data = $request->validate([
            "name" => "required|string",
            "name_fr" => "required|string",
            "description" => "required|string",
            "description_fr" => "required|string",
            "brand_name" => "required|string",
            "country" => "required|string",
            "gross_weight" => "required",
            "net_weight" => "required",
            "weight_unit" => "required|string",
        ]);

        try {
            $product = Product::query()->where("GTIN", $GTIN)->first();
            $product->update($data);
            return redirect()->back()->with(["success", "Product updated"]);
        } catch (\Exception $e) {
            return redirect()->back()->with(["error", "Product update failed"]);
        }
    }

    public function hideProduct(Request $request, $GTIN) {
        $product = Product::query()->where('GTIN', $GTIN)->first();

        try {
            $product->update(["is_hidden" => true]);
            return redirect()->back()->with(["success", "Product hidden"]);
        } catch (\Exception $e) {
            return redirect()->back()->with(["error", "Product hidden failed"]);
        }
    }

    public function deleteProduct(Request $request, $GTIN) {
        $product = Product::query()->where('GTIN', $GTIN)->first();
        if ($product->hidden === 0) {
            return redirect()->back()->with(["error", "Product not hidden"]);
        }

        try {
            $product->delete();
            return redirect()->back()->with(["success", "Product deleted"]);
        } catch (\Exception $e) {
            return redirect()->back()->with(["error", "Product deletion failed"]);
        }
    }

    public function deleteImage(Request $request, $GTIN) {
        $product = Product::query()->where('GTIN', $GTIN)->first();

        try {
            $product->image_url = "";
            $product->save();
            return redirect()->back()->with(["success", "Product image deleted"]);
        } catch (\Exception $e) {
            return redirect()->back()->with(["error", "Product image deletion failed"]);
        }
    }

    public function uploadImage(Request $request, $GTIN): JsonResponse
    {
        $file = $request->file("file");
        $filePath = $file->store('images', 'public');
        $fileUrl = Storage::url($filePath);


        $product = Product::query()->where('GTIN', $GTIN)->first();

        try {
            $product->image_url = $fileUrl;
            $product->save();
            return response()->json(["success" => "Product image uploaded"]);
        } catch (\Exception $e) {
            return response()->json(["error" => "Product image upload failed"]);
        }
    }
}
