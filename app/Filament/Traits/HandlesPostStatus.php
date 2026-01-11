<?php

namespace App\Filament\Traits;

use App\Enums\BlogStatus;

trait HandlesPostStatus
{
    protected function handleStatusMutation(array $data): array
    {
        match ($data['status']) {
            BlogStatus::PUBLISHED => [
                $data['published_at'] = now(),
                $data['is_published'] = true,
            ],
            BlogStatus::DRAFT => [
                $data['published_at'] = null,
                $data['is_published'] = false,
            ],
            BlogStatus::SCHEDULED => [
                $data['is_published'] = false,
            ],
        };

        return $data;
    }
}
