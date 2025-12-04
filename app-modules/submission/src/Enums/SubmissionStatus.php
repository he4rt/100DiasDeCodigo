<?php

declare(strict_types=1);

namespace He4rt\Submission\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

enum SubmissionStatus: string implements HasColor, HasDescription, HasIcon, HasLabel
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function getColor(): string
    {
        return match ($this) {
            self::Pending => 'gray',
            self::Approved => 'success',
            self::Rejected => 'danger',
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::Pending => 'This submission is pending review',
            self::Approved => 'This submission has been approved',
            self::Rejected => 'This submission has been rejected',
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            self::Pending => Heroicon::OutlinedClock,
            self::Approved => Heroicon::OutlinedCheckCircle,
            self::Rejected => Heroicon::OutlinedXCircle,
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
        };
    }
}
