<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueryMessage extends Model
{
    protected $fillable = ['history_id', 'sender', 'content'];

    public function history()
    {
        return $this->belongsTo(QueryHistory::class, 'history_id');
    }
}

