<?php

namespace App\Policies;

use App\Enums\TicketStatus;
use App\Models\User;
use App\Models\Ticket\Ticket;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Ticket $ticket)
    {
        if ($user->can('tickets.view.all')) {
            return true;
        }

        return $ticket->user_id === $user->id;
    }

    public function create(User $user)
    {
        return $user->can('tickets.create');
    }

    public function store(User $user)
    {
        return $this->create($user);
    }

    public function reply(User $user, Ticket $ticket)
    {
        if (! $user->can('tickets.reply') || $ticket->isClosed()) {
            return false;
        }

        if ($user->can('tickets.view.all')) {
            return true;
        }

        return $ticket->user_id === $user->id && $ticket->status !== TicketStatus::OPEN;
    }

    public function close(User $user, Ticket $ticket)
    {
        if (! $user->can('tickets.reply') || $ticket->isClosed()) {
            return false;
        }

        if ($user->can('tickets.view.all')) {
            return true;
        }

        return $ticket->user_id === $user->id;
    }
}
