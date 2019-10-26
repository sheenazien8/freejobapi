<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'bio',
        'expected_salary',
        'gender',
        'birth_date',
        'nationality',
        'languages',
        'skills',
        'last_education',
        'image',
    ];

    /**
     * Get the user's user.
     */
    public function user()
    {
        return $this->morphOne(User::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }
}
