<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobContact extends Model
{
    //
    protected $table = 'job_contacts';
    protected $fillable = ['job_id', 'contact_id'];
}
