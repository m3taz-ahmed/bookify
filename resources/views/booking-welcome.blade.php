@extends('layouts.main')

@section('content')
<!-- Hero Section with Modern Design -->
<div class="relative overflow-hidden bg-gradient-to-br from-background-50 to-background-100">
  <div class="absolute inset-0 z-0">
    <div class="absolute top-0 right-0 w-1/3 h-1/2 bg-gradient-to-r from-primary-500 to-secondary-600 rounded-bl-full opacity-10"></div>
    <div class="absolute bottom-0 left-0 w-1/3 h-1/2 bg-gradient-to-r from-secondary-500 to-accent-600 rounded-tr-full opacity-10"></div>
  </div>
  
  <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-24">
    <div class="flex flex-col lg:flex-row items-center">
      <!-- Left Content -->
      <div class="lg:w-1/2 mb-16 lg:mb-0 lg:pr-12">
        <div class="max-w-lg">
          <div class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800 mb-6">
            <span class="h-2 w-2 rounded-full bg-primary-600 mr-2"></span>
            {{ __('website.welcome') }}
          </div>
          
          <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-dark-900 tracking-tight mb-6">
            {{ __('website.tagline') }}
          </h1>
          
          <p class="text-lg md:text-xl text-dark-600 mb-10 leading-relaxed">
            {{ __('website.our_platform') }}
          </p>
          
          <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="{{ route('customer.bookings.create') }}" 
               class="px-8 py-4 bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-bold rounded-xl shadow-lg hover:from-primary-700 hover:to-secondary-700 transition-all duration-300 transform hover:-translate-y-1 text-center flex items-center justify-center group">
              <span>{{ __('website.book_appointment') }}</span>
              <svg class="ml-2 h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </a>
            
            <a href="{{ route('customer.register') }}" 
               class="px-8 py-4 bg-white text-primary-600 font-bold rounded-xl shadow hover:shadow-md border border-primary-200 transition-all duration-300 text-center flex items-center justify-center group">
              <span>{{ __('website.create_account') }}</span>
              <svg class="ml-2 h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
              </svg>
            </a>
          </div>
          
          <div class="mt-10 flex items-center">
            <div class="flex -space-x-2">
              <div class="inline-block h-10 w-10 rounded-full bg-primary-100 ring-2 ring-white"></div>
              <div class="inline-block h-10 w-10 rounded-full bg-secondary-100 ring-2 ring-white"></div>
              <div class="inline-block h-10 w-10 rounded-full bg-accent-100 ring-2 ring-white"></div>
              <div class="inline-block h-10 w-10 rounded-full bg-primary-200 ring-2 ring-white"></div>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-dark-700">
                <span class="text-primary-600 font-bold">10,000+</span> {{ __('website.happy_customers') }}
              </p>
              <p class="text-xs text-dark-500">{{ __('website.joined_us_last_month') }}</p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Right Content - Interactive Card -->
      <div class="lg:w-1/2 flex justify-center">
        <div class="relative w-full max-w-md">
          <div class="absolute -top-6 -right-6 w-32 h-32 bg-primary-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
          <div class="absolute -bottom-8 -left-6 w-32 h-32 bg-secondary-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
          <div class="absolute top-10 left-10 w-32 h-32 bg-accent-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
          
          <div class="relative bg-white rounded-2xl shadow-xl border border-background-200 overflow-hidden transform transition-all duration-500 hover:shadow-2xl">
            <div class="p-6">
              <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-dark-900">{{ config('app.name', 'Bookify') }}</h3>
                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                  <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                  </svg>
                  {{ __('website.available') }}
                </div>
              </div>
              
              <div class="space-y-4">
                <div class="flex items-start">
                  <div class="flex-shrink-0 mt-1">
                    <div class="flex items-center justify-center h-6 w-6 rounded-full bg-primary-100 text-primary-600">
                      <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                      </svg>
                    </div>
                  </div>
                  <p class="ml-3 text-dark-700">{{ __('website.quick_and_easy_booking') }}</p>
                </div>
                
                <div class="flex items-start">
                  <div class="flex-shrink-0 mt-1">
                    <div class="flex items-center justify-center h-6 w-6 rounded-full bg-primary-100 text-primary-600">
                      <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                      </svg>
                    </div>
                  </div>
                  <p class="ml-3 text-dark-700">{{ __('website.real_time_availability') }}</p>
                </div>
                
                <div class="flex items-start">
                  <div class="flex-shrink-0 mt-1">
                    <div class="flex items-center justify-center h-6 w-6 rounded-full bg-primary-100 text-primary-600">
                      <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                      </svg>
                    </div>
                  </div>
                  <p class="ml-3 text-dark-700">{{ __('website.reminder_notifications') }}</p>
                </div>
              </div>
              
              <div class="mt-8 pt-6 border-t border-background-200">
                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-sm font-medium text-dark-900">{{ __('website.next_available_slot') }}</p>
                    <p class="text-sm text-dark-500">Today at 2:30 PM</p>
                  </div>
                  <a href="{{ route('customer.bookings.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
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
</div>

