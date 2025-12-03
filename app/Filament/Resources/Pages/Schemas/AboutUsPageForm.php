<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutUsPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->schema([
                self::getCompanyInfoFields(),
                self::getHistoryFields(),
                self::getMissionVisionFields(),
                self::getTeamFields(),
            ]);
    }
    
    protected static function getCompanyInfoFields(): Section
    {
        return Section::make('Company Information')
            ->columns(2)
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
            ]);
    }
    
    protected static function getHistoryFields(): Section
    {
        return Section::make('Our History')
            ->schema([
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
            ]);
    }
    
    protected static function getMissionVisionFields(): Section
    {
        return Section::make('Mission & Vision')
            ->columns(2)
            ->schema([
                RichEditor::make('mission_en')
                    ->label('Mission (English)')
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
                RichEditor::make('mission_ar')
                    ->label('Mission (Arabic)')
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
                RichEditor::make('vision_en')
                    ->label('Vision (English)')
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
                RichEditor::make('vision_ar')
                    ->label('Vision (Arabic)')
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
    
    protected static function getTeamFields(): Section
    {
        return Section::make('Our Team')
            ->schema([
                RichEditor::make('team_en')
                    ->label('Team Information (English)')
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
                RichEditor::make('team_ar')
                    ->label('Team Information (Arabic)')
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