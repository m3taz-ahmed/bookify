<?php

namespace App\Filament\Resources\MultipleShifts\Pages;

use App\Filament\Resources\MultipleShifts\MultipleShiftsResource;
use App\Models\Shift;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Resources\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class ManageMultipleShifts extends Page
{
    protected static string $resource = MultipleShiftsResource::class;

    public function getView(): string
    {
        return 'filament.resources.multiple-shifts.pages.manage-multiple-shifts';
    }

    protected static ?string $title = 'Manage Multiple Shifts';

    public ?int $userId = null;
    public array $shiftGroups = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Select::make('userId')
                    ->label('Employee')
                    ->options(User::whereHas('roles', function ($query) {
                        $query->where('name', 'employee');
                    })->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(function ($state) {
                        $this->userId = (int) $state;
                        $this->loadMultipleShifts();
                    }),
            ]);
    }

    public function loadMultipleShifts(): void
    {
        if (!$this->userId) {
            $this->shiftGroups = [];
            return;
        }

        // Initialize shift groups for all days of the week
        $daysOfWeek = range(0, 6); // 0 = Sunday, 1 = Monday, ..., 6 = Saturday
        
        foreach ($daysOfWeek as $day) {
            // Get all shifts for this user on this day
            $shifts = Shift::where('user_id', $this->userId)
                ->where('day_of_week', $day)
                ->get();
            
            // If no shifts exist for this day, initialize with one empty shift
            if ($shifts->isEmpty()) {
                $this->shiftGroups[$day] = [
                    [
                        'id' => null,
                        'day_of_week' => $day,
                        'start_time' => '',
                        'end_time' => '',
                    ]
                ];
            } else {
                // Convert existing shifts to our format
                $this->shiftGroups[$day] = $shifts->map(function ($shift) {
                    return [
                        'id' => $shift->id,
                        'day_of_week' => $shift->day_of_week,
                        'start_time' => $shift->start_time->format('H:i'),
                        'end_time' => $shift->end_time->format('H:i'),
                    ];
                })->toArray();
            }
        }
    }

    public function addShiftBlock(int $day): void
    {
        $this->shiftGroups[$day][] = [
            'id' => null,
            'day_of_week' => $day,
            'start_time' => '',
            'end_time' => '',
        ];
    }

    public function removeShiftBlock(int $day, int $index): void
    {
        // Don't allow removing the last shift block
        if (count($this->shiftGroups[$day]) <= 1) {
            Notification::make()
                ->title('Cannot remove shift')
                ->body('Each day must have at least one shift block.')
                ->danger()
                ->send();
            return;
        }

        // If this is an existing shift, delete it from the database
        if (!empty($this->shiftGroups[$day][$index]['id'])) {
            Shift::destroy($this->shiftGroups[$day][$index]['id']);
        }

        // Remove the shift block from the array
        unset($this->shiftGroups[$day][$index]);
        $this->shiftGroups[$day] = array_values($this->shiftGroups[$day]);
    }

    public function save(): void
    {
        if (!$this->userId) {
            return;
        }

        DB::transaction(function () {
            // First, let's get all existing shifts for this user to track which ones we need to delete
            $existingShiftIds = Shift::where('user_id', $this->userId)->pluck('id')->toArray();
            $processedShiftIds = [];

            foreach ($this->shiftGroups as $day => $shifts) {
                foreach ($shifts as $index => $shiftData) {
                    $startTime = $shiftData['start_time'] ?? null;
                    $endTime = $shiftData['end_time'] ?? null;
                    $shiftId = $shiftData['id'] ?? null;

                    // Skip if both times are empty
                    if (empty($startTime) && empty($endTime)) {
                        continue;
                    }

                    // Validate that both times are provided
                    if (empty($startTime) || empty($endTime)) {
                        continue;
                    }

                    // Track processed shift IDs
                    if (!empty($shiftId)) {
                        $processedShiftIds[] = $shiftId;
                    }

                    // Save or update the shift
                    if (!empty($shiftId)) {
                        // Update existing shift
                        Shift::where('id', $shiftId)->update([
                            'user_id' => $this->userId,
                            'day_of_week' => $day,
                            'start_time' => $startTime,
                            'end_time' => $endTime,
                        ]);
                    } else {
                        // Create new shift
                        Shift::create([
                            'user_id' => $this->userId,
                            'day_of_week' => $day,
                            'start_time' => $startTime,
                            'end_time' => $endTime,
                        ]);
                    }
                }
            }

            // Delete shifts that were removed
            $shiftsToDelete = array_diff($existingShiftIds, $processedShiftIds);
            if (!empty($shiftsToDelete)) {
                Shift::destroy($shiftsToDelete);
            }
        });

        $this->loadMultipleShifts(); // Reload shifts after saving
        Notification::make()
            ->title('Shifts saved successfully.')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Shifts')
                ->submit('save')
                ->keyBindings(['mod+s']),
        ];
    }
}