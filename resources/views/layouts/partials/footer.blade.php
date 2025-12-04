<!-- Footer -->
<footer class="bg-dark-900 mt-12">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
        <div class="xl:grid xl:grid-cols-3 xl:gap-8">
            <div class="space-y-8 xl:col-span-1">
                <div class="flex items-center">
                    <a href="{{ route('booking-welcome') }}" class="flex items-center">
                        <img src="{{ asset('images/logo.svg') }}" alt="SkyBridge Logo" class="h-12 w-10 filter brightness-0 invert" style="filter: drop-shadow(0 0 2px rgba(0,0,0,0.5));">
                        <span class="ml-2 text-xl font-bold">
                            <span style="color: #536B7C">Sky</span>
                            <span style="color: #ffffff">Bridge</span>
                        </span>
                    </a>
                </div>
                <p class="text-dark-300 text-base">
                    {{ __('website.our_platform') }}
                </p>
            </div>
            <div class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
                <div class="md:grid md:grid-cols-2 md:gap-8">
                    
                    <div class="mt-12 md:mt-0">
                        <h3 class="text-sm font-semibold text-dark-300 tracking-wider uppercase">
                            {{ __('website.company') }}
                        </h3>
                        <ul class="mt-4 space-y-4">
                            <li>
                                <a href="{{ route('pages.show', 'about-us') }}" class="text-base text-dark-400 hover:text-primary-300">
                                    {{ __('website.about') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pages.show', 'contact-us') }}" class="text-base text-dark-400 hover:text-primary-300">
                                    {{ __('website.contact_us') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="md:grid md:grid-cols-2 md:gap-8">
                    <div>
                        <h3 class="text-sm font-semibold text-dark-300 tracking-wider uppercase">
                            {{ __('website.legal') }}
                        </h3>
                        <ul class="mt-4 space-y-4">
                            <li>
                                <a href="{{ route('pages.show', 'privacy-policy') }}" class="text-base text-dark-400 hover:text-primary-300">
                                    {{ __('website.privacy') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pages.show', 'terms-and-conditions') }}" class="text-base text-dark-400 hover:text-primary-300">
                                    {{ __('website.terms') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pages.show', 'faq') }}" class="text-base text-dark-400 hover:text-primary-300">
                                    {{ __('website.faq') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-12 border-t border-gray-700 pt-8">
            <p class="text-base text-dark-400 xl:text-center">
                &copy; {{ date('Y') }} SkyBridge. {{ __('website.all_rights_reserved') }}
            </p>
        </div>
    </div>
</footer>