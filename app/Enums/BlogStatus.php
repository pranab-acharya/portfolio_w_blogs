<?php

namespace App\Enums;

use BackedEnum;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

enum BlogStatus: string implements HasLabel, HasIcon, HasColor
{
    case DRAFT     = 'draft';
    case PUBLISHED = 'published';
    case SCHEDULED = 'scheduled';

    public function getLabel(): string | Htmlable | null
    {
        return match ($this) {
            self::DRAFT     => 'Draft',
            self::PUBLISHED => 'Published',
            self::SCHEDULED => 'Scheduled'
        };
    }

    public function getIcon(): string|BackedEnum|null
    {
        return match ($this) {
            self::DRAFT     => Heroicon::PauseCircle,
            self::PUBLISHED => Heroicon::CheckCircle,
            self::SCHEDULED => Heroicon::Clock
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::DRAFT     => Color::Red,
            self::PUBLISHED => Color::Green,
            self::SCHEDULED => Color::Yellow
        };
    }
}
