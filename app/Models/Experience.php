<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'freelancer_id',
        'company_name',
        'start_work',
        'end_work',
        'currently_work_here',
        'position',
        'salary',
        'job_description',
    ];

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }
}
