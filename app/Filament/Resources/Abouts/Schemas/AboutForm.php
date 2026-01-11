<?php

namespace App\Filament\Resources\Abouts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AboutForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Full name')
                    ->columnSpan(1),
                
                TextInput::make('profession')
                    ->maxLength(255)
                    ->placeholder('e.g. Software Engineer, Designer')
                    ->columnSpan(1),

                RichEditor::make('bio')
                    ->label('Biography')
                    ->placeholder('Tell us about this person...')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'link',
                        'bulletList',
                        'orderedList',
                    ]),

                FileUpload::make('image')
                    ->label('Profile Image')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->visibility('public')
                    ->directory('profile')
                    ->maxSize(2048)
                    ->columnSpanFull(),

                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->maxLength(255)
                    ->placeholder('email@example.com')
                    ->columnSpan(1),
                
                TextInput::make('phone')
                    ->label('Phone Number')
                    ->tel()
                    ->maxLength(255)
                    ->placeholder('+1 (555) 123-4567')
                    ->columnSpan(1),

                Repeater::make('social_links')
                    ->label('Social Media Links')
                    ->schema([
                        TextInput::make('platform')
                            ->label('Platform')
                            ->placeholder('e.g. github, twitter, linkedin')
                            ->required()
                            ->columnSpan(1),
                        
                        TextInput::make('url')
                            ->label('URL')
                            ->url()
                            ->placeholder('https://...')
                            ->required()
                            ->columnSpan(1),
                    ])
                    ->columns(2)
                    ->reorderable()
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['platform'] ?? null)
                    ->addActionLabel('Add Social Link')
                    ->columnSpanFull(),

                TextInput::make('order')
                    ->label('Display Order')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->helperText('Lower numbers appear first')
                    ->columnSpan(1),
                
                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->helperText('Only active members will be shown on the about page')
                    ->columnSpan(1),
            ]);
    }
}
