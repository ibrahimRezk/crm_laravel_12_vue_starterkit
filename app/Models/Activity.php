<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Added for the user relationship

class Activity extends Model
{
    protected $fillable = ['type', 'description', 'due_date', 'completed', 'user_id', 'subject_type', 'subject_id'];

    protected $casts = [
        'due_date' => 'datetime',
        'completed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->morphTo();
    }
}
