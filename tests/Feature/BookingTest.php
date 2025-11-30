<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function customer_can_create_a_booking_with_cash_payment()
    {
        // Create a customer
        $customer = Customer::factory()->create([
            'name' => 'John Doe',
            'phone' => '1234567890',
        ]);

        // Create a service
        $service = Service::factory()->create([
            'name' => 'Haircut',
            'duration_minutes' => 30,
            'price' => 25.00,
            'is_active' => true,
        ]);

        // Login as customer
        $this->actingAs($customer->fresh(), 'customer');

        // Visit the booking creation page
        $response = $this->get(route('customer.bookings.create'));
        $response->assertStatus(200);

        // Submit booking form
        $response = $this->post(route('customer.bookings.store'), [
            'service_id' => $service->id,
            'booking_date' => now()->addDay()->format('Y-m-d'),
            'start_time' => '10:00',
            'number_of_people' => 1,
            'payment_method' => 'cash',
        ]);

        // Assert redirect to bookings page
        $response->assertRedirect(route('customer.bookings'));

        // Assert booking was created
        $this->assertDatabaseHas('bookings', [
            'customer_id' => $customer->id,
            'service_id' => $service->id,
            'payment_method' => 'cash',
            'status' => 'confirmed',
        ]);
    }

    /** @test */
    public function customer_can_view_their_bookings()
    {
        // Create a customer
        $customer = Customer::factory()->create([
            'name' => 'John Doe',
            'phone' => '1234567890',
        ]);

        // Create a service
        $service = Service::factory()->create([
            'name' => 'Haircut',
            'duration_minutes' => 30,
            'price' => 25.00,
            'is_active' => true,
        ]);

        // Create a booking
        $booking = $customer->bookings()->create([
            'service_id' => $service->id,
            'booking_date' => now()->addDay(),
            'start_time' => '10:00:00',
            'reference_code' => 'ABC123',
            'status' => 'confirmed',
            'number_of_people' => 1,
            'payment_method' => 'cash',
        ]);

        // Login as customer
        $this->actingAs($customer->fresh(), 'customer');

        // Visit the bookings page
        $response = $this->get(route('customer.bookings'));
        $response->assertStatus(200);
        $response->assertSee($service->name);
        $response->assertSee('ABC123');
    }
}