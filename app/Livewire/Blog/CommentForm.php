<?php

namespace App\Livewire\Blog;

use App\Enums\CommentStatus;
use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CommentForm extends Component
{
    public int $postId;
    public ?int $parentId = null;
    public bool $showForm = false;

    #[Validate('required|min:2|max:100')]
    public string $guest_name = '';

    #[Validate('required|email|max:255')]
    public string $guest_email = '';

    #[Validate('required|min:3|max:1000')]
    public string $comment = '';

    public function mount(int $postId, ?int $parentId = null): void
    {
        $this->postId = $postId;
        $this->parentId = $parentId;
        $this->showForm = is_null($parentId); // Show main form, hide reply forms initially
    }

    public function toggleForm(): void
    {
        $this->showForm = !$this->showForm;
        if (!$this->showForm) {
            $this->reset(['guest_name', 'guest_email', 'comment']);
            $this->resetValidation();
        }
    }

    public function submitComment(): void
    {
        $this->validate();

        $comment = Comment::create([
            'post_id' => $this->postId,
            'parent_id' => $this->parentId,
            'guest_name' => $this->guest_name,
            'guest_email' => $this->guest_email,
            'comment' => $this->comment,
            'status' => CommentStatus::PENDING,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Send notification to all panel users
        $users = \App\Models\User::all();
        \Illuminate\Support\Facades\Notification::send(
            $users,
            new \App\Notifications\NewCommentNotification($comment)
        );

        session()->flash('comment_success', 'Thank you! Your comment has been submitted and is awaiting approval.');

        $this->reset(['guest_name', 'guest_email', 'comment']);
        $this->resetValidation();

        if ($this->parentId) {
            $this->showForm = false;
        }

        $this->dispatch('comment-submitted');
    }

    public function render(): View
    {
        return view('livewire.blog.comment-form');
    }
}
