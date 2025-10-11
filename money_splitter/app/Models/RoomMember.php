<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomMember extends Model
{
    use HasFactory;

    protected $table = 'room_members';
    protected $fillable = ['room_id', 'member_id'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }
}
