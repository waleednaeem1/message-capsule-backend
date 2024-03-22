<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageCapsule extends Model
{ 
    protected $table = 'message_capsules';

    use HasFactory;

    protected $fillable = ['message', 'scheduled_opening_time', 'opened', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
