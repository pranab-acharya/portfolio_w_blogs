<?php

namespace App\Notifications;

use App\Enums\CommentStatus;
use App\Models\Comment;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Comment $comment
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return FilamentNotification::make()
            ->title('New Comment Posted')
            ->body("**{$this->comment->guest_name}** commented on \"{$this->comment->post->title}\"")
            ->icon('heroicon-o-chat-bubble-left-ellipsis')
            ->iconColor('warning')
            ->actions([
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->button()
                    ->markAsRead()
                    ->disabled(fn() => $this->comment->fresh()->status !== CommentStatus::PENDING)
                    ->dispatch('approveComment', ['commentId' => $this->comment->id]),

                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->button()
                    ->markAsRead()
                    ->disabled(fn() => $this->comment->fresh()->status !== CommentStatus::PENDING)
                    ->dispatch('rejectComment', ['commentId' => $this->comment->id]),

                Action::make('view')
                    ->label('View Comment')
                    ->icon('heroicon-o-eye')
                    ->url(route('filament.admin.resources.posts.view', [
                        'record' => $this->comment->post_id,
                    ]))
                    ->button()
                    ->outlined(),
            ])
            ->getDatabaseMessage();
    }
}
