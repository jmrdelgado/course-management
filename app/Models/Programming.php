<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

use App\Models\Action;
use App\Models\Platform;
use App\Models\Supplier;
use App\Models\Tutor;
use App\Models\Coordinator;
use App\Models\Agent;
use App\Models\GroupCompany;

class Programming extends Model
{
    use HasFactory;

    protected $fillable = [
        'naction',
        'ngroup',
        'action_id',
        'modality',
        'platform_id',
        'nhours',
        'communication_date',
        'start_date',
        'end_date',
        'number_students',
        'company_id',
        'observations',
        'tutor_id',
        'coordinator_id',
        'agent_id',
        'supplier_id',
        'course_type',
        'student_cost',
        'cost',
        'project_cost',
        'billed_month',
        'rlt',
        'rlt_send',
        'rlt_received',
        'rlt_favorable',
        'rlt_incident',
        'incident',
        'canceled' 
    ];

    /**
     * Get the action that owns the Programming
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function action(): BelongsTo
    {
        return $this->belongsTo(Action::class);
    }

    /**
     * Get the platform that owns the Programming
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }

    /**
     * Get the supplier that owns the Programming
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the tutor that owns the Programming
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }

    /**
     * Get the coordinator that owns the Programming
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coordinator(): BelongsTo
    {
        return $this->belongsTo(Coordinator::class);
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
     * Get the company that owns the Programming
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the groupcompany that owns the Programming
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function groupcompany(): BelongsTo
    {
        return $this->belongsTo(GroupCompany::class);
    }
}
