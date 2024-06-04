<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $primaryKey = 'roomID'; // Specify the primary key
    protected $fillable = ['name'];

    public function participants()
    {
        return $this->belongsToMany(User::class, 'chat_room_user', 'roomID', 'userID');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'roomID');
    }
}
