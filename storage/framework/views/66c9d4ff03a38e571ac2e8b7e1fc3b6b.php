<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Bookify')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-background-50 to-background-100 min-h-screen text-dark-500">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-background-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <svg class="h-8 w-8 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="ml-2 text-xl font-bold text-primary-600"><?php echo e(config('app.name', 'Bookify')); ?></span>
                    </div>
                </div>
                <?php
                    // Get the current locale to determine the switch locale
                    $currentLocale = app()->getLocale();
                    $switchLocale = $currentLocale === 'ar' ? 'en' : 'ar';
                ?>
                <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
                    <!-- Language Switcher -->
                    <div class="flex items-center space-x-2">
                        <a href="<?php echo e(route('lang.switch', ['locale' => $switchLocale])); ?>" class="px-3 py-2 text-sm rounded-md <?php echo e(app()->getLocale() === $switchLocale ? 'bg-primary-100 text-primary-700 font-medium' : 'text-gray-600 hover:bg-gray-100'); ?>" onclick="event.preventDefault(); document.getElementById('language-switch-form-<?php echo e($switchLocale); ?>').submit();">
                            <?php echo e($switchLocale === 'ar' ? __('website.arabic') : __('website.english')); ?>

                        </a>
                        <form id="language-switch-form-<?php echo e($switchLocale); ?>" action="<?php echo e(route('lang.switch', ['locale' => $switchLocale])); ?>" method="GET" class="hidden">
                            <?php echo csrf_field(); ?>
                        </form>
                    </div>
                    <a href="<?php echo e(route('pages.show', 'about-us')); ?>" class="text-dark-500 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200"><?php echo e(__('website.about')); ?></a>
                    <a href="<?php echo e(route('pages.show', 'contact-us')); ?>" class="text-dark-500 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200"><?php echo e(__('website.contact_us')); ?></a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard('customer')->check()): ?>
                        <a href="<?php echo e(route('customer.dashboard')); ?>" class="text-dark-500 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 <?php echo e(request()->routeIs('customer.dashboard') ? 'bg-primary-100 text-primary-600' : ''); ?>"><?php echo e(__('website.dashboard')); ?></a>
                        <a href="<?php echo e(route('customer.bookings')); ?>" class="text-dark-500 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 <?php echo e(request()->routeIs('customer.bookings') ? 'bg-primary-100 text-primary-600' : ''); ?>"><?php echo e(__('website.my_bookings')); ?></a>
                        <a href="<?php echo e(route('customer.bookings.create')); ?>" class="text-dark-500 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 <?php echo e(request()->routeIs('customer.bookings.create') ? 'bg-primary-100 text-primary-600' : ''); ?>"><?php echo e(__('website.book_appointment_nav')); ?></a>
                        <a href="<?php echo e(route('customer.logout')); ?>" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="text-dark-500 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            <?php echo e(__('website.logout')); ?>

                        </a>
                        <form id="logout-form" action="<?php echo e(route('customer.logout')); ?>" method="POST" class="hidden">
                            <?php echo csrf_field(); ?>
                        </form>
                    <?php else: ?>
                        <a href="<?php echo e(route('customer.login')); ?>" class="text-dark-500 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200"><?php echo e(__('website.login')); ?></a>
                        <a href="<?php echo e(route('customer.register')); ?>" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200"><?php echo e(__('website.register')); ?></a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-dark-400 hover:text-dark-500 hover:bg-background-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="pt-2 pb-3 space-y-1">
                <a href="<?php echo e(route('pages.show', 'about-us')); ?>" class="border-transparent text-dark-600 hover:bg-background-50 hover:border-background-300 hover:text-dark-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    <?php echo e(__('website.about')); ?>

                </a>
                <a href="<?php echo e(route('pages.show', 'contact-us')); ?>" class="border-transparent text-dark-600 hover:bg-background-50 hover:border-background-300 hover:text-dark-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    <?php echo e(__('website.contact_us')); ?>

                </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard('customer')->check()): ?>
                    <a href="<?php echo e(route('customer.dashboard')); ?>" class="border-transparent text-dark-600 hover:bg-background-50 hover:border-background-300 hover:text-dark-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium <?php echo e(request()->routeIs('customer.dashboard') ? 'bg-primary-100 border-primary-500' : ''); ?>">
                        <?php echo e(__('website.dashboard')); ?>

                    </a>
                    <a href="<?php echo e(route('customer.bookings')); ?>" class="border-transparent text-dark-600 hover:bg-background-50 hover:border-background-300 hover:text-dark-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium <?php echo e(request()->routeIs('customer.bookings') ? 'bg-primary-100 border-primary-500' : ''); ?>">
                        <?php echo e(__('website.my_bookings')); ?>

                    </a>
                    <a href="<?php echo e(route('customer.bookings.create')); ?>" class="border-transparent text-dark-600 hover:bg-background-50 hover:border-background-300 hover:text-dark-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium <?php echo e(request()->routeIs('customer.bookings.create') ? 'bg-primary-100 border-primary-500' : ''); ?>">
                        <?php echo e(__('website.book_appointment_nav')); ?>

                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('customer.login')); ?>" class="border-transparent text-dark-600 hover:bg-background-50 hover:border-background-300 hover:text-dark-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                        <?php echo e(__('website.login')); ?>

                    </a>
                    <a href="<?php echo e(route('customer.register')); ?>" class="border-transparent text-dark-600 hover:bg-background-50 hover:border-background-300 hover:text-dark-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                        <?php echo e(__('website.register')); ?>

                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="mt-3 space-y-1">
                    <!-- Language Switcher Mobile -->
                    <div class="px-4 py-2">
                        <div class="flex space-x-2">
                            <a href="<?php echo e(route('lang.switch', ['locale' => $switchLocale])); ?>" class="px-3 py-1 text-sm rounded-md <?php echo e(app()->getLocale() === $switchLocale ? 'bg-primary-100 text-primary-700 font-medium' : 'text-gray-600 hover:bg-gray-100'); ?>" onclick="event.preventDefault(); document.getElementById('language-switch-form-mobile-<?php echo e($switchLocale); ?>').submit();">
                                <?php echo e($switchLocale === 'ar' ? __('website.arabic') : __('website.english')); ?>

                            </a>
                            <form id="language-switch-form-mobile-<?php echo e($switchLocale); ?>" action="<?php echo e(route('lang.switch', ['locale' => $switchLocale])); ?>" method="GET" class="hidden">
                                <?php echo csrf_field(); ?>
                            </form>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard('customer')->check()): ?>
                        <a href="<?php echo e(route('customer.logout')); ?>" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="block px-4 py-2 text-base font-medium text-dark-500 hover:text-dark-800 hover:bg-background-100">
                            <?php echo e(__('website.logout')); ?>

                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-dark-900 mt-12">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
            <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                <div class="space-y-8 xl:col-span-1">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 text-primary-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="ml-2 text-xl font-bold text-primary-300"><?php echo e(config('app.name', 'Bookify')); ?></span>
                    </div>
                    <p class="text-dark-300 text-base">
                        <?php echo e(__('website.our_platform')); ?>

                    </p>
                </div>
                <div class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold text-dark-300 tracking-wider uppercase">
                                <?php echo e(__('website.support')); ?>

                            </h3>
                            <ul class="mt-4 space-y-4">
                                <li>
                                    <a href="#" class="text-base text-dark-400 hover:text-primary-300">
                                        <?php echo e(__('website.help_center')); ?>

                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="text-base text-dark-400 hover:text-primary-300">
                                        <?php echo e(__('website.contact_us')); ?>

                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-12 md:mt-0">
                            <h3 class="text-sm font-semibold text-dark-300 tracking-wider uppercase">
                                <?php echo e(__('website.company')); ?>

                            </h3>
                            <ul class="mt-4 space-y-4">
                                <li>
                                    <a href="<?php echo e(route('pages.show', 'about-us')); ?>" class="text-base text-dark-400 hover:text-primary-300">
                                        <?php echo e(__('website.about')); ?>

                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('pages.show', 'contact-us')); ?>" class="text-base text-dark-400 hover:text-primary-300">
                                        <?php echo e(__('website.contact_us')); ?>

                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold text-dark-300 tracking-wider uppercase">
                                <?php echo e(__('website.legal')); ?>

                            </h3>
                            <ul class="mt-4 space-y-4">
                                <li>
                                    <a href="<?php echo e(route('pages.show', 'privacy-policy')); ?>" class="text-base text-dark-400 hover:text-primary-300">
                                        <?php echo e(__('website.privacy')); ?>

                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('pages.show', 'terms-and-conditions')); ?>" class="text-base text-dark-400 hover:text-primary-300">
                                        <?php echo e(__('website.terms')); ?>

                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('pages.show', 'faq')); ?>" class="text-base text-dark-400 hover:text-primary-300">
                                        <?php echo e(__('website.faq')); ?>

                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-700 pt-8">
                <p class="text-base text-dark-400 xl:text-center">
                    &copy; <?php echo e(date('Y')); ?> Bookify. <?php echo e(__('website.all_rights_reserved')); ?>

                </p>
            </div>
        </div>
    </footer>
    
    <!-- Mobile menu toggle script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
                    mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // Set RTL/LTR based on current locale
            if (document.documentElement.lang === 'ar') {
                document.documentElement.setAttribute('dir', 'rtl');
            } else {
                document.documentElement.setAttribute('dir', 'ltr');
            }
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH D:\server\web\bookify\resources\views/layouts/main.blade.php ENDPATH**/ ?>