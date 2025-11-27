<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->schema([
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('title_en')
                    ->label('Title (English)')
                    ->required()
                    ->maxLength(255),
                TextInput::make('title_ar')
                    ->label('Title (Arabic)')
                    ->required()
                    ->maxLength(255),
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
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}