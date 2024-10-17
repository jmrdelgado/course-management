<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

use App\Models\Company;

class GroupCompany extends Model
{
    use HasFactory;

    protected $table = 'groupcompanies';

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
