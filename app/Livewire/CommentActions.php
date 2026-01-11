<?php

namespace App\Livewire;

use App\Enums\CommentStatus;
use App\Models\Comment;
use Filament\Notifications\Notification;
use Livewire\Component;

class CommentActions extends Component
{
    protected $listeners = [
        'approveComment',
        'rejectComment',
    ];

    public function approveComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        
        $comment->update([
            'status' => CommentStatus::APPROVED,
        ]);

        Notification::make()
            ->success()
            ->title('Comment Approved')
            ->body('The comment has been approved and is now visible.')
            ->send();
    }

    public function rejectComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        
        $comment->update([
            'status' => CommentStatus::REJECTED,
        ]);

        Notification::make()
            ->success()
            ->title('Comment Rejected')
            ->body('The comment has been rejected.')
            ->send();
    }

    public function render()
    {
        return view('livewire.comment-actions');
    }
}
