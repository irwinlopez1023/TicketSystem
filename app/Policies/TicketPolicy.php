<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ticket\Ticket;
class TicketPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {

    }
    public function view(User $user, Ticket $ticket){

        if ($user->can('tickets.view.all')) {
            return true;
        }
        return $ticket->user_id === $user->id;
    }
    public function create(User $user){
        return $user->can('tickets.create');
    }
    public function store(User $user)
    {
        return $user->can('tickets.create');
    }

}
