<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ProductController extends Controller
{
    public function getProducts(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $products = Product::with('company')->get();
        $products = $products->map(function ($product) {
            if ($product->company) {
                $product->company_name = $product->company->name;
            } else {
                $product->company_name = 'Нет компании';
            }

            unset($product->company);

            return $product;
        });

        return view('products')->with(['products' => $products]);
    }

    public function createProduct(Request $request): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $data = $request->validate([
            "name" => "required|string",
            "french_name" => "required|string",
            "GTIN" => "required|string",
            "description" => "required|string",
            "french_description" => "required|string",
            "brand_name" => "required|string",
            "origin_country" => "required|string",
            "gross_weight" => "required|string",
            "net_weight" => "required|string",
            "weight_unit" => "required|string",
        ]);

        $exist = Product::query()->where("GTIN", $data["GTIN"])->exists();
        if ($exist) {
            return redirect()->back()->with(["error" => "GTIN already exist"]);
        }

        try {
            Product::query()->create($data);
            return redirect("/products")->with(["success" => "Product created"]);
        } catch (\Exception $e) {
            return redirect("/products")->with(["error" => $e->getMessage()]);
        }
    }

    public function updateProduct(Request $request, $GTIN): RedirectResponse
    {
        $data = $request->validate([
            "name" => "required|string",
            "french_name" => "required|string",
            "description" => "required|string",
            "french_description" => "required|string",
            "brand_name" => "required|string",
            "origin_country" => "required|string",
            "gross_weight" => "required|string",
            "net_weight" => "required|string",
            "weight_unit" => "required|string",
        ]);

        $product = Product::query()->where("GTIN", $GTIN)->first();
        if (!$product) {
            return redirect()->back()->with(["error" => "Product not found"]);
        }

        $product->update($data);
        $product->save();

        return redirect()->back()->with(["success" => "Product updated"]);
    }

    public function changeStatus($GTIN): \Illuminate\Http\JsonResponse
    {
        $product = Product::query()->where("GTIN", $GTIN)->first();
        if (!$product) {
            return response()->json(["error" => "Product not found"], 404);
        }

        try {
            $product->hidden = $product->hidden === 0 ? 1 : 0;
            $product->save();
            return response()->json(["message" => "Product updated successfully"]);
        } catch (\Exception $exception) {
            return response()->json(["error" => $exception->getMessage()], 500);
        }
    }

    public function getProduct($GTIN): \Illuminate\View\View|Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $product = Product::query()->where("GTIN", $GTIN)->with("company")->first();
        if (!$product) {
            return redirect()->back()->with("errors", "Product not found");
        }

        $product_data = $product->toArray();

        if (isset($product->company)) {
            $product_data['company_name'] = $product->company->name;
        }

        return view('product')->with(["product" => $product_data]);
    }

    public function deleteProduct($GTIN): RedirectResponse {
        $product = Product::query()->where("GTIN", $GTIN)->first();
        if (!$product) {
            return redirect()->back()->with("errors", "Product not found");
        }

        if ($product->hidden === 0) {
            return redirect()->back()->with("errors", "Product is active");
        }

        $product->delete();
        return redirect("/products")->with(["success" => "Product deleted"]);
    }

    public function deleteImage($GTIN): RedirectResponse
    {
        $product = Product::query()->where("GTIN", $GTIN)->first();
        if (!$product) {
            return redirect()->back()->with("errors", "Product not found");
        }

        $product->image_url = "";
        $product->save();

        return redirect()->back()->with(["success" => "Product image deleted"]);
    }
}
