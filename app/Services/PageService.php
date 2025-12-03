<?php

namespace App\Services;

use App\Models\Page;

class PageService
{
    /**
     * Get a page by slug
     *
     * @param string $slug
     * @return Page|null
     */
    public function getPageBySlug(string $slug): ?Page
    {
        return Page::where('slug', $slug)
            ->active()
            ->first();
    }
    
    /**
     * Get all active pages
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllActivePages()
    {
        return Page::active()
            ->orderBy('title_en')
            ->get();
    }
    
    /**
     * Get pages by type
     *
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPagesByType(string $type)
    {
        return Page::where('type', $type)
            ->active()
            ->get();
    }
    
    /**
     * Get navigation menu items
     *
     * @return array
     */
    public function getNavigationMenu(): array
    {
        $pages = Page::active()
            ->whereIn('type', [
                Page::TYPE_ABOUT_US,
                Page::TYPE_CONTACT_US,
                Page::TYPE_PRIVACY_POLICY,
                Page::TYPE_TERMS_CONDITIONS,
                Page::TYPE_FAQ
            ])
            ->orderBy('title_en')
            ->get();
        
        $menu = [];
        
        foreach ($pages as $page) {
            $menu[] = [
                'title' => $page->title,
                'url' => route('pages.show', $page->slug),
                'type' => $page->type
            ];
        }
        
        return $menu;
    }
}