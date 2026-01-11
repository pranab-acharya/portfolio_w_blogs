<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Enums\BlogStatus;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('slug'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('published_at')
                    ->badge()
                    ->label(fn($record) => $record->status === BlogStatus::PUBLISHED ? 'Published At' : 'Scheduled At')
                    ->visible(fn($record) => $record !== BlogStatus::DRAFT)
                    ->dateTime(),
                ImageEntry::make('image')
                    ->imageWidth(1500)
                    ->imageHeight(500)
                    ->disk('public')
                    ->columnSpanFull(),
                TextEntry::make('excerpt')
                    ->columnSpanFull(),
                TextEntry::make('content')
                    ->columnSpanFull()
                    ->html()
                    ->prose(),
            ]);
    }
}
