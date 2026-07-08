<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index()
    {
        $xml = Cache::remember('sitemap', 3600, function () {
            $baseUrl = config('app.url');
            $pages = [];

            // Статика
            $staticPages = [
                ['/', '1.0', 'daily'],
                ['/catalog', '0.9', 'daily'],
                ['/about', '0.7', 'monthly'],
                ['/contacts', '0.7', 'monthly'],
            ];

            foreach ($staticPages as [$path, $priority, $freq]) {
                $pages[] = [
                    'loc' => $baseUrl . $path,
                    'priority' => $priority,
                    'changefreq' => $freq,
                    'lastmod' => now()->toDateString(),
                ];
            }

            // Категории
            Category::where('is_active', true)->each(function ($category) use ($baseUrl, &$pages) {
                $pages[] = [
                    'loc' => $baseUrl . '/catalog?category=' . $category->slug,
                    'priority' => '0.8',
                    'changefreq' => 'weekly',
                    'lastmod' => $category->updated_at->toDateString(),
                ];
            });

            // Товары
            Product::where('status', 'active')->each(function ($product) use ($baseUrl, &$pages) {
                $pages[] = [
                    'loc' => $baseUrl . '/product/' . $product->slug,
                    'priority' => '0.9',
                    'changefreq' => 'daily',
                    'lastmod' => $product->updated_at->toDateString(),
                ];
            });

            // Генерация XML
            $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

            foreach ($pages as $page) {
                $xml .= "\t<url>\n";
                $xml .= "\t\t<loc>" . e($page['loc']) . "</loc>\n";
                $xml .= "\t\t<lastmod>{$page['lastmod']}</lastmod>\n";
                $xml .= "\t\t<changefreq>{$page['changefreq']}</changefreq>\n";
                $xml .= "\t\t<priority>{$page['priority']}</priority>\n";
                $xml .= "\t</url>\n";
            }

            $xml .= '</urlset>';

            return $xml;
        });

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
}
