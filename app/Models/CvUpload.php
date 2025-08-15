<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvUpload extends Model
{
    //Fillable attributes for mass assignment
    protected $fillable = ['user_id', 'file_name', 'file_path', 'parsed_fields'];

    //Fields limits to prevent database errors
    protected $casts = [
        'parsed_fields' => 'array',
    ];

    //Define the relation with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
