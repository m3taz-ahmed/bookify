@extends('layouts.main')

@section('title', __('website.home') . ' | ' . config('app.name', 'SkyBridge'))
@section('description', __('website.tagline'))

@push('schema')
@php
    $phone = \App\Models\Page::where('type', 'contact_us')->where('is_active', true)->value('phone') ?? '+966123456789';
    $schemaData = [
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => 'SkyBridge Riyadh',
        'telephone' => $phone,
        'priceRange' => '$$',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'King Fahd Road',
            'addressLocality' => 'Riyadh',
            'postalCode' => '12211',
            'addressCountry' => 'SA'
        ]
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')
<div class="relative">
  <div class="absolute inset-0 z-0 overflow-hidden">
    <div class="hero-slider-container relative w-full h-full">
      <div class="hero-slide absolute inset-0 transition-opacity duration-1000 opacity-100">
        <img src="{{ asset('images/hero-slider/slide-1.png') }}" alt="SkyBridge Riyadh" class="w-full h-full object-cover brightness-75" fetchpriority="high">
      </div>
      <div class="hero-slide absolute inset-0 transition-opacity duration-1000 opacity-0">
        <img src="{{ asset('images/hero-slider/slide-2.png') }}" alt="SkyBridge Riyadh" class="w-full h-full object-cover brightness-75" loading="lazy">
      </div>
      <div class="hero-slide absolute inset-0 transition-opacity duration-1000 opacity-0">
        <img src="{{ asset('images/hero-slider/slide-3.png') }}" alt="SkyBridge Riyadh" class="w-full h-full object-cover brightness-75" loading="lazy">
      </div>
      
      <!-- <button aria-label="Previous slide" class="hero-slider-prev absolute left-4 top-1/2 -translate-y-1/2 z-20 bg-black/30 hover:bg-black/50 text-white p-4 rounded-full transition-all duration-300 backdrop-blur-sm">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
      </button>
      <button aria-label="Next slide" class="hero-slider-next absolute right-4 top-1/2 -translate-y-1/2 z-20 bg-black/30 hover:bg-black/50 text-white p-4 rounded-full transition-all duration-300 backdrop-blur-sm">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
      </button> -->
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-background-50/40 to-background-100/40"></div>
  </div>

  <div class="relative z-10 py-24">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 flex flex-col lg:flex-row items-center gap-16">
      <div class="lg:w-1/2">
        <div class="bg-white/90 dark:bg-dark-800/90 backdrop-blur-sm rounded-2xl shadow-xl border border-background-200 dark:border-dark-600 p-8 scroll-reveal animate-fade-in-up">
          <div class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-medium bg-primary-100 dark:bg-primary-900/30 text-primary-800 dark:text-primary-200 mb-6">
            <span class="h-2 w-2 rounded-full bg-primary-600 mr-2"></span>
            {{ __('website.welcome') }}
          </div>

          <h1 class="text-4xl font-extrabold text-dark-900 dark:text-light-100 mb-6">
            {{ __('website.tagline') }}
          </h1>

          <p class="text-lg md:text-xl text-dark-600 dark:text-light-300 mb-10">
            {{ __('website.our_platform') }}
          </p>

          <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('customer.bookings.create') }}" class="px-8 py-4 bg-primary-600 text-white font-bold rounded-xl shadow-lg hover:bg-primary-700 transition-all duration-300 hover-lift btn-primary-enhanced text-center">
              {{ __('website.book_appointment') }}
            </a>
            <a href="{{ route('customer.register') }}" class="px-8 py-4 bg-white dark:bg-dark-700 text-primary-600 dark:text-primary-400 font-bold rounded-xl border-2 border-primary-600 dark:border-primary-500 shadow hover:shadow-md transition-all duration-300 hover-lift text-center">
              {{ __('website.create_account') }}
            </a>
          </div>

          <div class="mt-10 flex items-center">
            <div class="flex -space-x-2">
              <div class="h-10 w-10 rounded-full bg-primary-200 ring-2 ring-white dark:ring-dark-800"></div>
              <div class="h-10 w-10 rounded-full bg-secondary-200 ring-2 ring-white dark:ring-dark-800"></div>
              <div class="h-10 w-10 rounded-full bg-accent-200 ring-2 ring-white dark:ring-dark-800"></div>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-dark-700 dark:text-light-200">
                <span class="text-primary-600 dark:text-primary-400 font-bold">10,000+</span> {{ __('website.happy_customers') }}
              </p>
              <p class="text-xs text-dark-500 dark:text-light-400">{{ __('website.joined_us_last_month') }}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="lg:w-1/2 flex justify-center">
        <div class="w-full max-w-md bg-white/90 dark:bg-dark-800/90 backdrop-blur-sm rounded-2xl shadow-xl border border-background-200 dark:border-dark-600 overflow-hidden scroll-reveal animate-fade-in-up" style="animation-delay: 0.2s;">
          <div class="p-6">
            <div class="flex items-center justify-between mb-6">
              <h3 class="text-xl font-bold text-dark-900 dark:text-light-100">{{ __('website.app_name') }}</h3>
              <div class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 flex items-center">
                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ __('website.available') }}
              </div>
            </div>

            <div class="space-y-4">
              <div class="flex items-start gap-3">
                <div class="h-6 w-6 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 flex items-center justify-center">
                  <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                  </svg>
                </div>
                <p class="text-dark-700 dark:text-light-300">{{ __('website.quick_and_easy_booking') }}</p>
              </div>
              <div class="flex items-start gap-3">
                <div class="h-6 w-6 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 flex items-center justify-center">
                  <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                  </svg>
                </div>
                <p class="text-dark-700 dark:text-light-300">{{ __('website.real_time_availability') }}</p>
              </div>
              <div class="flex items-start gap-3">
                <div class="h-6 w-6 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 flex items-center justify-center">
                  <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                  </svg>
                </div>
                <p class="text-dark-700 dark:text-light-300">{{ __('website.reminder_notifications') }}</p>
              </div>
            </div>

            <div class="mt-8 pt-6 border-t border-background-200 dark:border-dark-600">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-dark-900 dark:text-light-100">{{ __('website.next_available_slot') }}</p>
                  @php
                    $nextAvailable = \App\Services\NextAvailableSlotService::getNextAvailableSlot();
                  @endphp
                  @if($nextAvailable)
                    @if($nextAvailable['is_available_now'])
                      <p class="text-sm text-dark-500 dark:text-light-400">{{ __('website.available_now') }}</p>
                    @else
                      <p class="text-sm text-dark-500 dark:text-light-400">{{ __('website.today_at') }} {{ $nextAvailable['time'] }}</p>
                    @endif
                  @else
                    <p class="text-sm text-dark-500 dark:text-light-400">{{ __('website.no_available_slots_today') }}</p>
                  @endif
                </div>
                <a href="{{ route('customer.bookings.create') }}" class="px-4 py-2 text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 transition">
                  {{ __('website.book_now') }}
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="py-24 bg-background-50 dark:bg-dark-800">
  <div class="max-w-7xl mx-auto px-4 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-20">
      <h2 class="text-base font-semibold text-primary-600 dark:text-primary-400 tracking-wide uppercase">{{ __('website.services') }}</h2>
      <h3 class="mt-2 text-3xl font-extrabold text-dark-900 dark:text-light-100 sm:text-4xl">
        {{ __('website.our_services') }}
      </h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach(\App\Models\Service::where('is_active', true)->with('images')->get() as $service)
        <div class="bg-white dark:bg-dark-700 rounded-lg shadow-lg overflow-hidden flex flex-col card-modern scroll-reveal">
          <div class="relative h-64 rounded-t-lg overflow-hidden image-slider-container">
            @if($service->images->isNotEmpty())
              @foreach($service->images as $index => $image)
                <div class="image-slide absolute inset-0 transition-opacity duration-500 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}">
                  <img src="{{ asset('storage/' . $image->image) }}" class="w-full h-full object-cover" loading="lazy">
                </div>
              @endforeach

              @if($service->images->count() > 1)
                <button class="slider-prev absolute left-0 top-1/2 -translate-y-1/2 bg-black bg-opacity-30 hover:bg-opacity-50 text-white rounded-r-full p-3 z-10">&#8249;</button>
                <button class="slider-next absolute right-0 top-1/2 -translate-y-1/2 bg-black bg-opacity-30 hover:bg-opacity-50 text-white rounded-l-full p-3 z-10">&#8250;</button>
              @endif
            @else
              <img src="https://i.ibb.co/2c8Q0kM/default-avatar.png" class="w-full h-full object-cover">
            @endif
          </div>

          <div class="p-8 flex flex-col flex-grow">
            <div class="text-center mb-6 flex-grow">
              <h4 class="text-2xl font-bold text-dark-900 dark:text-light-100 mb-3">{{ $service->name }}</h4>
              <p class="text-dark-600 dark:text-light-300">{{ $service->description }}</p>
            </div>
            <div class="mt-auto">
              <p class="text-center text-primary-600 dark:text-primary-400 font-bold text-2xl mb-6 flex items-center justify-center gap-2">
                <x-sar-icon class="w-6 h-6" />
                {{ $service->price }}
              </p>
              <div class="text-center">
                <a href="{{ route('customer.bookings.create') }}" class="inline-block bg-primary-500 hover:bg-primary-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 hover-lift btn-primary-enhanced">
                    {{ __('website.book_now') }}
                </a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>

