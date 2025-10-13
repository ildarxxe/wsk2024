<?php

use App\Http\Controllers\HeritageController;
use Illuminate\Support\Facades\Route;

Route::redirect("/", "/01_module_C/heritages");

Route::prefix("01_module_C")->group(function () {
    Route::get("/heritages/tags/{tag}", [HeritageController::class, "handleTag"])->name("heritage.tags");
    Route::get("/heritages/{path?}", [HeritageController::class, "handlePath"])
        ->where("path", ".*")
        ->name("heritage.path");
});
