<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'company_size',
        'description',
        'languages',
        'address',
        'phone',
        'website',
        'facebook',
        'instagram',
        'twitter',
        'work_time',
        'wear_style',
        'tunjangan',
    ];

    /**
     * Get the user's user.
     */
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
