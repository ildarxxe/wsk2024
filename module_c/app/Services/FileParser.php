<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FileParser {
    protected string $contentPath;
    public function __construct()
    {
        $this->contentPath = base_path("content-pages");
    }

    public function getListing(string $path = ''): array {
        $fullPath = $this->contentPath . "/" . $path;
        $items = [];

        if (!File::isDirectory($fullPath)) {
            return [];
        }

        $content = File::files($fullPath);
        $directories = File::directories($fullPath);

        foreach ($directories as $dir) {
            $folderName = basename($dir);
            $items[] = [
                "type" => "folder",
                "name" => $folderName,
                "path_slug" => trim(implode("/", array_filter([$path, $folderName])), "/"),
                "title" => $folderName,
            ];
        }

        foreach ($content as $file) {
            $filename = $file->getFilename();
            $extension = $file->getExtension();

            if (!in_array($extension, ["html", "txt"])) {
                continue;
            }

            $itemData = $this->fileParse($path, $filename);

            if ($itemData["is_draft"] || $itemData['is_future']) {
                continue;
            }

            $items[] = $itemData;
        }

        usort($items, function ($a, $b) {
            if($a['type'] === "folder" && $b['type'] !== "folder") return -1;
            if($a['type'] !== "folder" && $b['type'] === "folder") return 1;

            if($a['type'] === "folder" && $b['type'] === "folder") {
                return strcmp($a["name"], $b["name"]);
            }

            return strcmp($b["slug_base"], $a["slug_base"]);
        });

        return $items;
    }

    public function findPageDataBySlug(string $relativePath, string $slug): array
    {
        $fullDirectoryPath = rtrim($this->contentPath, '/\\') . '/' . ltrim($relativePath, '/\\');

        if (!File::isDirectory($fullDirectoryPath)) {
            return [];
        }

        $files = File::files($fullDirectoryPath);

        foreach ($files as $file) {
            $fileName = $file->getFilename();

            $slugBase = $file->getFilenameWithoutExtension();
            $fileSlug = preg_replace('/^\d{4}-\d{2}-\d{2}-/', '', $slugBase);

            if ($fileSlug === $slug) {
                return $this->fileParse($relativePath, $fileName);
            }
        }

        return [];
    }

    public function fileParse(string $path, string $filename): array
    {
        $pathParts = [
            rtrim($this->contentPath, '/\\'),
            ltrim($path, '/\\'),
            $filename
        ];

        $fullPath = implode(DIRECTORY_SEPARATOR, array_filter($pathParts));

        if (!File::exists($fullPath)) {
            return [];
        }

        $content = File::get($fullPath);

        $slugBase = Str::beforeLast($filename, ".");
        $extension = Str::afterLast($filename, ".");

        $frontMatter = [];
        $mainContent = $content;
        $isDraft = false;
        $isFuture = false;
        $date = null;

        $dateString = Str::substr($slugBase, 0, 10);
        if(preg_match("/^\d{4}-\d{2}-\d{2}$/", $dateString)) {
            $date = Carbon::createFromFormat("Y-m-d", $dateString);
            $slug = Str::substr($slugBase, 11);
        } else {
            $slug = $slugBase;
        }

        if ($date && $date->isFuture()) {
            $isFuture = true;
        }

        if(Str::startsWith($content, "---")) {
            $parts = explode("---", $content, 3);
            if (count($parts) > 2) {
                $frontMatter = $this->parseFrontMatter($parts[1]);
                $mainContent = trim($parts[2]);
            }
        }

        if (isset($frontMatter['draft']) && Str::lower($frontMatter['draft']) === "true") {
            $isDraft = true;
        }

        $title = $this->determineTitle($mainContent, $frontMatter, $slug);

        return [
            "type" => "file",
            "title" => $title,
            "file_name" => $filename,
            "slug_base" => $slugBase,
            "path_slug" => trim(implode("/", array_filter([$path, $slug])), "/"),
            "extension" => $extension,
            "summary" => $frontMatter['summary'] ?? $title,
            "date" => $date ? $date->format("Y-m-d") : null,
            "tags" => $this->parseTags($frontMatter['tags'] ?? ""),
            "cover" => $frontMatter['cover'] ?? null,
            "is_draft" => $isDraft,
            "is_future" => $isFuture,
            "raw_content" => $mainContent,
        ];
    }

    protected function parseFrontMatter(string $block): array {
        $data = [];
        $lines = explode("\n", trim($block));

        foreach ($lines as $line) {
            if(str_contains($line, ":")) {
                list($key, $value) = explode(":", $line);
                $data[trim($key)] = trim($value);
            }
        }

        return $data;
    }

    protected function determineTitle($mainContent, $frontMatter, $slug) {
        if(!empty($frontMatter['title'])) {
            return $frontMatter['title'];
        };

        if(preg_match("/<h1[^>]*>(.*?)<\/h1>/i", $mainContent, $matches)) {
            return strip_tags($matches[1]);
        }

        if($slug) {
            return Str::title(str_replace("-", " ", $slug));
        }

        return "Untitled Page";
    }

    protected function parseTags($tagString): array {
        if (empty($tagString)) {
            return [];
        }

        return array_map("trim", explode(",", $tagString));
    }

    public function renderContent(array $pageData): string {
        $content = $pageData["raw_content"];
        $extension = $pageData["extension"];

        $content = preg_replace(
            '/(src|href)=["\'](?!http)(.*?)\.(png|jpg|jpeg|gif|webp)["\']/i',
            '\\1="' . asset('content-pages/images') . '/\\2.\\3"',
            $content
        );

        if($extension === "html") {
            return $content;
        }

        $lines = explode("\n", $content);
        $html = "";
        $isFirstParagraph = true;

        foreach ($lines as $line) {
            $line = trim($line);
            if(empty($line)) {
                continue;
            }

            if(preg_match('/^[^ ]+\.(png|jpg|jpeg|gif)$/i', $line)) {
                $html .= '<p class="content-image--wrapper"><img src="'. asset("content-pages/images/" . $line) . basename($line) . '" alt=""></p>';
            } else {
                if ($isFirstParagraph) {
                    $html .= '<p class="drop-cap-paragraph">' . $line . '</p>';
                    $isFirstParagraph = false;
                } else {
                    $html .= '<p>' . $line . '</p>';
                }
            }
        }
        return $html;
    }

    public function getPagesByTag($tag, $currentPath = "") {
        $fullPath = $this->contentPath . "/" . $currentPath;
        $foundPages = [];

        if (!File::isDirectory($fullPath)) {
            return [];
        }

        foreach (File::files($fullPath) as $file) {
            $fileName = $file->getFilename();
            $extension = $file->getExtension();

            if(!in_array($extension, ["html", "txt"])) {
                continue;
            }

            $itemData = $this->fileParse($currentPath, $fileName);

            if($itemData['is_draft'] || $itemData['is_future']) {
                continue;
            }

            $normalizedTags = array_map("strtolower", $itemData['tags']);
            if (in_array(strtolower($tag), $normalizedTags)) {
                $foundPages[] = $itemData;
            }
        }

        foreach (File::directories($fullPath) as $dir) {
            $folderName = basename($dir);
            $nextPath = trim(implode('/', array_filter([$currentPath, $folderName])), '/');
            $foundPages = array_merge($foundPages, $this->getPagesByTag($tag, $nextPath));
        }

        usort($foundPages, function ($a, $b) {
            return strcmp($b['slug_base'], $a['slug_base']);
        });

        return $foundPages;
    }
}
