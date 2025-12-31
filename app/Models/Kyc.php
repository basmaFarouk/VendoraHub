<?php

namespace App\Models;

use App\Enums\KycStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kyc extends Model
{
        /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'full_name',
        'date_of_birth',
        'gender',
        'full_address',
        'document_type',
    ];

    protected $casts = [
        'status' => KycStatus::class,
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
