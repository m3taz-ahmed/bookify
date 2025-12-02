<?php

namespace App\Filament\Pages;

use App\Services\MsegatService;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\File;

class MsegatSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 101;

    public ?array $data = [];

    public static function getNavigationLabel(): string
    {
        return 'SMS Settings (Msegat)';
    }

    public function getTitle(): string
    {
        return 'Msegat SMS Configuration';
    }

    public function getView(): string
    {
        return 'filament.pages.msegat-settings';
    }

    public function mount(): void
    {
        $this->form->fill([
            'username' => config('services.msegat.username'),
            'api_key' => config('services.msegat.api_key'),
            'sender' => config('services.msegat.sender'),
            'base_url' => config('services.msegat.base_url'),
            'otp_enabled' => true,
            'booking_sms_enabled' => true,
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Msegat API Credentials')
                    ->description('Configure your Msegat SMS service credentials. Get your credentials from msegat.com')
                    ->schema([
                        TextInput::make('username')
                            ->label('Username')
                            ->required()
                            ->placeholder('techflipp')
                            ->helperText('Your Msegat account username'),

                        TextInput::make('api_key')
                            ->label('API Key')
                            ->required()
                            ->password()
                            ->revealable()
                            ->placeholder('4563eb312a38125a5b63acb0d57bd57a')
                            ->helperText('Your Msegat API key'),

                        TextInput::make('sender')
                            ->label('Sender Name')
                            ->required()
                            ->placeholder('Bookify')
                            ->maxLength(11)
                            ->helperText('The sender name that will appear in SMS (max 11 characters)'),

                        TextInput::make('base_url')
                            ->label('Base URL')
                            ->required()
                            ->url()
                            ->default('https://www.msegat.com/gw')
                            ->helperText('Msegat API base URL (usually no need to change)'),
                    ])->columns(2),

                Section::make('SMS Features')
                    ->description('Enable or disable SMS features')
                    ->schema([
                        Toggle::make('otp_enabled')
                            ->label('Enable OTP SMS')
                            ->helperText('Send OTP codes via SMS for customer authentication')
                            ->default(true),

                        Toggle::make('booking_sms_enabled')
                            ->label('Enable Booking Notifications SMS')
                            ->helperText('Send SMS notifications for booking confirmations and cancellations')
                            ->default(true),
                    ])->columns(2),

                Section::make('Test SMS')
                    ->description('Test your SMS configuration by sending a test message')
                    ->schema([
                        TextInput::make('test_phone')
                            ->label('Test Phone Number')
                            ->tel()
                            ->placeholder('966xxxxxxxxx')
                            ->helperText('Enter a phone number in international format (e.g., 966xxxxxxxxx)'),

                        Textarea::make('test_message')
                            ->label('Test Message')
                            ->placeholder('This is a test message from SkyBridge')
                            ->rows(3)
                            ->helperText('The message to send'),
                    ])->columns(1),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Update .env file
        $this->updateEnvFile([
            'MSEGAT_USERNAME' => $data['username'],
            'MSEGAT_API_KEY' => $data['api_key'],
            'MSEGAT_SENDER' => $data['sender'],
            'MSEGAT_BASE_URL' => $data['base_url'],
        ]);

        // Clear config cache
        \Artisan::call('config:clear');

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }

    public function testSms(): void
    {
        $data = $this->form->getState();

        if (empty($data['test_phone']) || empty($data['test_message'])) {
            Notification::make()
                ->title('Please fill in both phone number and message')
                ->warning()
                ->send();
            return;
        }

        $msegatService = app(MsegatService::class);
        $result = $msegatService->sendSms($data['test_phone'], $data['test_message']);

        if ($result['success']) {
            Notification::make()
                ->title('Test SMS sent successfully!')
                ->body('Message ID: ' . ($result['msg_id'] ?? 'N/A'))
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Failed to send test SMS')
                ->body($result['message'])
                ->danger()
                ->send();
        }
    }

    protected function updateEnvFile(array $data): void
    {
        $envPath = base_path('.env');

        if (!File::exists($envPath)) {
            return;
        }

        $envContent = File::get($envPath);

        foreach ($data as $key => $value) {
            $value = str_replace('"', '\"', $value);
            
            if (str_contains($envContent, $key . '=')) {
                // Update existing key
                $envContent = preg_replace(
                    "/^{$key}=.*/m",
                    "{$key}=\"{$value}\"",
                    $envContent
                );
            } else {
                // Add new key
                $envContent .= "\n{$key}=\"{$value}\"";
            }
        }

        File::put($envPath, $envContent);
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('save')
                ->label('Save Settings')
                ->action('save')
                ->color('primary'),
            
            \Filament\Actions\Action::make('test')
                ->label('Send Test SMS')
                ->action('testSms')
                ->color('warning')
                ->icon('heroicon-o-paper-airplane'),
        ];
    }
}
