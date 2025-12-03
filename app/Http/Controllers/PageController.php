<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Services\PageService;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{
    protected $pageService;
    
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
        
        // Share navigation menu with all views
        View::share('footerPages', $this->pageService->getNavigationMenu());
    }
    
    /**
     * Display the specified page.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $page = $this->pageService->getPageBySlug($slug);
        
        if (!$page) {
            abort(404);
        }
        
        return view('pages.show', compact('page'));
    }
}