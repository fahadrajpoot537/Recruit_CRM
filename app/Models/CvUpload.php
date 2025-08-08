<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvUpload extends Model
{
    protected $fillable = ['user_id', 'file_name', 'file_path', 'parsed_fields'];

    protected $casts = [
        'parsed_fields' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
