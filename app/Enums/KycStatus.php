<?php

namespace App\Enums;

enum KycStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    // Optional: Add a helper method for UI labels
    public function label(): string
    {
        return match($this) {
            self::Pending => 'Pending',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Approved => 'success',
            self::Rejected => 'danger',
            self::Pending => 'warning',
        };
    }
}
