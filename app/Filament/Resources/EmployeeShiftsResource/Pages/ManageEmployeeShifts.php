<?php

namespace App\Filament\Resources\EmployeeShiftsResource\Pages;

use App\Filament\Resources\EmployeeShiftsResource;
use App\Models\Shift;
use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;
use Filament\Resources\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ManageEmployeeShifts extends Page
{
    protected static string $resource = EmployeeShiftsResource::class;

    public static function getLabel(): string
    {
        return __('filament.Employee Shifts');
    }

    public static function getPluralLabel(): string
    {
        return __('filament.Employee Shifts');
    }

    public function getView(): string
    {
        return 'filament.resources.employee-shifts.pages.manage-employee-shifts';
    }

    // protected static ?string $title = 'Manage Employee Shifts';

    public ?int $userId = null;
    public array $shifts = [];

    public function mount(): void
    {
        $this->form->fill();
        $this->loadShifts();
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Select::make('userId')
                    ->label(__('filament.Employee'))
                    ->options(User::whereHas('roles', function ($query) {
                        $query->where('name', 'employee');
                    })->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(function ($state) {
                        $this->userId = (int) $state;
                        $this->loadShifts();
                    }),
            ]);
    }

    public function loadShifts(): void
    {
        if (!$this->userId) {
            $this->shifts = [];
            return;
        }

        // Initialize shifts for all days of the week
        $daysOfWeek = range(0, 6); // 0 = Sunday, 1 = Monday, ..., 6 = Saturday
        
        foreach ($daysOfWeek as $day) {
            $shift = Shift::where('user_id', $this->userId)
                ->where('day_of_week', $day)
                ->first();
            
            $this->shifts[$day] = [
                'id' => $shift?->id,
                'day_of_week' => $day,
                'start_time' => $shift?->start_time?->format('H:i') ?? '',
                'end_time' => $shift?->end_time?->format('H:i') ?? '',
            ];
        }
    }

    public function save(): void
    {
        if (!$this->userId) {
            return;
        }

        DB::transaction(function () {
            foreach ($this->shifts as $day => $shiftData) {
                $startTime = $shiftData['start_time'] ?? null;
                $endTime = $shiftData['end_time'] ?? null;

                // Skip if both times are empty
                if (empty($startTime) && empty($endTime)) {
                    // Delete existing shift if it exists
                    if (!empty($shiftData['id'])) {
                        Shift::destroy($shiftData['id']);
                    }
                    continue;
                }

                // Validate that both times are provided
                if (empty($startTime) || empty($endTime)) {
                    continue;
                }

                // Save or update the shift
                Shift::updateOrCreate(
                    [
                        'user_id' => $this->userId,
                        'day_of_week' => $day,
                    ],
                    [
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                    ]
                );
            }
        });

        $this->loadShifts(); // Reload shifts after saving
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