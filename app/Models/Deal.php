<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;
use App\Models\User;
use App\Models\Activity;

class Deal extends Model
{
    protected $fillable = ['title', 'value', 'stage', 'contact_id', 'assigned_to'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
