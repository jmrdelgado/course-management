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
        'title',
        'color',
        'start_at',
        'end_at'
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