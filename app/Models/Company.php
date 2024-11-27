<?php

namespace App\Models;

use App\Models\Agent;
use App\Models\Programming;
use App\Models\GroupCompany;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    /**
     * @var array string
     */
    protected $fillable = [
        'company',
        'agent_id',
        'groupcompany_id'
    ];

    /**
     * Get the groupcompany that owns the Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function groupcompany(): BelongsTo
    {
        return $this->belongsTo(GroupCompany::class);
    }

        /**
     * Get the agent that owns the Programming
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * Get all of the cursos for the Company
     *
     * @return HasMany
     */
    public function cursos(): HasMany
    {
        return $this->hasMany(Programming::class);
    }
}
