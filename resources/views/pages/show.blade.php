@extends('layouts.main')

@section('title', $page->title . ' | ' . config('app.name', 'SkyBridge'))
@section('description', Str::limit(strip_tags($page->content ?? $page->company_description_en ?? $page->contact_description_en ?? ''), 160))

@push('schema')
@php
$schemaData = [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    'name' => $page->title,
    'description' => Str::limit(strip_tags($page->content ?? ''), 160),
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'SkyBridge',
        'logo' => [
            '@type' => 'ImageObject',
            'url' => asset('images/logo.svg')
        ]
    ]
];
@endphp
<script type="application/ld+json">
{!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('breadcrumbs')
<li>
    <div class="flex items-center">
        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
        </svg>
        <a href="{{ route('pages.show', $page->slug) }}" class="ml-1 text-sm font-medium text-primary-700 hover:text-primary-900 md:ml-2 dark:text-primary-400 dark:hover:text-white">{{ $page->title }}</a>
    </div>
</li>
@endsection

@section('content')
<div class="container mx-auto px-4">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-dark-800 rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
            <div class="px-6 py-6 border-b border-gray-200 dark:border-dark-700 bg-gradient-to-r from-background-50 to-accent-50 dark:from-dark-700 dark:to-dark-600 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary-500 rounded-full -mt-16 -mr-16 opacity-10"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-secondary-500 rounded-full -mb-12 -ml-12 opacity-10"></div>
                <div class="relative z-10">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-light-100 heading-gradient">{{ $page->title }}</h1>
                </div>
            </div>
            
            <div class="px-6 py-8">
                <!-- About Us Page -->
                @if($page->type === \App\Models\Page::TYPE_ABOUT_US)
                    <div class="prose prose-lg max-w-none fade-in dark:prose-invert">
                        @if($page->company_name_en || $page->company_name_ar)
                            <h2 class="text-2xl font-bold text-primary-800 dark:text-primary-400 mt-2">{{ app()->getLocale() === 'ar' ? $page->company_name_ar : $page->company_name_en }}</h2>
                        @endif
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                            @if($page->founded_year)
                                <div class="bg-background-50 dark:bg-dark-700 p-4 rounded-lg border border-background-200 dark:border-dark-600">
                                    <h3 class="font-semibold text-primary-700 dark:text-primary-400">{{ __('website.founded') }}</h3>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-light-100 mt-1">{{ $page->founded_year }}</p>
                                </div>
                            @endif
                            
                            @if($page->location_en || $page->location_ar)
                                <div class="bg-background-50 dark:bg-dark-700 p-4 rounded-lg border border-background-200 dark:border-dark-600">
                                    <h3 class="font-semibold text-primary-700 dark:text-primary-400">{{ __('website.location') }}</h3>
                                    <p class="text-gray-900 dark:text-light-100 mt-1">{{ app()->getLocale() === 'ar' ? $page->location_ar : $page->location_en }}</p>
                                </div>
                            @endif
                            
                            @if($page->company_description_en || $page->company_description_ar)
                                <div class="bg-background-50 p-4 rounded-lg border border-background-200">
                                    <h3 class="font-semibold text-primary-700 dark:text-primary-400">{{ __('website.company') }}</h3>
                                    <p class="text-gray-900 dark:text-light-100 mt-1 line-clamp-3">{{ strip_tags(app()->getLocale() === 'ar' ? $page->company_description_ar : $page->company_description_en) }}</p>
                                </div>
                            @endif
                        </div>
                        
                        @if($page->company_description_en || $page->company_description_ar)
                            <div class="mt-8">
                                <h3 class="text-xl font-bold text-primary-800 mb-3">{{ __('website.company') }}</h3>
                                <div class="prose max-w-none">
                                    {!! app()->getLocale() === 'ar' ? $page->company_description_ar : $page->company_description_en !!}
                                </div>
                            </div>
                        @endif
                        
                        @if($page->history_en || $page->history_ar)
                            <div class="mt-8">
                                <h3 class="text-xl font-bold text-primary-800 dark:text-light-100 mb-3">{{ __('website.history') }}</h3>
                                <div class="prose max-w-none">
                                    {!! app()->getLocale() === 'ar' ? $page->history_ar : $page->history_en !!}
                                </div>
                            </div>
                        @endif
                    </div>
                
                <!-- Contact Us Page -->
                @elseif($page->type === \App\Models\Page::TYPE_CONTACT_US)
                    <div class="prose prose-lg max-w-none fade-in">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                            <div class="scroll-reveal">
                                <h2 class="text-2xl font-bold text-primary-800 dark:text-light-100 mb-6">{{ __('website.contact_information') }}</h2>
                                
                                <div class="space-y-5">
                                    @if($page->email)
                                        <div class="flex items-start p-4 bg-background-50 dark:bg-dark-700 rounded-lg hover:bg-background-100 dark:hover:bg-dark-600 transition-colors duration-200 hover-lift">
                                            <div class="flex-shrink-0">
                                                <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/40 rounded-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex-1">
                                                <p class="text-sm font-semibold text-gray-900 dark:text-light-100 mb-1">{{ __('website.email') }}</p>
                                                <a href="mailto:{{ $page->email }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 font-medium transition-colors">{{ $page->email }}</a>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($page->phone)
                                        <div class="flex items-start p-4 bg-background-50 dark:bg-dark-700 rounded-lg hover:bg-background-100 dark:hover:bg-dark-600 transition-colors duration-200 hover-lift">
                                            <div class="flex-shrink-0">
                                                <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/40 rounded-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex-1">
                                                <p class="text-sm font-semibold text-gray-900 dark:text-light-100 mb-1">{{ __('website.phone') }}</p>
                                                <a dir="ltr" href="tel:{{ $page->phone }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 font-medium transition-colors">{{ $page->phone }}</a>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($page->whatsapp)
                                        <div class="flex items-start p-4 bg-background-50 rounded-lg hover:bg-background-100 transition-colors duration-200 hover-lift">
                                            <div class="flex-shrink-0">
                                                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/40 rounded-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex-1">
                                                <p class="text-sm font-semibold text-gray-900 dark:text-light-100 mb-1">{{ __('website.whatsapp') }}</p>
                                                <a dir="ltr" href="https://wa.me/{{ $page->whatsapp }}" target="_blank" rel="noopener noreferrer" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 font-medium transition-colors">{{ $page->whatsapp }}</a>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($page->address_en || $page->address_ar)
                                        <div class="flex items-start p-4 bg-background-50 rounded-lg hover:bg-background-100 transition-colors duration-200 hover-lift">
                                            <div class="flex-shrink-0">
                                                <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex-1">
                                                <p class="text-sm font-semibold text-gray-900 dark:text-light-100 mb-1">{{ __('website.address') }}</p>
                                                <p class="text-gray-700 dark:text-light-300 leading-relaxed">{{ app()->getLocale() === 'ar' ? $page->address_ar : $page->address_en }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                                @if($page->contact_description_en || $page->contact_description_ar)
                                    <div class="mt-8">
                                        <div class="prose max-w-none">
                                            {!! app()->getLocale() === 'ar' ? $page->contact_description_ar : $page->contact_description_en !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            @if($page->latitude && $page->longitude)
                                <div class="scroll-reveal">
                                    <h2 class="text-2xl font-bold text-primary-800 dark:text-light-100 mb-4">{{ __('website.find_us') }}</h2>
                                    <div class="bg-gray-100 dark:bg-dark-600 rounded-xl overflow-hidden w-full h-80 md:h-96 relative shadow-lg hover:shadow-xl transition-shadow duration-300">
                                        <!-- Interactive Google Maps Embed -->
                                        <div id="map-container" class="w-full h-full">
                                            @php
                                                $apiKey = config('services.google_maps.key', '');
                                                $mapUrl = $apiKey 
                                                    ? "https://www.google.com/maps/embed/v1/place?key={$apiKey}&q={$page->latitude},{$page->longitude}&zoom=" . ($page->map_zoom ?? 15) . "&maptype=roadmap"
                                                    : "https://maps.google.com/maps?q={$page->latitude},{$page->longitude}&z=" . ($page->map_zoom ?? 15) . "&output=embed";
                                            @endphp
                                            <iframe 
                                                id="google-map-iframe"
                                                class="w-full h-full border-0"
                                                loading="lazy"
                                                allowfullscreen
                                                referrerpolicy="no-referrer-when-downgrade"
                                                src="{{ $mapUrl }}"
                                                title="Google Maps - {{ app()->getLocale() === 'ar' ? $page->address_ar : $page->address_en }}">
                                            </iframe>
                                        </div>
                                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/60 to-transparent text-white p-4 pointer-events-none">
                                            <p class="text-sm font-medium text-center">
                                                {{ app()->getLocale() === 'ar' ? $page->address_ar : $page->address_en }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $page->latitude }},{{ $page->longitude }}" 
                                           target="_blank" 
                                           rel="noopener noreferrer"
                                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white rounded-lg text-sm font-medium transition-all duration-200 shadow-md hover:shadow-lg hover-lift w-full sm:w-auto justify-center">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                            {{ __('website.view_on_google_maps') }}
                                        </a>
                                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $page->latitude }},{{ $page->longitude }}" 
                                           target="_blank" 
                                           rel="noopener noreferrer"
                                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-dark-700 hover:bg-gray-50 dark:hover:bg-dark-600 text-primary-600 dark:text-primary-400 border-2 border-primary-600 dark:border-primary-500 rounded-lg text-sm font-medium transition-all duration-200 hover-lift w-full sm:w-auto justify-center">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                            </svg>
                                            {{ __('website.get_directions') }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                
                <!-- General Pages (Privacy Policy, Terms, FAQ, etc.) -->
                @else
                    <div class="prose prose-lg max-w-none fade-in">
                        {!! $page->content !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .heading-gradient {
        background: linear-gradient(135deg, #8B5A2B 0%, #D2691E 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* RTL adjustments */
    [dir="rtl"] .ml-3 {
        margin-left: 0;
        margin-right: 0.75rem;
    }
    
    [dir="rtl"] .mr-2 {
        margin-right: 0;
        margin-left: 0.5rem;
    }
    
    [dir="rtl"] .ml-1 {
        margin-left: 0;
        margin-right: 0.25rem;
    }
</style>
@endsection