<!-- Features Section with Icons -->
<div class="py-20 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-16">
      <h2 class="text-base font-semibold text-primary-600 tracking-wide uppercase">{{ __('website.why_choose_us') }}</h2>
      <h3 class="mt-2 text-3xl font-extrabold text-dark-900 sm:text-4xl">
        {{ __('website.everything_you_need') }}
      </h3>
      <p class="mt-4 text-xl text-dark-500">
        {{ __('website.discover_our_benefits') }}
      </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
      <!-- Feature 1 -->
      <div class="group">
        <div class="flex justify-center">
          <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-primary-100 text-primary-600 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300">
            <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
        </div>
        <div class="mt-5 text-center">
          <h4 class="text-lg font-bold text-dark-900">{{ __('website.fast_booking') }}</h4>
          <p class="mt-2 text-base text-dark-500">
            {{ __('website.book_instantly') }}
          </p>
        </div>
      </div>
      
      <!-- Feature 2 -->
      <div class="group">
        <div class="flex justify-center">
          <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-secondary-100 text-secondary-600 group-hover:bg-secondary-600 group-hover:text-white transition-all duration-300">
            <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
          </div>
        </div>
        <div class="mt-5 text-center">
          <h4 class="text-lg font-bold text-dark-900">{{ __('website.secure_payments') }}</h4>
          <p class="mt-2 text-base text-dark-500">
            {{ __('website.safe_transaction') }}
          </p>
        </div>
      </div>
      
      <!-- Feature 3 -->
      <div class="group">
        <div class="flex justify-center">
          <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-accent-100 text-accent-600 group-hover:bg-accent-600 group-hover:text-white transition-all duration-300">
            <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
          </div>
        </div>
        <div class="mt-5 text-center">
          <h4 class="text-lg font-bold text-dark-900">{{ __('website.reminders') }}</h4>
          <p class="mt-2 text-base text-dark-500">
            {{ __('website.never_miss_appointment') }}
          </p>
        </div>
      </div>
      
      <!-- Feature 4 -->
      <div class="group">
        <div class="flex justify-center">
          <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-primary-100 text-primary-600 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300">
            <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
        </div>
        <div class="mt-5 text-center">
          <h4 class="text-lg font-bold text-dark-900">{{ __('website.expert_professionals') }}</h4>
          <p class="mt-2 text-base text-dark-500">
            {{ __('website.quality_service') }}
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Stats Section -->
<div class="bg-gradient-to-r from-primary-600 to-secondary-700 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
      <div>
        <div class="text-4xl font-extrabold text-white">10K+</div>
        <div class="mt-2 text-lg font-medium text-primary-200">{{ __('website.happy_customers') }}</div>
      </div>
      <div>
        <div class="text-4xl font-extrabold text-white">500+</div>
        <div class="mt-2 text-lg font-medium text-primary-200">{{ __('website.services_offered') }}</div>
      </div>
      <div>
        <div class="text-4xl font-extrabold text-white">99%</div>
        <div class="mt-2 text-lg font-medium text-primary-200">{{ __('website.customer_satisfaction') }}</div>
      </div>
      <div>
        <div class="text-4xl font-extrabold text-white">24/7</div>
        <div class="mt-2 text-lg font-medium text-primary-200">{{ __('website.support_available') }}</div>
      </div>
    </div>
  </div>
</div>

