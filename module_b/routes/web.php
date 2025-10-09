<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->group(function () {
    Route::get("/", function () {
        return view('home');
    });

    Route::get("/products{format?}", [ProductController::class, "getProducts"])
        ->where('format', '(\.json)?');

    Route::get("/companies{format?}", [CompanyController::class, "getCompanies"])
        ->where('format', '(\.json)?');

    Route::prefix("products")->group(function () {
        Route::get("/new", function() {
            return view("createProduct");
        });
        Route::post("/create", [ProductController::class, "createProduct"]);

        Route::post("/{GTIN}/hide", [ProductController::class, "hideProduct"]);
        Route::post("/{GTIN}/edit", [ProductController::class, "updateProduct"]);
        Route::delete("/{GTIN}/delete", [ProductController::class, "deleteProduct"]);
        Route::delete("/{GTIN}/delete-image", [ProductController::class, "deleteImage"]);
        Route::post("/{GTIN}/upload-image", [ProductController::class, "uploadImage"]);

        Route::get("/{GTIN}{format?}", [ProductController::class, "getProduct"])
        ->where("format", "(\.json)?");
    });

    Route::prefix("companies")->group(function () {
        Route::get("/new", function() {
            return view("createCompany");
        });
        Route::post("/create", [CompanyController::class, "createCompany"]);
        Route::post("/{id}/edit", [CompanyController::class, "updateCompany"]);
        Route::post("/{id}/deactivate", [CompanyController::class, "deactivateCompany"]);
        Route::get("/{id}{format?}", [CompanyController::class, "getCompany"])->where("format", "(\.json)?");
    });
});

Route::get("/login", function () {
    return view("login");
})->name("login");

Route::post("/login", [UserController::class, 'login']);
