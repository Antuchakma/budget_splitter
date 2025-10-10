<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['creater_id', 'name'];

    public function creater()
    {
        return $this->belongsTo(User::class, 'creater_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'room_members', 'room_id', 'member_id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