<!-- Testimonials Section -->
<div class="py-20 bg-background-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-16">
      <h2 class="text-base font-semibold text-primary-600 tracking-wide uppercase">{{ __('website.testimonials') }}</h2>
      <h3 class="mt-2 text-3xl font-extrabold text-dark-900 sm:text-4xl">
        {{ __('website.what_our_customers_say') }}
      </h3>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- Testimonial 1 -->
      <div class="bg-white rounded-2xl shadow-lg p-8 transition-all duration-300 hover:shadow-xl">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <div class="bg-gray-200 border-2 border-dashed rounded-xl w-16 h-16" />
          </div>
          <div class="ml-4">
            <h4 class="text-lg font-bold text-dark-900">Sarah Johnson</h4>
            <p class="text-primary-600">{{ __('website.regular_customer') }}</p>
          </div>
        </div>
        <div class="mt-6">
          <p class="text-dark-600 italic">
            "{{ __('website.testimonial_1') }}"
          </p>
          <div class="mt-4 flex">
            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
          </div>
        </div>
      </div>
      
      <!-- Testimonial 2 -->
      <div class="bg-white rounded-2xl shadow-lg p-8 transition-all duration-300 hover:shadow-xl">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <div class="bg-gray-200 border-2 border-dashed rounded-xl w-16 h-16" />
          </div>
          <div class="ml-4">
            <h4 class="text-lg font-bold text-dark-900">Michael Chen</h4>
            <p class="text-primary-600">{{ __('website.new_customer') }}</p>
          </div>
        </div>
        <div class="mt-6">
          <p class="text-dark-600 italic">
            "{{ __('website.testimonial_2') }}"
          </p>
          <div class="mt-4 flex">
            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
          </div>
        </div>
      </div>
      
      <!-- Testimonial 3 -->
      <div class="bg-white rounded-2xl shadow-lg p-8 transition-all duration-300 hover:shadow-xl">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <div class="bg-gray-200 border-2 border-dashed rounded-xl w-16 h-16" />
          </div>
          <div class="ml-4">
            <h4 class="text-lg font-bold text-dark-900">Emma Rodriguez</h4>
            <p class="text-primary-600">{{ __('website.loyal_customer') }}</p>
          </div>
        </div>
        <div class="mt-6">
          <p class="text-dark-600 italic">
            "{{ __('website.testimonial_3') }}"
          </p>
          <div class="mt-4 flex">
            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- CTA Section -->
<div class="bg-white py-20">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-gradient-to-r from-primary-600 to-secondary-700 rounded-3xl shadow-2xl overflow-hidden">
      <div class="px-6 py-16 sm:px-16 sm:py-20 lg:py-24 lg:px-24">
        <div class="lg:flex lg:items-center lg:justify-between">
          <div class="lg:w-0 lg:flex-1">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
              {{ __('website.ready_to_get_started') }}
            </h2>
            <p class="mt-3 max-w-3xl text-lg text-primary-100">
              {{ __('website.join_our_community') }}
            </p>
          </div>
          <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
            <div class="inline-flex rounded-lg shadow">
              <a href="{{ route('customer.bookings.create') }}" 
                 class="inline-flex items-center justify-center px-6 py-4 border border-transparent text-base font-bold rounded-lg text-primary-600 bg-white hover:bg-primary-50 transition-all duration-300 transform hover:-translate-y-0.5">
                {{ __('website.book_now') }}
              </a>
            </div>
            <div class="ml-3 inline-flex rounded-lg shadow">
              <a href="{{ route('customer.login') }}" 
                 class="inline-flex items-center justify-center px-6 py-4 border border-transparent text-base font-bold rounded-lg text-white bg-primary-500 bg-opacity-20 hover:bg-opacity-30 transition-all duration-300">
                {{ __('website.sign_in') }}
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  @keyframes blob {
    0% {
      transform: translate(0px, 0px) scale(1);
    }
    33% {
      transform: translate(30px, -50px) scale(1.1);
    }
    66% {
      transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
      transform: translate(0px, 0px) scale(1);
    }
  }
  
  .animate-blob {
    animation: blob 7s infinite;
  }
  
  .animation-delay-2000 {
    animation-delay: 2s;
  }
  
  .animation-delay-4000 {
    animation-delay: 4s;
  }
</style>
@endsection