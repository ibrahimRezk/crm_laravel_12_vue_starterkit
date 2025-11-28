<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Deal;
use App\Models\Activity;

class Contact extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'company', 'status', 'assigned_to'];

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
