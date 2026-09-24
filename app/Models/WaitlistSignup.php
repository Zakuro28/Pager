<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaitlistSignup extends Model
{
    public const TOPICS = ['sleep', 'feeding', 'behaviour', 'development'];

    protected $fillable = ['topics'];

    protected $casts = ['topics' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
