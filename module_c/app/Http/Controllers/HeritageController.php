<?php

namespace App\Http\Controllers;

use App\Services\FileParser;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;

class HeritageController extends Controller
{
    protected FileParser $fileParser;
    public function __construct(FileParser $fileParser) {
        $this->fileParser = $fileParser;
    }
    public function handlePath($path = ""): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        if (empty($path)) {
            $listing = $this->fileParser->getListing("");
            return view("pages.listing", ["items" => $listing, "currentPath" => ""]);
        }

        if (Str::contains($path, '/')) {
            $folderPath = Str::beforeLast($path, '/');
            $fileSlug = Str::afterLast($path, '/');
        } else {
            $folderPath = "";
            $fileSlug = $path;
        }

        $fileData = $this->fileParser->findPageDataBySlug($folderPath, $fileSlug);

        if (!empty($fileData)) {
            $pageData = $this->fileParser->fileParse($folderPath, $fileData['file_name']);
            $pageData['render_content'] = $this->fileParser->renderContent($pageData);
            return view('pages.page', ['data' => $pageData]);
        }

        $listing = $this->fileParser->getListing($path);

        if (empty($listing) && $path !== "") {
            abort(404);
        }

        return view("pages.listing", [
            "items" => $listing,
            "currentPath" => $path
        ]);
    }

    public function handleTag($tag) {
        if(empty($tag)) {
            $listing = $this->fileParser->getListing("");
            return view("pages.listing", ["items" => $listing, "currentPath" => ""]);
        }

        $pagesData = $this->fileParser->getPagesByTag($tag);
        if (!empty($pagesData)) {
            return view("pages.listing", ["items" => $pagesData, "currentPath" => ""]);
        }

        return view("pages.listing", ["items" => [], "currentPath" => ""]);
    }
}
