<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Models\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DynamicPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->schema([
                Select::make('type')
                    ->options(Page::getTypes())
                    ->required()
                    ->live()
                    ->columnSpanFull(),
                
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->columnSpanFull(),
                
                // Titles section (always visible)
                self::getTitleFields(),
                
                // Conditional sections based on page type
                self::getAboutUsFields(),
                self::getContactUsFields(),
                self::getGeneralContentFields(),
                
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
    
    protected static function getTitleFields(): Section
    {
        return Section::make('Titles')
            ->columns(2)
            ->schema([
                TextInput::make('title_en')
                    ->label('Title (English)')
                    ->required()
                    ->maxLength(255),
                TextInput::make('title_ar')
                    ->label('Title (Arabic)')
                    ->required()
                    ->maxLength(255),
            ]);
    }
    
    protected static function getAboutUsFields(): Section
    {
        return Section::make('About Us Specific Fields')
            ->schema([
                TextInput::make('company_name_en')
                    ->label('Company Name (English)')
                    ->maxLength(255),
                TextInput::make('company_name_ar')
                    ->label('Company Name (Arabic)')
                    ->maxLength(255),
                TextInput::make('founded_year')
                    ->label('Founded Year')
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue(date('Y')),
                TextInput::make('location_en')
                    ->label('Location (English)')
                    ->maxLength(255),
                TextInput::make('location_ar')
                    ->label('Location (Arabic)')
                    ->maxLength(255),
                RichEditor::make('company_description_en')
                    ->label('Company Description (English)')
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
                RichEditor::make('company_description_ar')
                    ->label('Company Description (Arabic)')
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
                RichEditor::make('history_en')
                    ->label('History (English)')
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
                RichEditor::make('history_ar')
                    ->label('History (Arabic)')
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
            ])
            ->visible(fn ($get) => $get('type') == Page::TYPE_ABOUT_US);
    }
    
    protected static function getContactUsFields(): Section
    {
        return Section::make('Contact Us Specific Fields')
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
            ])
            ->visible(fn ($get) => $get('type') == Page::TYPE_CONTACT_US);
    }
    
    protected static function getGeneralContentFields(): Section
    {
        return Section::make('General Content Fields')
            ->schema([
                RichEditor::make('content_en')
                    ->label('Content (English)')
                    ->required()
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
                    ])
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsDirectory('pages/images')
                    ->fileAttachmentsVisibility('public'),
                RichEditor::make('content_ar')
                    ->label('Content (Arabic)')
                    ->required()
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
                    ])
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsDirectory('pages/images')
                    ->fileAttachmentsVisibility('public'),
            ])
            ->visible(fn ($get) => !empty($get('type')) && !in_array($get('type'), [Page::TYPE_ABOUT_US, Page::TYPE_CONTACT_US]));
    }
}