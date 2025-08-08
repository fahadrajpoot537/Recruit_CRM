<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParsedCv extends Model
{
    use HasFactory;

    protected $table = 'parsed_cvs';

    protected $fillable = [
        'candidate_ref',
        'cv_folder',
        'opt_out',
        'agent',
        'date',
        'source',
        'candidate_name',
        'candidate_first_name',
        'candidate_last_name',
        'phone_number',
        'email',
        'address_line_1',
        'area',
        'city',
        'partial_post_code',
        'full_post_code',
        'nationality',
        'gender',
        'dob',
        'age',
        'right_to_work',
        'driving_licence',
        'languages_spoken',
        'summary',
        'skills',
        'experience',
        'education',
        'certifications',
        'linkedin',
        'github',
        'current_organization',
        'position_title',
        'total_experience',
        'current_salary',
        'salary_expectation',
        'notice_period_days',
        'available_from',
        'willing_to_relocate',
        'file_name',
        'file_path',
        'parsed_fields',
    ];

    protected $casts = [
        'opt_out' => 'boolean',
        'right_to_work' => 'boolean',
        'driving_licence' => 'boolean',
        'willing_to_relocate' => 'boolean',
        'date' => 'datetime',
        'dob' => 'date',
        'available_from' => 'date',
        'age' => 'integer',
        'notice_period_days' => 'integer',
        'skills' => 'array',
        'experience' => 'array',
        'education' => 'array',
        'certifications' => 'array',
        'parsed_fields' => 'array',
    ];

    /**
     * Get the full name of the candidate
     */
    public function getFullNameAttribute()
    {
        return trim($this->candidate_first_name . ' ' . $this->candidate_last_name);
    }

    /**
     * Get formatted experience years
     */
    public function getFormattedExperienceAttribute()
    {
        if ($this->total_experience) {
            return $this->total_experience;
        }
        
        // Try to calculate from experience array
        if ($this->experience && is_array($this->experience)) {
            // Logic to calculate total experience from experience entries
            // This is a basic implementation - you might want to enhance it
            return count($this->experience) . ' positions';
        }
        
        return 'Not specified';
    }

    /**
     * Get skills as a comma-separated string
     */
    public function getSkillsStringAttribute()
    {
        if ($this->skills && is_array($this->skills)) {
            return implode(', ', $this->skills);
        }
        return '';
    }

    /**
     * Check if candidate has a specific skill
     */
    public function hasSkill($skill)
    {
        if ($this->skills && is_array($this->skills)) {
            return in_array(strtolower($skill), array_map('strtolower', $this->skills));
        }
        return false;
    }

    /**
     * Get age from DOB if age is not directly available
     */
    public function getCalculatedAgeAttribute()
    {
        if ($this->age) {
            return $this->age;
        }
        
        if ($this->dob) {
            return now()->diffInYears($this->dob);
        }
        
        return null;
    }

    /**
     * Scope to filter by skills
     */
    public function scopeWithSkill($query, $skill)
    {
        return $query->whereJsonContains('skills', $skill);
    }

    /**
     * Scope to filter by experience level
     */
    public function scopeWithExperienceYears($query, $minYears, $maxYears = null)
    {
        $query->where(function($q) use ($minYears, $maxYears) {
            $q->where('total_experience', 'LIKE', '%' . $minYears . '%');
            
            if ($maxYears) {
                // Add logic for range filtering
                // This would need more sophisticated parsing of the total_experience field
            }
        });
        
        return $query;
    }

    /**
     * Scope to filter by location
     */
    public function scopeInCity($query, $city)
    {
        return $query->where('city', 'LIKE', '%' . $city . '%');
    }

    /**
     * Scope to filter by right to work
     */
    public function scopeWithRightToWork($query)
    {
        return $query->where('right_to_work', true);
    }

    /**
     * Scope to filter by driving license
     */
    public function scopeWithDrivingLicense($query)
    {
        return $query->where('driving_licence', true);
    }

    /**
     * Get formatted address
     */
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->address_line_1,
            $this->area,
            $this->city,
            $this->full_post_code
        ]);
        
        return implode(', ', $parts);
    }
}