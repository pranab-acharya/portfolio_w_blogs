<?php

namespace App\Livewire\Blog;

use App\Enums\BlogStatus;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public array $selectedTags = [];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingSelectedTags(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $posts = Post::query()
            ->published()
            ->with('tags')
            ->withCount(['comments as approved_comments_count' => function ($query) {
                $query->approved();
            }])
            ->when($this->search, fn($query) => $query->search($this->search))
            ->when($this->selectedTags, function ($query) {
                $query->whereHas('tags', function ($q) {
                    $q->whereIn('tags.id', $this->selectedTags);
                });
            })
            ->latest('published_at')
            ->paginate(9);

        $tags = Tag::whereHas('posts', function ($query) {
            $query->where('status', BlogStatus::PUBLISHED->value);
        })
            ->withCount(['posts as posts_count' => function ($query) {
                $query->where('status', BlogStatus::PUBLISHED->value);
            }])
            ->orderBy('name')
            ->get();

        return view('livewire.blog.index', [
            'posts' => $posts,
            'tags' => $tags,
        ]);
    }
}
