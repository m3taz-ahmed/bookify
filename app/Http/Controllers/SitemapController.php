<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SitemapService;

class SitemapController extends Controller
{
    protected $sitemapService;
    
    public function __construct(SitemapService $sitemapService)
    {
        $this->sitemapService = $sitemapService;
    }
    
    /**
     * Display the sitemap.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sitemap = $this->sitemapService->generateSitemap();
        
        return response($sitemap, 200)
            ->header('Content-Type', 'text/xml');
    }
}