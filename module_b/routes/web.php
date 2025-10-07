<?php

use App\Http\Controllers\CheckerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get("/login", function () {
    return view("login");
})->name("login");
Route::post("/login", [UserController::class, "login"]);

Route::middleware("auth:sanctum")->group(function () {
    Route::prefix("products")->group(function () {
        Route::get("/", [ProductController::class, "getProducts"]);
        Route::post("/create", [ProductController::class, "createProduct"]);
        Route::post("/{GTIN}/edit", [ProductController::class, "updateProduct"]);
        Route::delete("/{GTIN}/delete", [ProductController::class, "deleteProduct"]);
        Route::delete("/{GTIN}/delete-image", [ProductController::class, "deleteImage"]);
        Route::get("/{GTIN}", [ProductController::class, "getProduct"]);
        Route::post("/{GTIN}/change-status", [ProductController::class, "changeStatus"]);
    });
    Route::get("/checker", function () {
        return view("checkGTIN");
    });
    Route::post("/checker", [CheckerController::class, "checkGTIN"]);
});
