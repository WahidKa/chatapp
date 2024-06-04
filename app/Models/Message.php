<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['content', 'userID', 'roomID', 'file_path'];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function chatRoom()
    {
        return $this->belongsTo(ChatRoom::class, 'roomID');
    }
}