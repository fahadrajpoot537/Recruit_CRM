<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    protected $fillable = [
        'name',
        'contact',
        'email',
        'postal_code',
        'address',
        'city',
        'state',
        'country',
        'contractpname',
        'company_description',
        'head_office',
        'no_of_employes',
        'no_of_offices',
        'industry',
        'facebook',
        'linkedln',
        'instagram',
        'twitter',
        'type',
    ];

    public function creators()
    {
        return $this->belongsToMany(User::class, 'company_user', 'company_id', 'created_by');
    }
    //company users
    public function company_users()
    {
        return $this->hasMany(CompanyEmployee::class, 'company_id', 'id');
    }
    //contacts
    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_companies', 'company_id', 'contact_id')
            ->withTimestamps();
    }
}
