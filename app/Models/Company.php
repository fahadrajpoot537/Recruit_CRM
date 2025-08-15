<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //fillable attributes for mass assignment
    protected $fillable = [
            'name', 'contact', 'email', 'postal_code', 'address', 'city', 'state', 'country',
            'contractpname', 'company_description', 'head_office', 'no_of_employes',
            'no_of_offices', 'industry', 'facebook', 'linkedln', 'instagram', 'twitter','type',
        ];

    //Define the relationship with User model
    public function creators()
    {
        return $this->belongsToMany(User::class, 'company_user', 'company_id', 'created_by');
    }


}
