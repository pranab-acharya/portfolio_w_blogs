<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Enums\BlogStatus;
use App\Models\Tag;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, Set $set) => $set('slug', Str::slug($state)))
                    ->maxLength(255),
                TextInput::make('slug')
                    ->live()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Textarea::make('excerpt')
                    ->columnSpanFull()
                    ->required(),
                RichEditor::make('content')
                    ->columnSpanFull()
                    ->required(),
                FileUpload::make('image')
                    ->disk('public')
                    ->visibility('public')
                    ->directory('post_images')
                    ->columnSpanFull(),
                Select::make('tags')
                    ->relationship('tags', 'name')
                    ->preload()
                    ->searchable()
                    ->multiple()
                    ->required()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('description')
                    ])
                    ->createOptionUsing(function (array $data) {
                        Tag::create($data)->getKey();
                    })
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(BlogStatus::class)
                    ->default(BlogStatus::PUBLISHED)
                    ->live(onBlur: true)
                    ->required()
                    ->columnSpan(fn(Get $get) => $get('status') === BlogStatus::SCHEDULED ? 1 : 'full'),
                DateTimePicker::make('published_at')
                    ->label('Scheduled At')
                    ->visible(fn(Get $get) => $get('status') === BlogStatus::SCHEDULED)
                    ->required(fn(Get $get) => $get('status') === BlogStatus::SCHEDULED),
            ]);
    }
}
