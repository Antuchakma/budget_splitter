<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'amount', 'reason', 'payer_id', 'shares', 'split_type'];

    protected $casts = [
        'shares' => 'array',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id');
    }

    // Many-to-many: splitters
    public function splitters()
    {
        return $this->belongsToMany(User::class, 'transaction_user', 'transaction_id', 'user_id');
    }

    public function debts()
    {
        return $this->hasMany(Debt::class);
    }
   

    /**
     * Get the share amount for a specific user
     */
    public function getShareAmount($userId)
    {
        if ($this->split_type === 'custom' && $this->shares) {
            $percentage = $this->shares[$userId] ?? 0;
            return ($this->amount * $percentage) / 100;
        }

        // Default equal split
        return $this->amount / $this->splitters->count();
    }

    /**
     * Get formatted shares for display
     */
    public function getFormattedShares()
    {
        if ($this->split_type === 'custom' && $this->shares) {
            $formatted = [];
            foreach ($this->shares as $userId => $percentage) {
                $user = User::find($userId);
                if ($user) {
                    $formatted[] = [
                        'user' => $user,
                        'percentage' => $percentage,
                        'amount' => ($this->amount * $percentage) / 100
                    ];
                }
            }
            return $formatted;
        }

        return null;
    }
}
