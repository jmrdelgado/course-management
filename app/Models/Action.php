<?php

namespace App\Models;

use App\Models\Supplier;
use App\Models\Programming;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Action extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'naction',
        'denomination',
        'nhours',
        'supplier_id'
    ];

    /**
     * Get all of the cursos for the Action
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cursos(): HasMany
    {
        return $this->hasMany(Programming::class);
    }

     /**
     * Get the supplier that owns the Actionis
     *
     * @return BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
