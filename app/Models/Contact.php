<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    
    protected $fillable = [
        'first_name',
        'last_name',
        'title',
        'email',
        'phone',
        'facebook_profile_url',
        'twitter_profile_url',
        'linkedin_profile_url',
        'xing_profile_url',
        'stage',
        'locality',
        'city',
        'state',
        'country',
        'postal_code',
        'full_address',
        'created_by',
    ];

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'contact_companies', 'contact_id', 'company_id')->withTimestamps();
    }
}
