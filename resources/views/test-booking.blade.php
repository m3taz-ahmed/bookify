@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-800">Test Booking</h1>
        </div>
        
        <div class="px-6 py-4">
            <p>Current date format: {{ date('Y-m-d') }}</p>
            <p>Tomorrow's date: {{ date('Y-m-d', strtotime('+1 day')) }}</p>
            
            <form method="POST" action="{{ route('customer.bookings.store') }}" class="mt-6">
                @csrf
                
                <div class="mb-4">
                    <label for="service_id" class="block text-gray-700 text-sm font-bold mb-2">Service</label>
                    <select name="service_id" id="service_id" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Choose a service</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name_en }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="employee_id" class="block text-gray-700 text-sm font-bold mb-2">Employee</label>
                    <select name="employee_id" id="employee_id" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Choose an employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="booking_date" class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                    <input type="date" name="booking_date" id="booking_date" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                           value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                </div>
                
                <div class="mb-4">
                    <label for="start_time" class="block text-gray-700 text-sm font-bold mb-2">Time</label>
                    <input type="time" name="start_time" id="start_time" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md"
                           value="09:00">
                </div>
                
                <div class="flex items-center justify-between">
                    <a href="{{ route('customer.bookings') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Test Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection