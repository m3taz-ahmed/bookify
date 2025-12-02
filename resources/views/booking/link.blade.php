@php($isAr = app()->getLocale() === 'ar')
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
  <div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
      <div class="px-6 py-6 border-b border-gray-200 bg-gradient-to-r from-background-50 to-accent-50">
        <h1 class="text-2xl font-bold text-gray-900">{{ $isAr ? 'تفاصيل الحجز' : 'Booking Details' }}</h1>
        <p class="mt-1 text-sm text-gray-600">{{ $isAr ? 'عرض معلومات الحجز' : 'A summary of your booking' }}</p>
      </div>

      <div class="px-6 py-6">
        @if(!empty($error))
          <div class="bg-red-50 border border-red-200 rounded-xl p-4">
            <p class="text-red-700">{{ $errorMessage }}</p>
          </div>
        @elseif(!empty($isExpired) && $isExpired)
          <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
            <p class="text-yellow-700">{{ $isAr ? 'انتهت صلاحية الحجز' : 'This booking has expired' }}</p>
          </div>
        @else
          <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="bg-gradient-to-br from-white to-primary-50 rounded-2xl p-5 border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900">{{ $isAr ? 'بيانات العميل' : 'Customer' }}</h2>
                <div class="mt-3 text-gray-700">
                  <p class="mb-1">{{ $isAr ? 'الاسم' : 'Name' }}: <span class="font-semibold">{{ $booking->customer->name }}</span></p>
                  <p>{{ $isAr ? 'الهاتف' : 'Phone' }}: <span class="font-mono">{{ $booking->customer->phone }}</span></p>
                </div>
              </div>

              <div class="bg-gradient-to-br from-white to-secondary-50 rounded-2xl p-5 border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900">{{ $isAr ? 'المرجع والدفع' : 'Reference & Payment' }}</h2>
                <div class="mt-3 text-gray-700">
                  <p class="mb-1">{{ $isAr ? 'رقم المرجع' : 'Reference' }}: <span class="font-mono font-semibold">{{ $booking->reference_code }}</span></p>
                  <p>{{ $isAr ? 'طريقة الدفع' : 'Payment' }}: <span class="font-semibold">{{ $booking->payment_method === 'cash' ? ($isAr ? 'عند الحضور' : 'Pay on Arrival') : ($isAr ? 'أونلاين' : 'Online') }}</span></p>
                </div>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="bg-indigo-50 rounded-2xl p-5 border border-indigo-100">
                <h2 class="text-lg font-semibold text-gray-900">{{ $isAr ? 'الميعاد' : 'Schedule' }}</h2>
                <div class="mt-3 text-gray-700">
                  <p class="mb-1">{{ $isAr ? 'التاريخ' : 'Date' }}: <span class="font-semibold">{{ \Carbon\Carbon::parse($booking->booking_date)->timezone('Asia/Riyadh')->format($isAr ? 'Y-m-d' : 'M j, Y') }}</span></p>
                  <p>{{ $isAr ? 'الوقت' : 'Time' }}: <span class="font-semibold">{{ \Carbon\Carbon::createFromTimeString($booking->start_time)->format('H:i') }}</span></p>
                </div>
              </div>

              <div class="bg-green-50 rounded-2xl p-5 border border-green-100 text-center">
                <h2 class="text-lg font-semibold text-gray-900 mb-3">QR</h2>
                @if($booking->qr_code)
                  <img src="{{ $booking->qr_code }}" alt="QR" class="mx-auto w-40 h-40">
                @else
                  <p class="text-gray-600">{{ $isAr ? 'لا يوجد رمز QR' : 'No QR code' }}</p>
                @endif
              </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl p-5">
              <h2 class="text-lg font-semibold text-gray-900">{{ $isAr ? 'تفاصيل التذاكر' : 'Tickets' }}</h2>
              <div class="mt-3 text-gray-700">
                @php($grand = 0)
                @if($booking->items && $booking->items->count() > 0)
                  <div class="space-y-2">
                    @foreach($booking->items as $item)
                      @php($line = ($item->total_price ?? ($item->unit_price * $item->quantity)))
                      @php($grand += $line)
                      <div class="flex items-center justify-between">
                        <div>
                          <span class="font-semibold">{{ $item->service->name }}</span>
                          <span class="ml-2 text-sm text-gray-600">×{{ $item->quantity }}</span>
                        </div>
                        <div class="text-sm text-gray-800">
                          <span class="text-gray-600">{{ $isAr ? 'سعر الفرد' : 'Unit' }}:</span>
                          <span class="inline-flex items-center gap-1 font-semibold">
                            {{ number_format($item->unit_price, 2) }}
                          </span>
                          <span class="mx-1">•</span>
                          <span class="text-gray-600">{{ $isAr ? 'الإجمالي' : 'Total' }}:</span>
                          <span class="inline-flex items-center gap-1 font-semibold">
                            {{ number_format($line, 2) }}
                          </span>
                        </div>
                      </div>
                    @endforeach
                  </div>
                  <div class="mt-4 pt-3 border-t flex items-center justify-between">
                    <span class="text-sm text-gray-700">{{ $isAr ? 'إجمالي الأفراد' : 'Total people' }}</span>
                    <span class="font-semibold">{{ $booking->number_of_people }}</span>
                  </div>
                  <div class="mt-2 flex items-center justify-between">
                    <span class="text-sm text-gray-700">{{ $isAr ? 'المجموع الكلي' : 'Grand total' }}</span>
                    <span class="inline-flex items-center gap-1 font-bold text-gray-900">
                      <x-sar-icon class="w-5 h-5" />
                      {{ number_format($grand, 2) }}
                    </span>
                  </div>
                @else
                  <p class="text-gray-600">{{ $isAr ? 'لا توجد تذاكر' : 'No tickets' }}</p>
                @endif
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
