<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
class TicketReply extends Model
{
    protected $fillable = ['ticket_id','user_id','message'];
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isFromTicketOwner(): bool
    {
        return $this->user_id === $this->ticket->user_id;
    }




}
