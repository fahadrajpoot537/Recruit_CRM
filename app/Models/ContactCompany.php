<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactCompany extends Model
{
    //
    protected $fillable = [
        'contact_id',
        'company_id',
    ];
//contact
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }
    //company
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
