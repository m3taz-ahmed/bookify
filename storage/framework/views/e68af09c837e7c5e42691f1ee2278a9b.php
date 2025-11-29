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
      <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-background-200 overflow-hidden">
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
                <?php
                  // Find the next available time slot
                  $nextAvailable = \App\Services\NextAvailableSlotService::getNextAvailableSlot();
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($nextAvailable): ?>
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($nextAvailable['is_available_now']): ?>
                    <p class="text-sm text-dark-500"><?php echo e(__('website.available_now')); ?></p>
                  <?php else: ?>
                    <p class="text-sm text-dark-500"><?php echo e(__('website.today_at')); ?> <?php echo e($nextAvailable['time']); ?></p>
                  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php else: ?>
                  <p class="text-sm text-dark-500"><?php echo e(__('website.no_available_slots_today')); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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

          <div class="relative h-64 rounded-t-lg overflow-hidden image-slider-container">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($service->images->isNotEmpty()): ?>
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $service->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="image-slide absolute inset-0 transition-opacity duration-500 <?php echo e($index === 0 ? 'opacity-100' : 'opacity-0'); ?>">
                  <img src="<?php echo e(Storage::url($image->image)); ?>" class="w-full h-full object-cover">
                </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($service->images->count() > 1): ?>
                <button class="slider-prev absolute left-0 top-1/2 -translate-y-1/2 bg-black bg-opacity-30 hover:bg-opacity-50 text-white rounded-r-full p-3 z-10">
                  ‹
                </button>
                <button class="slider-next absolute right-0 top-1/2 -translate-y-1/2 bg-black bg-opacity-30 hover:bg-opacity-50 text-white rounded-l-full p-3 z-10">
                  ›
                </button>
              <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php else: ?>
              <img src="https://i.ibb.co/2c8Q0kM/default-avatar.png" class="w-full h-full object-cover">
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </div>

          <div class="p-8 flex flex-col flex-grow">
            <div class="text-center mb-6 flex-grow">
              <h4 class="text-2xl font-bold text-dark-900 mb-3"><?php echo e($service->name); ?></h4>
              <p class="text-dark-600">
                <?php echo e($service->description); ?>

              </p>
            </div>
            <div class="mt-auto">
              <p class="text-center text-primary-600 font-bold text-2xl mb-6">$<?php echo e($service->price); ?></p>
              <div class="text-center">
                <a href="<?php echo e(route('customer.bookings.create')); ?>" class="inline-block bg-primary-500 hover:bg-primary-700 text-white font-bold py-3 px-6 rounded-lg transition">
                    <?php echo e(__('website.book_now')); ?>

                </a>
              </div>
            </div>
          </div>

        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
  </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const sliders = document.querySelectorAll('.image-slider-container');

  sliders.forEach(function(container) {
    const slides = container.querySelectorAll('.image-slide');
    const prev = container.querySelector('.slider-prev');
    const next = container.querySelector('.slider-next');
    let current = 0;

    function show(i) {
      slides.forEach(s => s.classList.replace('opacity-100', 'opacity-0'));
      slides[i].classList.replace('opacity-0', 'opacity-100');
    }

    if (slides.length < 2) return;

    const auto = setInterval(() => {
      current = (current + 1) % slides.length;
      show(current);
    }, 5000);

    if (next) {
      next.onclick = e => {
        e.stopPropagation();
        clearInterval(auto);
        current = (current + 1) % slides.length;
        show(current);
      };
    }

    if (prev) {
      prev.onclick = e => {
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
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\server\web\bookify\resources\views/booking-welcome.blade.php ENDPATH**/ ?>