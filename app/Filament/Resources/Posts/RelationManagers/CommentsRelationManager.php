<?php

namespace App\Filament\Resources\Posts\RelationManagers;

use App\Enums\CommentStatus;
use App\Models\Comment;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $recordTitleAttribute = 'comment';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('comment')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Select::make('parent_id')
                    ->label('Reply to Comment')
                    ->options(fn($livewire) => $livewire->getOwnerRecord()->comments()
                        ->whereNull('parent_id')
                        ->pluck('comment', 'id')
                        ->toArray())
                    ->searchable()
                    ->placeholder('Select a comment to reply to (optional)'),
                Select::make('status')
                    ->options(CommentStatus::class)
                    ->default(CommentStatus::PENDING)
                    ->required(),
                TextInput::make('guest_name')
                    ->maxLength(255),
                TextInput::make('guest_email')
                    ->email()
                    ->maxLength(255),
                TextInput::make('ip_address')
                    ->maxLength(45),
                Textarea::make('user_agent')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('comment')
            ->columns([
                TextColumn::make('comment')
                    ->limit(50)
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(function ($state, Comment $record) {
                        $indent = '';
                        $level = 0;
                        $parent = $record->parent;

                        while ($parent) {
                            $level++;
                            $parent = $parent->parent;
                        }

                        if ($level > 0) {
                            $indent = str_repeat('└─ ', $level);
                        }

                        return $indent . $state;
                    })
                    ->html(),
                TextColumn::make('parent.comment')
                    ->label('Parent Comment')
                    ->limit(30)
                    ->toggleable()
                    ->placeholder('Top-level comment'),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('guest_name')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('guest_email')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('ip_address')
                    ->toggleable(),
                TextColumn::make('user_agent')
                    ->limit(30)
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort(fn($query) => $query->orderByRaw('COALESCE(parent_id, id), id'))
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(CommentStatus::class),
                Tables\Filters\TernaryFilter::make('parent_id')
                    ->label('Comment Type')
                    ->placeholder('All comments')
                    ->trueLabel('Replies only')
                    ->falseLabel('Top-level only')
                    ->queries(
                        true: fn($query) => $query->whereNotNull('parent_id'),
                        false: fn($query) => $query->whereNull('parent_id'),
                    ),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
