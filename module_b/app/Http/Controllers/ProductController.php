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
        $product = Product::query()->where("GTIN", $GTIN)->first();
        if (!$product) {
            return redirect()->back()->with("errors", "Product not found");
        }
        $product->company_name = $product->company->name;

        return view('product')->with(["product" => $product]);
    }
}
