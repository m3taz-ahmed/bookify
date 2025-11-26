<div class="flex flex-col items-center justify-center p-6">
    <h2 class="text-xl font-bold mb-4">Booking Reference: {{ $booking->reference_code }}</h2>
    
    @if($booking->qr_code)
        <div class="mb-4">
            <img src="{{ $booking->qr_code }}" alt="QR Code" style="max-width: 200px;">
        </div>
        <p class="text-sm text-gray-600 mt-2">
            Scan this QR code to access your booking details
        </p>
    @else
        <p class="text-gray-500">No QR code available for this booking.</p>
    @endif
</div>