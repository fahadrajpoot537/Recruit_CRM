<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobNote extends Model
{
    //
    protected $fillable = [
        'job_id',
        'note',
        'type',
        'created_by',
    ];

    //collaborators
    public function collaborators()
    {
        return $this->hasMany(JobNoteCollaborator::class, 'job_note_id');
    }
    //created by
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
