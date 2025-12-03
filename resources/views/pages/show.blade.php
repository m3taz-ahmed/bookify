@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumbs -->
        <x-breadcrumbs :pages="[['title' => $page->title]]" />
        
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-6 border-b border-gray-200 bg-gradient-to-r from-background-50 to-accent-50 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary-500 rounded-full -mt-16 -mr-16 opacity-10"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-secondary-500 rounded-full -mb-12 -ml-12 opacity-10"></div>
                <div class="relative z-10">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $page->title }}</h1>
                </div>
            </div>
            
            <div class="px-6 py-8">
                <!-- About Us Page -->
                @if($page->type === \App\Models\Page::TYPE_ABOUT_US)
                    <div class="space-y-8">
                        <!-- Company Info -->
                        @if($page->company_name_en || $page->founded_year || $page->location_en)
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('website.company_information') }}</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @if($page->company_name_en)
                                <div class="flex items-center">
                                    <div class="bg-blue-100 p-3 rounded-lg mr-4">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">{{ __('website.company_name') }}</p>
                                        <p class="font-medium">{{ app()->getLocale() === 'ar' ? $page->company_name_ar : $page->company_name_en }}</p>
                                    </div>
                                </div>
                                @endif

                                @if($page->founded_year)
                                <div class="flex items-center">
                                    <div class="bg-green-100 p-3 rounded-lg mr-4">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">{{ __('website.founded') }}</p>
                                        <p class="font-medium">{{ $page->founded_year }}</p>
                                    </div>
                                </div>
                                @endif

                                @if($page->location_en)
                                <div class="flex items-center">
                                    <div class="bg-purple-100 p-3 rounded-lg mr-4">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">{{ __('website.location') }}</p>
                                        <p class="font-medium">{{ app()->getLocale() === 'ar' ? $page->location_ar : $page->location_en }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Company Description -->
                        @if($page->company_description_en)
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('website.about_our_company') }}</h2>
                            <div class="prose prose-lg max-w-none">
                                {!! app()->getLocale() === 'ar' ? $page->company_description_ar : $page->company_description_en !!}
                            </div>
                        </div>
                        @endif

                        <!-- History -->
                        @if($page->history_en)
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('website.our_history') }}</h2>
                            <div class="prose prose-lg max-w-none">
                                {!! app()->getLocale() === 'ar' ? $page->history_ar : $page->history_en !!}
                            </div>
                        </div>
                        @endif
                    </div>
                @elseif($page->type === \App\Models\Page::TYPE_CONTACT_US)
                    <div class="space-y-8">
                        <!-- Contact Information -->
                        @if($page->email || $page->phone || $page->whatsapp || $page->address_en)
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('website.contact_information') }}</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if($page->email)
                                <div class="flex items-start">
                                    <div class="bg-blue-100 p-3 rounded-lg mr-4">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">{{ __('website.email') }}</p>
                                        <a href="mailto:{{ $page->email }}" class="font-medium text-blue-600 hover:underline">{{ $page->email }}</a>
                                    </div>
                                </div>
                                @endif

                                @if($page->phone)
                                <div class="flex items-start">
                                    <div class="bg-green-100 p-3 rounded-lg mr-4">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">{{ __('website.phone') }}</p>
                                        <a href="tel:{{ $page->phone }}" class="font-medium">{{ $page->phone }}</a>
                                    </div>
                                </div>
                                @endif

                                @if($page->whatsapp)
                                <div class="flex items-start">
                                    <div class="bg-green-100 p-3 rounded-lg mr-4">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">{{ __('website.whatsapp') }}</p>
                                        <a href="https://wa.me/{{ str_replace(['+', ' ', '-', '(', ')'], '', $page->whatsapp) }}" class="font-medium text-green-600 hover:underline" target="_blank">{{ $page->whatsapp }}</a>
                                    </div>
                                </div>
                                @endif

                                @if($page->address_en)
                                <div class="flex items-start">
                                    <div class="bg-purple-100 p-3 rounded-lg mr-4">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">{{ __('website.address') }}</p>
                                        <p class="font-medium">{{ app()->getLocale() === 'ar' ? $page->address_ar : $page->address_en }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Contact Description -->
                        @if($page->contact_description_en)
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('website.get_in_touch') }}</h2>
                            <div class="prose prose-lg max-w-none">
                                {!! app()->getLocale() === 'ar' ? $page->contact_description_ar : $page->contact_description_en !!}
                            </div>
                        </div>
                        @endif

                        <!-- Map -->
                        @if($page->latitude && $page->longitude)
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('website.our_location') }}</h2>
                            <div class="rounded-xl overflow-hidden shadow-lg">
                                <iframe 
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3621.957070963943!2d{{ $page->longitude }}!3d{{ $page->latitude }}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2z{{ $page->latitude }}!5e0!3m2!1sen!2s!4v1609459200000!5m2!1sen!2s" 
                                    width="100%" 
                                    height="400" 
                                    frameborder="0" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    aria-hidden="false" 
                                    tabindex="0">
                                </iframe>
                            </div>
                        </div>
                        @endif
                    </div>
                @else
                    <!-- General Pages (Privacy Policy, Terms, FAQ, etc.) -->
                    <div class="prose prose-lg max-w-none">
                        {!! $page->content !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection