<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class ContentService {
    protected string $contentPath = "content-pages";

    public function scanDirectory(string $path = ''): array {
        $fullPath = base_path( $this->contentPath . '/' . $path);

        if (!File::isDirectory($fullPath)) {
            return [];
        }

        $items = [];
        $filesAndFolders = File::files($fullPath);
        $filesAndFolders = array_merge($filesAndFolders, File::directories($fullPath));

        $today = Carbon::today();

        foreach ($filesAndFolders as $item) {
            $name = $item->getFilename();
            $type = $item->getType();

            if ($type == "dir") {
                if ($name === "images" && $path === "") {
                    continue;
                }
                $items[] = [
                    "name" => $name,
                    "type" => $type,
                    "path" => $path ? $path . "/" . $name : $name,
                    "title" => $name,
                    "summary" => null,
                    "date" => null,
                ];
                continue;
            }
            if ($type == "file" && in_array($item->getExtension(), ["html", "txt"])) {
                $data = $this->parseContent($item->getPathname(), $name);

                if ($this->isPageValid($data, $today)) {
                    $items[] = [
                        "name" => $name,
                        "type" => "page",
                        "path" => $path ? $path . "/" . $data['slug'] : $data['slug'],
                        "title" => $data['metadata']['title'] ?? $data['default_title'],
                        "summary" => $data['metadata']['summary'] ?? "No summary available.",
                        "date" => $data['date'],
                        "slug" => $data['slug'],
                        "full_filename" => $name,
                    ];
                }
            }
        }

        return $items;
    }

    public function parseContent(string $fullPath, string $filename): array {
        $content = File::get($fullPath);
        $metadata = [];
        $mainContent = $content;

        if(preg_match('/^---\s*\n(.*?)\n---\s*\n/s', $content, $matches)) {
            $frontMatterBlock = $matches[1];
            $mainContent = substr($content, strlen($matches[0]));

            $lines = explode("\n", trim($frontMatterBlock));
            foreach ($lines as $line) {
                if (str_contains($line, ":")) {
                    list($key, $value) = explode(":", $line, 2);
                    $metadata[trim($key)] = trim($value);
                }
            }
        }

        $parts = explode("-", $filename, 4);
        $date = (count($parts) >= 3 ? $parts[0] . "-" . $parts[1] . "-" . $parts[2] : null);

        if ($date) {
            $slugPart = substr($filename, 11);
        } else {
            $slugPart = $filename;
        }

        $slug = pathinfo($slugPart, PATHINFO_FILENAME);
        $defaultTitle = str_replace('-', ' ', $slug);

        return [
            "metadata" => $metadata,
            "main_content" => trim($mainContent),
            "date" => $date,
            "slug" => $slug,
            "default_title" => ucwords($defaultTitle),
            "extension" => pathinfo($filename, PATHINFO_EXTENSION),
        ];
    }

    protected function isPageValid(array $data, Carbon $today): bool {
        if (!$data['date'] || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['date'])) {
            return false;
        }

        try {
            if (Carbon::parse($data['date'])->isFuture()) {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }

        $isDraft = strtolower($data['metadata']['draft'] ?? 'false');
        if ($isDraft == "true") {
            return false;
        }

        return true;
    }
}
