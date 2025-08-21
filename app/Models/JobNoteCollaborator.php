<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobNoteCollaborator extends Model
{
    //
    protected $fillable = [
        'job_note_id',
        'collaborator_id',
        'user_id',
    ];
}
