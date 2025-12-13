<!-- Footer -->
<footer class="bg-gradient-to-br from-dark-900 via-dark-800 to-dark-900 mt-20 relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-0 left-0 w-96 h-96 bg-primary-500 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-secondary-500 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
            <!-- Brand Column -->
            <div class="lg:col-span-1">
                <div class="flex items-center mb-6">
                    <a href="{{ route('booking-welcome') }}" class="flex items-center group">
                        {{-- Conditional logo based on language and theme --}}
                        @php
                            $currentLocale = app()->getLocale();
                            $isDarkMode = isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'true';
                            
                            if ($currentLocale === 'ar') {
                                $logoPath = $isDarkMode ? 'images/logo/logo04.png' : 'images/logo/logo03.png';
                            } else {
                                $logoPath = $isDarkMode ? 'images/logo/logo02.png' : 'images/logo/logo01.png';
                            }
                        @endphp
                        <img src="{{ asset($logoPath) }}" alt="SkyBridge Logo" class="h-16 w-auto transition-transform duration-300 group-hover:scale-110" style="filter: drop-shadow(0 0 2px rgba(0,0,0,0.5));" loading="lazy">
                        <span class="ml-2 text-2xl font-bold">
                            <span style="color: #79878C" class="transition-colors duration-300 group-hover:text-primary-400">Sky</span>
                            <span style="color: #ffffff" class="transition-colors duration-300 group-hover:text-primary-300">Bridge</span>
                        </span>
                    </a>
                </div>
                <p class="text-dark-300 text-sm leading-relaxed mb-6">
                    {{ __('website.our_platform') }}
                </p>
                
                <!-- Social Media Links -->
                <div class="flex items-center space-x-4">
                    <a href="#" target="_blank" class="w-10 h-10 rounded-full bg-dark-800 hover:bg-primary-600 flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg group" aria-label="Facebook">
                        <svg class="w-5 h-5 text-dark-300 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" target="_blank" class="w-10 h-10 rounded-full bg-dark-800 hover:bg-primary-600 flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg group" aria-label="Twitter">
                        <svg class="w-5 h-5 text-dark-300 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                    <a href="#" target="_blank" class="w-10 h-10 rounded-full bg-dark-800 hover:bg-primary-600 flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg group" aria-label="Instagram">
                        <svg class="w-5 h-5 text-dark-300 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="#" target="_blank" class="w-10 h-10 rounded-full bg-dark-800 hover:bg-primary-600 flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg group" aria-label="LinkedIn">
                        <svg class="w-5 h-5 text-dark-300 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Quick Links Column -->
            <div>
                <h3 class="text-base font-bold text-white mb-6 uppercase tracking-wider">
                    {{ __('website.company') }}
                </h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('pages.show', 'about-us') }}" class="text-dark-300 hover:text-primary-300 text-sm transition-colors duration-200 flex items-center group">
                            <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            {{ __('website.about') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pages.show', 'contact-us') }}" class="text-dark-300 hover:text-primary-300 text-sm transition-colors duration-200 flex items-center group">
                            <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            {{ __('website.contact_us') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.bookings.create') }}" class="text-dark-300 hover:text-primary-300 text-sm transition-colors duration-200 flex items-center group">
                            <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            {{ __('website.book_appointment') }}
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Legal Column -->
            <div>
                <h3 class="text-base font-bold text-white mb-6 uppercase tracking-wider">
                    {{ __('website.legal') }}
                </h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('pages.show', 'privacy-policy') }}" class="text-dark-300 hover:text-primary-300 text-sm transition-colors duration-200 flex items-center group">
                            <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            {{ __('website.privacy') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pages.show', 'terms-and-conditions') }}" class="text-dark-300 hover:text-primary-300 text-sm transition-colors duration-200 flex items-center group">
                            <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            {{ __('website.terms') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pages.show', 'faq') }}" class="text-dark-300 hover:text-primary-300 text-sm transition-colors duration-200 flex items-center group">
                            <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            {{ __('website.faq') }}
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info Column -->
            <div dir="ltr">
                <h3 class="text-base font-bold text-white mb-6 uppercase tracking-wider">
                    {{ __('website.contact_us') }}
                </h3>
                @php
                    $contactPage = \App\Models\Page::where('type', \App\Models\Page::TYPE_CONTACT_US)->where('is_active', true)->first();
                @endphp
                @if($contactPage)
                    <ul class="space-y-4">
                        @if($contactPage->email)
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-primary-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <a href="mailto:{{ $contactPage->email }}" class="text-dark-300 hover:text-primary-300 text-sm transition-colors duration-200">
                                    {{ $contactPage->email }}
                                </a>
                            </li>
                        @endif
                        @if($contactPage->phone)
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-primary-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <a href="tel:{{ $contactPage->phone }}" class="text-dark-300 hover:text-primary-300 text-sm transition-colors duration-200">
                                    {{ $contactPage->phone }}
                                </a>
                            </li>
                        @endif
                        @if($contactPage->whatsapp)
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-primary-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                <a href="https://wa.me/{{ $contactPage->whatsapp }}" target="_blank" class="text-dark-300 hover:text-primary-300 text-sm transition-colors duration-200">
                                    {{ $contactPage->whatsapp }}
                                </a>
                            </li>
                        @endif
                    </ul>
                @endif
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="mt-12 pt-8 border-t border-dark-700">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-dark-400 text-sm text-center md:text-left">
                    &copy; {{ date('Y') }} <span class="font-semibold text-white">SkyBridge</span>. {{ __('website.all_rights_reserved') }}
                </p>
                <div class="flex items-center space-x-6 text-sm text-dark-400">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-primary-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Made with <span class="text-primary-400 mx-1">❤</span> for you
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>