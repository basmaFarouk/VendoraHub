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
            self::Pending => 'Pending Approval',
            self::Approved => 'Kyc Approved',
            self::Rejected => 'Kyc Rejected',
        };
    }
}
