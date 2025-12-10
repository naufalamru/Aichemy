<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = ['history_id', 'sender', 'content'];

    public function history()
    {
        return $this->belongsTo(ChatHistory::class, 'history_id');
    }
}
