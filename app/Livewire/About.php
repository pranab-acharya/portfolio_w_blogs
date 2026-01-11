<?php

namespace App\Livewire;

use App\Models\About as AboutModel;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class About extends Component
{
    public ?AboutModel $about;

    public function mount(): void
    {
        $this->about = AboutModel::active()->first();
    }

    public function render(): View
    {
        return view('livewire.about');
    }
}
