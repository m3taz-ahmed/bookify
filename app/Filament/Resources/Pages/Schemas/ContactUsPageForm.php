<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactUsPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->schema([
                self::getContactInfoFields(),
                self::getOfficeLocationFields(),
                self::getAdditionalInfoFields(),
            ]);
    }
    
    protected static function getContactInfoFields(): Section
    {
        return Section::make('Contact Information')
            ->columns(2)
            ->schema([
                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Phone Number')
                    ->tel()
                    ->maxLength(20),
                TextInput::make('whatsapp')
                    ->label('WhatsApp Number')
                    ->tel()
                    ->maxLength(20),
                TextInput::make('address_en')
                    ->label('Address (English)')
                    ->maxLength(255),
                TextInput::make('address_ar')
                    ->label('Address (Arabic)')
                    ->maxLength(255),
                RichEditor::make('contact_description_en')
                    ->label('Contact Description (English)')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ]),
                RichEditor::make('contact_description_ar')
                    ->label('Contact Description (Arabic)')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ]),
            ]);
    }
    
    protected static function getOfficeLocationFields(): Section
    {
        return Section::make('Office Location')
            ->schema([
                TextInput::make('latitude')
                    ->label('Latitude')
                    ->numeric()
                    ->step(0.000001),
                TextInput::make('longitude')
                    ->label('Longitude')
                    ->numeric()
                    ->step(0.000001),
                TextInput::make('map_zoom')
                    ->label('Map Zoom Level')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(20)
                    ->default(15),
                RichEditor::make('location_description_en')
                    ->label('Location Description (English)')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ]),
                RichEditor::make('location_description_ar')
                    ->label('Location Description (Arabic)')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ]),
            ]);
    }
    
    protected static function getAdditionalInfoFields(): Section
    {
        return Section::make('Additional Information')
            ->schema([
                RichEditor::make('additional_info_en')
                    ->label('Additional Information (English)')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ]),
                RichEditor::make('additional_info_ar')
                    ->label('Additional Information (Arabic)')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ]),
            ]);
    }
}