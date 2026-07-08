<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearSitemapCache extends Command
{
    protected $signature = 'sitemap:clear';
    protected $description = 'Очистить кеш Sitemap';

    public function handle()
    {
        Cache::forget('sitemap');
        Cache::forget('sitemap_products');

        $this->info('Sitemap кеш очищен!');
    }
}