<section class="pt-24 pb-2 bg-white dark:bg-dark-900">
  <div class="max-w-7xl mx-auto px-4 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
      <div>
        <div class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-medium bg-primary-100 dark:bg-primary-900/30 text-primary-800 dark:text-primary-200 mb-4">
          <span class="h-2 w-2 rounded-full bg-primary-600 mr-2"></span>
          {{ __('website.skybridge_section_subtitle') }}
        </div>
        <h2 class="text-3xl md:text-4xl font-extrabold text-dark-900 dark:text-light-100 mb-6">
          {{ __('website.skybridge_section_title') }}
        </h2>
        <p class="text-lg text-dark-700 dark:text-light-300 mb-8">
          {{ __('website.skybridge_section_desc') }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4">
          <a href="{{ route('customer.bookings.create') }}" class="px-6 py-3 bg-primary-600 text-white font-bold rounded-xl shadow hover:bg-primary-700 transition-all duration-300 text-center">
            {{ __('website.book_now') }}
          </a>
          <a href="{{ route('customer.register') }}" class="px-6 py-3 bg-white dark:bg-dark-700 text-primary-600 dark:text-primary-400 font-bold rounded-xl border-2 border-primary-600 dark:border-primary-500 shadow hover:shadow-md transition-all duration-300 text-center">
            {{ __('website.create_account') }}
          </a>
        </div>
      </div>
      <div>
        <div class="grid grid-cols-2 gap-4">
          <img src="{{ asset('images/hero-slider/slide-1.png') }}" alt="SkyBridge Riyadh view 1" class="w-full h-40 md:h-56 object-cover rounded-xl shadow" loading="lazy"/>
          <img src="{{ asset('images/hero-slider/slide-2.png') }}" alt="SkyBridge Riyadh view 2" class="w-full h-40 md:h-56 object-cover rounded-xl shadow" loading="lazy"/>
          <img src="{{ asset('images/hero-slider/slide-3.png') }}" alt="SkyBridge Riyadh view 3" class="w-full h-40 md:h-56 object-cover rounded-xl shadow" loading="lazy"/>
          <img src="{{ asset('images/hero-slider/slide-4.png') }}" alt="SkyBridge Riyadh view 4" class="w-full h-40 md:h-56 object-cover rounded-xl shadow" loading="lazy"/>
        </div>
      </div>
    </div>

    <div class="mt-24">
      <h3 class="text-2xl font-bold text-dark-900 dark:text-light-100 mb-8 text-center">{{ __('website.skybridge_activities_title') }}</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-background-50 dark:bg-dark-800 rounded-xl p-6 border border-background-200 dark:border-dark-700">
          <div class="flex items-start gap-3">
            <div class="h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 flex items-center justify-center">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4-9 4-9-4v10l9 4 9-4V7"/></svg>
            </div>
            <div>
              <p class="font-semibold text-dark-900 dark:text-light-100">{{ __('website.activity_panorama_title') }}</p>
              <p class="text-dark-600 dark:text-light-300">{{ __('website.activity_panorama_desc') }}</p>
            </div>
          </div>
        </div>
        <div class="bg-background-50 dark:bg-dark-800 rounded-xl p-6 border border-background-200 dark:border-dark-700">
          <div class="flex items-start gap-3">
            <div class="h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 flex items-center justify-center">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v10m0 0l3-3m-3 3l-3-3M5 21h14"/></svg>
            </div>
            <div>
              <p class="font-semibold text-dark-900 dark:text-light-100">{{ __('website.activity_sunset_title') }}</p>
              <p class="text-dark-600 dark:text-light-300">{{ __('website.activity_sunset_desc') }}</p>
            </div>
          </div>
        </div>
        <div class="bg-background-50 dark:bg-dark-800 rounded-xl p-6 border border-background-200 dark:border-dark-700">
          <div class="flex items-start gap-3">
            <div class="h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 flex items-center justify-center">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h18M3 12h18M3 19h18"/></svg>
            </div>
            <div>
              <p class="font-semibold text-dark-900 dark:text-light-100">{{ __('website.activity_photography_title') }}</p>
              <p class="text-dark-600 dark:text-light-300">{{ __('website.activity_photography_desc') }}</p>
            </div>
          </div>
        </div>
        <div class="bg-background-50 dark:bg-dark-800 rounded-xl p-6 border border-background-200 dark:border-dark-700">
          <div class="flex items-start gap-3">
            <div class="h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 flex items-center justify-center">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
              <p class="font-semibold text-dark-900 dark:text-light-100">{{ __('website.activity_family_title') }}</p>
              <p class="text-dark-600 dark:text-light-300">{{ __('website.activity_family_desc') }}</p>
            </div>
          </div>
        </div>
        <div class="bg-background-50 dark:bg-dark-800 rounded-xl p-6 border border-background-200 dark:border-dark-700">
          <div class="flex items-start gap-3">
            <div class="h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 flex items-center justify-center">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-3.314 0-6 2.239-6 5v5h12v-5c0-2.761-2.686-5-6-5z"/></svg>
            </div>
            <div>
              <p class="font-semibold text-dark-900 dark:text-light-100">{{ __('website.activity_landmarks_title') }}</p>
              <p class="text-dark-600 dark:text-light-300">{{ __('website.activity_landmarks_desc') }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  var heroContainer = document.querySelector('.hero-slider-container');
  if (heroContainer) {
    var heroSlides = heroContainer.querySelectorAll('.hero-slide');
    var heroPrev = heroContainer.querySelector('.hero-slider-prev');
    var heroNext = heroContainer.querySelector('.hero-slider-next');
    var heroCurrent = 0;

    function showHeroSlide(i) {
      for (var j = 0; j < heroSlides.length; j++) {
        heroSlides[j].classList.remove('opacity-100');
        heroSlides[j].classList.add('opacity-0');
      }
      heroSlides[i].classList.remove('opacity-0');
      heroSlides[i].classList.add('opacity-100');
    }

    var heroAuto = setInterval(function() {
      heroCurrent = (heroCurrent + 1) % heroSlides.length;
      showHeroSlide(heroCurrent);
    }, 5000);

    if (heroNext) {
      heroNext.onclick = function(e) {
        e.stopPropagation();
        clearInterval(heroAuto);
        heroCurrent = (heroCurrent + 1) % heroSlides.length;
        showHeroSlide(heroCurrent);
      };
    }

    if (heroPrev) {
      heroPrev.onclick = function(e) {
        e.stopPropagation();
        clearInterval(heroAuto);
        heroCurrent = (heroCurrent - 1 + heroSlides.length) % heroSlides.length;
        showHeroSlide(heroCurrent);
      };
    }
  }

  var sliders = document.querySelectorAll('.image-slider-container');
  sliders.forEach(function(container) {
    var slides = container.querySelectorAll('.image-slide');
    var prev = container.querySelector('.slider-prev');
    var next = container.querySelector('.slider-next');
    var current = 0;

    function show(i) {
      for (var j = 0; j < slides.length; j++) {
        slides[j].classList.remove('opacity-100');
        slides[j].classList.add('opacity-0');
      }
      slides[i].classList.remove('opacity-0');
      slides[i].classList.add('opacity-100');
    }

    if (slides.length < 2) return;

    var auto = setInterval(function() {
      current = (current + 1) % slides.length;
      show(current);
    }, 5000);

    if (next) {
      next.onclick = function(e) {
        e.stopPropagation();
        clearInterval(auto);
        current = (current + 1) % slides.length;
        show(current);
      };
    }

    if (prev) {
      prev.onclick = function(e) {
        e.stopPropagation();
        clearInterval(auto);
        current = (current - 1 + slides.length) % slides.length;
        show(current);
      };
    }

    show(0);
  });
});
</script>
@endpush