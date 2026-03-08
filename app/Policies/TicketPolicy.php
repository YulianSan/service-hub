<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Ticket $ticket): bool
    {
        return $user->company_id === $ticket->project->company_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Ticket $ticket): bool
    {
        return $user->company_id === $ticket->project->company_id;
    }

    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->company_id === $ticket->project->company_id;
    }

    public function restore(User $user, Ticket $ticket): bool
    {
        return $user->company_id === $ticket->project->company_id;
    }

    public function forceDelete(User $user, Ticket $ticket): bool
    {
        return $user->company_id === $ticket->project->company_id;
    }
}
