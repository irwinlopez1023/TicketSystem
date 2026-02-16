<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Ticket extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'description', 'status', 'priority','category_id','user_id','assignee_id'];

    public function getDescriptionShortAttribute(): string
    {
        return substr($this->description, 0, 50). ( strlen($this->description) > 50 ? "..." : null );
    }
    public function getPriorityLabelAttribute(): string
    {
        return match($this->priority) {
            'low' => 'Baja',
            'medium' => 'Media',
            'high' => 'Alta',
            'urgent' => 'Urgente',
            default => 'Desconocido'
        };
    }
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'open' => 'info',
            'in progress' => 'warning',
            'answered' => 'warning',
            'closed' => 'danger',
            default => 'secondary'
        };
    }
    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'low' => 'info',
            'medium' => 'primary',
            'high' => 'warning',
            'urgent' => 'danger',
            default => 'secondary'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status){
            'open' => 'Abierto',
            'in progress' => 'En proceso',
            'answered' => 'Respondido',
            'closed' => 'Cerrado',
            default => 'Desconocido'
        };
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(TicketReply::class, 'ticket_id');
    }
    public function lastReply()
    {
        return $this->hasOne(TicketReply::class)->latest();
    }

    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }
    public function isWaitingForSupport(User $user): bool
    {
        $lastReply = $this->lastReply;
        if (!$lastReply) {
            return false;
        }
        return $lastReply->user_id === $user->id;
    }

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id', 'id');
    }
}
