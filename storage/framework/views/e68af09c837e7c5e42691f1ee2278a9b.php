<?php $__env->startSection('content'); ?>


<div class="bg-gradient-to-br from-background-50 to-background-100 py-24">
  <div class="max-w-7xl mx-auto px-4 lg:px-8 flex flex-col lg:flex-row items-center gap-16">

    
    <div class="lg:w-1/2">
      <div class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800 mb-6">
        <span class="h-2 w-2 rounded-full bg-primary-600 mr-2"></span>
        <?php echo e(__('website.welcome')); ?>

      </div>

      <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-dark-900 mb-6">
        <?php echo e(__('website.tagline')); ?>

      </h1>

      <p class="text-lg md:text-xl text-dark-600 mb-10">
        <?php echo e(__('website.our_platform')); ?>

      </p>

      <div class="flex flex-col sm:flex-row gap-4">
        <a href="<?php echo e(route('customer.bookings.create')); ?>"
           class="px-8 py-4 bg-primary-600 text-white font-bold rounded-xl shadow-lg hover:bg-primary-700 transition">
          <?php echo e(__('website.book_appointment')); ?>

        </a>
        <a href="<?php echo e(route('customer.register')); ?>"
           class="px-8 py-4 bg-white text-primary-600 font-bold rounded-xl border border-primary-200 shadow hover:shadow-md transition">
          <?php echo e(__('website.create_account')); ?>

        </a>
      </div>

      <div class="mt-10 flex items-center">
        <div class="flex -space-x-2">
          <div class="h-10 w-10 rounded-full bg-primary-200 ring-2 ring-white"></div>
          <div class="h-10 w-10 rounded-full bg-secondary-200 ring-2 ring-white"></div>
          <div class="h-10 w-10 rounded-full bg-accent-200 ring-2 ring-white"></div>
        </div>
        <div class="ml-4">
          <p class="text-sm font-medium text-dark-700">
            <span class="text-primary-600 font-bold">10,000+</span> <?php echo e(__('website.happy_customers')); ?>

          </p>
          <p class="text-xs text-dark-500"><?php echo e(__('website.joined_us_last_month')); ?></p>
        </div>
      </div>
    </div>

    
    <div class="lg:w-1/2 flex justify-center">
      <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-background-200 overflow-hidden transform transition-all duration-300 hover:shadow-2xl">
        <div class="p-6">
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-dark-900"><?php echo e(config('app.name', 'Bookify')); ?></h3>
            <div class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 flex items-center">
              <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
              </svg>
              <?php echo e(__('website.available')); ?>

            </div>
          </div>

          <div class="space-y-4">
            <div class="flex items-start gap-3">
              <div class="h-6 w-6 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
              </div>
              <p class="text-dark-700"><?php echo e(__('website.quick_and_easy_booking')); ?></p>
            </div>
            <div class="flex items-start gap-3">
              <div class="h-6 w-6 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
              </div>
              <p class="text-dark-700"><?php echo e(__('website.real_time_availability')); ?></p>
            </div>
            <div class="flex items-start gap-3">
              <div class="h-6 w-6 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
              </div>
              <p class="text-dark-700"><?php echo e(__('website.reminder_notifications')); ?></p>
            </div>
          </div>

          <div class="mt-8 pt-6 border-t border-background-200">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-dark-900"><?php echo e(__('website.next_available_slot')); ?></p>
                <p class="text-sm text-dark-500">Today at 2:30 PM</p>
              </div>
              <a href="<?php echo e(route('customer.bookings.create')); ?>"
                 class="px-4 py-2 text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 transition">
                <?php echo e(__('website.book_now')); ?>

              </a>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
</div>


