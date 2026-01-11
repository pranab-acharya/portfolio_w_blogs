<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    public Post $post;

    public function mount(string $slug): void
    {
        $this->post = Post::query()
            ->published()
            ->with(['tags', 'comments' => function($query) {
                $query->approved()
                    ->whereNull('parent_id')
                    ->with(['replies' => function($q) {
                        $q->approved()->latest();
                    }])
                    ->latest();
            }])
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function render(): View
    {
        return view('livewire.blog.show');
    }
}
