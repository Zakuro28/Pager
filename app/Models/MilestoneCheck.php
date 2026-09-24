<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MilestoneCheck extends Model
{
    protected $fillable = ['milestone_key'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
