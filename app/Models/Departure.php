<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Programming;

class Departure extends Model
{
    use HasFactory;

    /** @var array string */
    protected $fillable = [
        'departure_date'
    ];

    /**
     * Get all of the cursos for the Departure
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cursos(): HasMany
    {
        return $this->hasMany(Programming::class);
    }
}