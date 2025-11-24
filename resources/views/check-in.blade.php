@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-600 px-6 py-4">
                <h1 class="text-2xl font-bold text-white">Booking Check-In</h1>
            </div>
            
            <div class="p-6">
                @if ($booking)
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-4">Booking Details</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Reference Code</label>
                                <p class="text-lg">{{ $booking->reference_code }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Status</label>
                                <p class="text-lg">
                                    <span class="px-2 py-1 rounded text-sm font-semibold 
                                        @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                        @elseif($booking->status === 'completed') bg-blue-100 text-blue-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Service</label>
                                <p class="text-lg">{{ $booking->service->name_en ?? 'N/A' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Employee</label>
                                <p class="text-lg">{{ $booking->employee->name ?? 'N/A' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Date</label>
                                <p class="text-lg">{{ $booking->booking_date->format('M j, Y') }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Time</label>
                                <p class="text-lg">{{ $booking->start_time }} - {{ $booking->end_time }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Customer Name</label>
                                <p class="text-lg">{{ $booking->customer_name }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Phone</label>
                                <p class="text-lg">{{ $booking->customer_phone }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if ($booking->status === 'confirmed')
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold mb-4">Check-In</h3>
                            <p class="mb-4 text-gray-600">Click the button below to confirm your check-in for this booking.</p>
                            
                            <form id="checkInForm">
                                @csrf
                                <button type="button" 
                                        onclick="performCheckIn()"
                                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                                    Check In Now
                                </button>
                            </form>
                        </div>
                    @elseif ($booking->status === 'completed')
                        <div class="border-t pt-6">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <h3 class="ml-3 text-lg font-medium text-green-800">Already Checked In</h3>
                                </div>
                                <div class="mt-2 text-green-700">
                                    <p>This booking was checked in on {{ $booking->checked_in_at->format('M j, Y g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="border-t pt-6">
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <h3 class="ml-3 text-lg font-medium text-yellow-800">Cannot Check In</h3>
                                </div>
                                <div class="mt-2 text-yellow-700">
                                    <p>This booking is not in a status that allows check-in.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <h3 class="ml-3 text-lg font-medium text-red-800">Booking Not Found</h3>
                        </div>
                        <div class="mt-2 text-red-700">
                            <p>The requested booking could not be found.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function performCheckIn() {
    if (confirm('Are you sure you want to check in for this booking?')) {
        fetch('{{ route("check-in-api", $booking->reference_code) }}', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Check-in successful!');
                location.reload();
            } else {
                alert('Check-in failed: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred during check-in. Please try again.');
        });
    }
}
</script>
@endsection