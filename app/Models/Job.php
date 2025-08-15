<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //index
   protected $fillable = [
        // Basic Job Information
        'job_title',
        'no_of_openings',
        'company_id',
        'target_company_id',

        // Job Details
        'job_description',
        'location_type',
        'job_type',
        'job_category',

        // Experience Requirements
        'min_experience',
        'max_experience',

        // Salary Information
        'salary_type',
        'currency',
        'min_salary',
        'max_salary',

        // Education Requirements
        'educational_qualification',
        'educational_specialization',
        'skills',
        // Location Information
        'locality',
        'city',
        'state',
        'country',
        'postal_code',
        'full_address',

        // Team & Process
        'owner_id',
        'note_for_candidates',

        // Attachments / Application Questions
        'attachments',

        // Status & Timestamps
        'status',
        'published_at',
        'created_by',
        'primary_contact_id',
    ];
   protected $table = 'crm_jobs';
//company
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    //target company
    public function targetCompany()
    {
        return $this->belongsTo(Company::class, 'target_company_id');
    }
    //owner
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    //collaborator
    public function collaborators()
    {
        return $this->hasMany(JobCollaborator::class, 'job_id');
    }
    //created by
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    //questions
    public function questions()
    {
        return $this->hasMany(JobQuestion::class, 'job_id');
    }
    //contacts
    public function contacts()
    {
        return $this->hasMany(JobContact::class, 'job_id');
    }
    //primary contact
    public function primaryContact()
    {
        return $this->belongsTo(Contact::class, 'primary_contact_id');
    }
}
