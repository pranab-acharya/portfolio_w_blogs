<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Enums\BlogStatus;
use App\Filament\Resources\Posts\PostResource;
use App\Filament\Traits\HandlesPostStatus;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    use HandlesPostStatus;
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->handleStatusMutation($data);
    }
}
