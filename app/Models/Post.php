<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'company_id',
        'description',
        'location',
        'start_range_salary',
        'end_range_salary',
        'experience',
        'due_date_applied',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
