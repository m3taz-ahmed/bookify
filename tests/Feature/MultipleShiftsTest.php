<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Shift;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class MultipleShiftsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_multiple_shifts_for_same_day()
    {
        // Create an employee
        $employee = User::factory()->create();
        $employee->assignRole('employee');

        // Create multiple shifts for the same day
        $shifts = [
            [
                'user_id' => $employee->id,
                'day_of_week' => 1, // Monday
                'start_time' => '09:00:00',
                'end_time' => '12:00:00',
            ],
            [
                'user_id' => $employee->id,
                'day_of_week' => 1, // Monday
                'start_time' => '13:00:00',
                'end_time' => '17:00:00',
            ]
        ];

        foreach ($shifts as $shiftData) {
            Shift::create($shiftData);
        }

        // Verify that both shifts were created
        $this->assertEquals(2, Shift::where('user_id', $employee->id)->count());
        $this->assertEquals(2, Shift::where('user_id', $employee->id)->where('day_of_week', 1)->count());
    }

    /** @test */
    public function it_can_update_multiple_shifts()
    {
        // Create an employee
        $employee = User::factory()->create();
        $employee->assignRole('employee');

        // Create initial shifts
        $shift1 = Shift::create([
            'user_id' => $employee->id,
            'day_of_week' => 1,
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
        ]);

        $shift2 = Shift::create([
            'user_id' => $employee->id,
            'day_of_week' => 1,
            'start_time' => '13:00:00',
            'end_time' => '17:00:00',
        ]);

        // Update one of the shifts
        Shift::where('id', $shift1->id)->update([
            'start_time' => '10:00:00',
            'end_time' => '13:00:00',
        ]);

        // Verify the update
        $updatedShift = Shift::find($shift1->id);
        $this->assertEquals('10:00:00', $updatedShift->start_time);
        $this->assertEquals('13:00:00', $updatedShift->end_time);

        // Verify the other shift is unchanged
        $unchangedShift = Shift::find($shift2->id);
        $this->assertEquals('13:00:00', $unchangedShift->start_time);
        $this->assertEquals('17:00:00', $unchangedShift->end_time);
    }

    /** @test */
    public function it_can_delete_specific_shifts()
    {
        // Create an employee
        $employee = User::factory()->create();
        $employee->assignRole('employee');

        // Create multiple shifts
        $shift1 = Shift::create([
            'user_id' => $employee->id,
            'day_of_week' => 1,
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
        ]);

        $shift2 = Shift::create([
            'user_id' => $employee->id,
            'day_of_week' => 1,
            'start_time' => '13:00:00',
            'end_time' => '17:00:00',
        ]);

        // Delete one shift
        Shift::destroy($shift1->id);

        // Verify that only one shift remains
        $this->assertEquals(1, Shift::where('user_id', $employee->id)->count());
        $this->assertNull(Shift::find($shift1->id));
        $this->assertNotNull(Shift::find($shift2->id));
    }
}