<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Shift;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MultipleShiftsUnitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_allows_multiple_shifts_per_day()
    {
        // Create an employee
        $employee = User::factory()->create();
        $employee->assignRole('employee');

        // Create multiple shifts for the same day
        Shift::create([
            'user_id' => $employee->id,
            'day_of_week' => 1, // Monday
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
        ]);

        Shift::create([
            'user_id' => $employee->id,
            'day_of_week' => 1, // Monday
            'start_time' => '13:00:00',
            'end_time' => '17:00:00',
        ]);

        // Verify that both shifts exist for the same day
        $mondayShifts = Shift::where('user_id', $employee->id)
            ->where('day_of_week', 1)
            ->get();

        $this->assertCount(2, $mondayShifts);
        $this->assertEquals('09:00:00', $mondayShifts[0]->start_time);
        $this->assertEquals('13:00:00', $mondayShifts[1]->start_time);
    }

    /** @test */
    public function it_groups_shifts_by_day_correctly()
    {
        // Create an employee
        $employee = User::factory()->create();
        $employee->assignRole('employee');

        // Create shifts for different days
        Shift::create([
            'user_id' => $employee->id,
            'day_of_week' => 1, // Monday
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
        ]);

        Shift::create([
            'user_id' => $employee->id,
            'day_of_week' => 2, // Tuesday
            'start_time' => '10:00:00',
            'end_time' => '18:00:00',
        ]);

        // Create a second shift for Monday
        Shift::create([
            'user_id' => $employee->id,
            'day_of_week' => 1, // Monday
            'start_time' => '19:00:00',
            'end_time' => '22:00:00',
        ]);

        // Verify shifts are grouped correctly
        $mondayShifts = Shift::where('user_id', $employee->id)
            ->where('day_of_week', 1)
            ->get();

        $tuesdayShifts = Shift::where('user_id', $employee->id)
            ->where('day_of_week', 2)
            ->get();

        $this->assertCount(2, $mondayShifts);
        $this->assertCount(1, $tuesdayShifts);
    }
}