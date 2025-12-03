<?php

namespace App\Services;

use App\Models\Page;

class SitemapService
{
    /**
     * Generate sitemap for pages
     *
     * @return array
     */
    public function generatePageSitemap(): array
    {
        $pages = Page::active()->get();
        
        $urls = [];
        
        foreach ($pages as $page) {
            $urls[] = [
                'loc' => route('pages.show', $page->slug),
                'lastmod' => $page->updated_at->toIso8601String(),
                'changefreq' => 'monthly',
                'priority' => 0.8
            ];
        }
        
        return $urls;
    }
    
    /**
     * Generate full sitemap
     *
     * @return string
     */
    public function generateSitemap(): string
    {
        $urls = $this->generatePageSitemap();
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($url['loc']) . "</loc>\n";
            $xml .= "    <lastmod>" . $url['lastmod'] . "</lastmod>\n";
            $xml .= "    <changefreq>" . $url['changefreq'] . "</changefreq>\n";
            $xml .= "    <priority>" . number_format($url['priority'], 1) . "</priority>\n";
            $xml .= "  </url>\n";
        }
        
        $xml .= '</urlset>';
        
        return $xml;
    }
}