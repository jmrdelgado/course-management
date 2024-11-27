<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agent extends Model
{
    use HasFactory;

    /** @var array string */
    protected $fillable = [
        'name'
    ];

    /**
     * Get all of the companies for the GroupCompany
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }
}