<div class="py-24 bg-background-50">
  <div class="max-w-7xl mx-auto px-4 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-20">
      <h2 class="text-base font-semibold text-primary-600 tracking-wide uppercase"><?php echo e(__('website.services')); ?></h2>
      <h3 class="mt-2 text-3xl font-extrabold text-dark-900 sm:text-4xl">
        <?php echo e(__('website.our_services')); ?>

      </h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = \App\Models\Service::where('is_active', true)->with('images')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
          <!-- Image Slider Container -->
          <div class="relative h-64 rounded-t-lg overflow-hidden flex-shrink-0">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($service->images->isNotEmpty()): ?>
              <div class="image-slider-container relative w-full h-full">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $service->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="image-slide absolute inset-0 transition-opacity duration-500 ease-in-out <?php echo e($index === 0 ? 'opacity-100' : 'opacity-0'); ?>">
                    <img src="<?php echo e(Storage::url($image->image)); ?>" alt="<?php echo e($service->name); ?>" class="w-full h-full object-cover">
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <!-- Navigation Arrows -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($service->images->count() > 1): ?>
                  <button class="slider-prev absolute left-0 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-30 hover:bg-opacity-50 text-white rounded-r-full p-3 transition z-10" onclick="event.stopPropagation();">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                  </button>
                  <button class="slider-next absolute right-0 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-30 hover:bg-opacity-50 text-white rounded-l-full p-3 transition z-10" onclick="event.stopPropagation();">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                  </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

              </div>
              
              <script>
                document.addEventListener('DOMContentLoaded', function() {
                  // Initialize slider for this specific service
                  initializeSlider();
                  
                  function initializeSlider() {
                    // Get the slider container for this specific service
                    const sliderContainer = document.currentScript ? 
                      document.currentScript.closest('.image-slider-container') : 
                      // Fallback: find the closest slider container to this script
                      document.querySelector('.image-slider-container script') ? 
                        document.querySelector('.image-slider-container script').closest('.image-slider-container') : 
                        null;
                    
                    if (!sliderContainer) {
                      // Try another approach to find the container
                      const scriptTag = document.currentScript || document.scripts[document.scripts.length - 1];
                      sliderContainer = scriptTag.closest('.image-slider-container');
                      if (!sliderContainer) return;
                    }
                    
                    const slides = sliderContainer.querySelectorAll('.image-slide');
                    const prevBtn = sliderContainer.querySelector('.slider-prev');
                    const nextBtn = sliderContainer.querySelector('.slider-next');
                    let currentIndex = 0;
                    
                    // If no slides, exit early
                    if (slides.length === 0) return;
                    
                    function showSlide(index) {
                      // Hide all slides
                      slides.forEach(slide => {
                        slide.classList.remove('opacity-100');
                        slide.classList.add('opacity-0');
                      });
                      
                      // Show current slide
                      if (slides[index]) {
                        slides[index].classList.remove('opacity-0');
                        slides[index].classList.add('opacity-100');
                      }
                      
                      currentIndex = index;
                    }
                    
                    // Next button click
                    if (nextBtn) {
                      nextBtn.onclick = function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        let nextIndex = currentIndex + 1;
                        if (nextIndex >= slides.length) nextIndex = 0;
                        showSlide(nextIndex);
                        return false;
                      };
                    }
                    
                    // Previous button click
                    if (prevBtn) {
                      prevBtn.onclick = function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        let prevIndex = currentIndex - 1;
                        if (prevIndex < 0) prevIndex = slides.length - 1;
                        showSlide(prevIndex);
                        return false;
                      };
                    }
                    
                    // Initialize first slide
                    showSlide(0);
                  }
                });
              </script>
            <?php else: ?>
              <img src="https://i.ibb.co/2c8Q0kM/default-avatar.png" alt="<?php echo e($service->name); ?>" class="w-full h-full object-cover">
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </div>

          <div class="p-8 flex flex-col flex-grow">
            <div class="text-center mb-6 flex-grow">
              <h4 class="text-2xl font-bold text-dark-900 mb-3"><?php echo e($service->name); ?></h4>
              <p class="text-dark-600 italic">
                <?php echo e($service->description); ?>

              </p>
            </div>
            <div class="mt-auto">
              <p class="text-center text-primary-600 font-bold text-2xl mb-6">$<?php echo e($service->price); ?></p>
              <div class="text-center">
                <a href="<?php echo e(route('customer.bookings.create')); ?>" class="inline-block bg-primary-500 hover:bg-primary-700 text-white font-bold py-3 px-6 rounded-lg transition">
                    <?php echo e(__('website.book_now')); ?>

                    <svg class="ml-1 h-4 w-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Add JavaScript for slider functionality -->
        <?php $__env->startPush('scripts'); ?>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            const sliders = document.querySelectorAll('.image-slider-container');
            
            sliders.forEach(function(container) {
              const slides = container.querySelectorAll('.image-slide');
              const prevBtn = container.querySelector('.slider-prev');
              const nextBtn = container.querySelector('.slider-next');
              let currentIndex = 0;
              
              function showSlide(index) {
                slides.forEach((slide, i) => {
                  slide.style.opacity = i === index ? '1' : '0';
                });
              }
              
              function nextSlide() {
                currentIndex = (currentIndex + 1) % slides.length;
                showSlide(currentIndex);
              }
              
              function prevSlide() {
                currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                showSlide(currentIndex);
              }
              
              // Auto-advance slides every 5 seconds
              const interval = setInterval(nextSlide, 5000);
              
              // Add click events to buttons
              if (prevBtn) {
                prevBtn.addEventListener('click', function(e) {
                  e.stopPropagation();
                  clearInterval(interval); // Stop auto-advance when user interacts
                  prevSlide();
                });
              }
              
              if (nextBtn) {
                nextBtn.addEventListener('click', function(e) {
                  e.stopPropagation();
                  clearInterval(interval); // Stop auto-advance when user interacts
                  nextSlide();
                });
              }
            });
          });
        </script>
        <?php $__env->stopPush(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
  </div>
</div>




<div class="py-24 bg-white">
  <div class="max-w-7xl mx-auto px-4 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-20">
      <h2 class="text-base font-semibold text-primary-600 uppercase"><?php echo e(__('website.why_choose_us')); ?></h2>
      <h3 class="mt-2 text-3xl font-extrabold text-dark-900"><?php echo e(__('website.everything_you_need')); ?></h3>
      <p class="mt-4 text-xl text-dark-500"><?php echo e(__('website.discover_our_benefits')); ?></p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

      <div class="text-center">
        <div class="flex justify-center">
          <div class="h-16 w-16 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center">
            <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
        </div>
        <h4 class="mt-6 text-lg font-bold text-dark-900"><?php echo e(__('website.fast_booking')); ?></h4>
        <p class="mt-3 text-base text-dark-500"><?php echo e(__('website.book_instantly')); ?></p>
      </div>

      <div class="text-center">
        <div class="flex justify-center">
          <div class="h-16 w-16 rounded-xl bg-secondary-100 text-secondary-600 flex items-center justify-center">
            <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
          </div>
        </div>
        <h4 class="mt-6 text-lg font-bold text-dark-900"><?php echo e(__('website.secure_payments')); ?></h4>
        <p class="mt-3 text-base text-dark-500"><?php echo e(__('website.safe_transaction')); ?></p>
      </div>

      <div class="text-center">
        <div class="flex justify-center">
          <div class="h-16 w-16 rounded-xl bg-accent-100 text-accent-600 flex items-center justify-center">
            <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2H6a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
          </div>
        </div>
        <h4 class="mt-6 text-lg font-bold text-dark-900"><?php echo e(__('website.reminders')); ?></h4>
        <p class="mt-3 text-base text-dark-500"><?php echo e(__('website.never_miss_appointment')); ?></p>
      </div>

      <div class="text-center">
        <div class="flex justify-center">
          <div class="h-16 w-16 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center">
            <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16" />
            </svg>
          </div>
        </div>
        <h4 class="mt-6 text-lg font-bold text-dark-900"><?php echo e(__('website.expert_professionals')); ?></h4>
        <p class="mt-3 text-base text-dark-500"><?php echo e(__('website.quality_service')); ?></p>
      </div>

    </div>
  </div>
</div>


<div class="bg-gradient-to-r from-primary-600 to-secondary-700 py-20">
  <div class="max-w-7xl mx-auto px-4 lg:px-8">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-12 text-center text-white">
      <div class="p-6">
        <div class="text-4xl font-extrabold">10K+</div>
        <div class="mt-3 text-lg font-medium"><?php echo e(__('website.happy_customers')); ?></div>
      </div>
      <div class="p-6">
        <div class="text-4xl font-extrabold">500+</div>
        <div class="mt-3 text-lg font-medium"><?php echo e(__('website.services_offered')); ?></div>
      </div>
      <div class="p-6">
        <div class="text-4xl font-extrabold">99%</div>
        <div class="mt-3 text-lg font-medium"><?php echo e(__('website.customer_satisfaction')); ?></div>
      </div>
      <div class="p-6">
        <div class="text-4xl font-extrabold">24/7</div>
        <div class="mt-3 text-lg font-medium"><?php echo e(__('website.support_available')); ?></div>
      </div>
    </div>
  </div>
</div>


<div class="bg-white py-24">
  <div class="max-w-7xl mx-auto px-4 lg:px-8">
    <div class="bg-gradient-to-r from-primary-600 to-secondary-700 rounded-3xl shadow-2xl overflow-hidden">
      <div class="px-8 py-20 sm:px-16 lg:py-28 lg:px-24">
        <div class="lg:flex lg:items-center lg:justify-between">
          <div class="lg:w-0 lg:flex-1">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
              <?php echo e(__('website.ready_to_get_started')); ?>

            </h2>
            <p class="mt-4 max-w-3xl text-lg text-primary-100">
              <?php echo e(__('website.join_our_community')); ?>

            </p>
          </div>
          <div class="mt-10 flex flex-col sm:flex-row lg:mt-0 lg:flex-shrink-0 gap-4">
            <a href="<?php echo e(route('customer.bookings.create')); ?>"
               class="px-8 py-4 bg-white text-primary-600 font-bold rounded-lg hover:bg-primary-50 transition">
              <?php echo e(__('website.book_now')); ?>

            </a>
            <a href="<?php echo e(route('customer.login')); ?>"
               class="px-8 py-4 bg-primary-500 bg-opacity-20 text-white font-bold rounded-lg hover:bg-opacity-30 transition">
              <?php echo e(__('website.sign_in')); ?>

            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="py-24 bg-background-50">
  <div class="max-w-7xl mx-auto px-4 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-20">
      <h2 class="text-base font-semibold text-primary-600 tracking-wide uppercase"><?php echo e(__('website.testimonials')); ?></h2>
      <h3 class="mt-2 text-3xl font-extrabold text-dark-900 sm:text-4xl">
        <?php echo e(__('website.what_our_customers_say')); ?>

      </h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="flex items-center mb-6">
          <div class="flex-shrink-0">
            <img class="h-16 w-16 rounded-full" src="<?php echo e(asset('images/testimonial-1.jpg')); ?>" alt="Testimonial 1">
          </div>
          <div class="ml-4">
            <h4 class="text-lg font-bold text-dark-900">John Doe</h4>
            <p class="text-primary-600"><?php echo e(__('website.customer')); ?></p>
          </div>
        </div>
        <p class="text-dark-600 italic mb-4">
          "<?php echo e(__('website.testimonial_1')); ?>"
        </p>
        <div class="flex gap-1 mt-auto">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 0; $i < 5; $i++): ?>
            <svg class="h-5 w-5 text-yellow-400" xmlns="[http://www.w3.org/2000/svg"](http://www.w3.org/2000/svg") viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
          <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="flex items-center mb-6">
          <div class="flex-shrink-0">
            <img class="h-16 w-16 rounded-full" src="<?php echo e(asset('images/testimonial-2.jpg')); ?>" alt="Testimonial 2">
          </div>
          <div class="ml-4">
            <h4 class="text-lg font-bold text-dark-900">Jane Smith</h4>
            <p class="text-primary-600"><?php echo e(__('website.customer')); ?></p>
          </div>
        </div>
        <p class="text-dark-600 italic mb-4">
          "<?php echo e(__('website.testimonial_2')); ?>"
        </p>
        <div class="flex gap-1 mt-auto">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 0; $i < 5; $i++): ?>
              <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
              </svg>
            <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="flex items-center mb-6">
          <div class="flex-shrink-0">
            <img class="h-16 w-16 rounded-full" src="<?php echo e(asset('images/testimonial-2.jpg')); ?>" alt="Testimonial 2">
          </div>
          <div class="ml-4">
            <h4 class="text-lg font-bold text-dark-900">Emma Rodriguez</h4>
            <p class="text-primary-600"><?php echo e(__('website.loyal_customer')); ?></p>
          </div>
        </div>
        <p class="text-dark-600 italic mb-4">
          "<?php echo e(__('website.testimonial_3')); ?>"
        </p>
        <div class="flex gap-1 mt-auto">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 0; $i < 5; $i++): ?>
              <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
              </svg>
            <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\server\web\bookify\resources\views/booking-welcome.blade.php ENDPATH**/ ?>