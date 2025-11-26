<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'payment_method' => 'required|in:cash,online',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'customer_name.required' => 'Customer name is required',
            'customer_phone.required' => 'Customer phone is required',
            'service_id.required' => 'Please select a service',
            'booking_date.required' => 'Please select a date',
            'booking_date.after' => 'Booking date must be in the future',
            'start_time.required' => 'Please select a start time',
            'end_time.required' => 'Please select an end time',
            'end_time.after' => 'End time must be after start time',
            'payment_method.required' => 'Please select a payment method',
            'payment_method.in' => 'Invalid payment method selected',
        ];
    }
}