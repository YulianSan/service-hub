<?php

namespace App\Http\Controllers\Ticket;

use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\StoreRequest;
use App\Http\Requests\Ticket\UpdateRequest;
use App\Models\Attachment;
use App\Models\Project;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Ramsey\Uuid\Uuid;

class TicketController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Ticket::class);

        return Inertia::render('Ticket/Index', [
            'tickets' => Ticket::whereHas(
                'project',
                fn($q) => $q->where('company_id', request()->user()->company_id)
            )->with('project')->paginate(15),
        ]);
    }

    public function create()
    {
        $this->authorize('create', Ticket::class);

        return Inertia::render('Ticket/CreateEdit', [
            'projects' => Project::where(
                'company_id',
                request()->user()->company_id
            )->get()
        ]);
    }

    public function store(StoreRequest $request, TicketService $ticketService)
    {
        $this->authorize('create', Ticket::class);

        $ticketService->create(
            $request->validated(),
            request()->user(),
            $request->file('attachment')
        );

        return redirect()->route('tickets.index');
    }

    public function edit(Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        return Inertia::render('Ticket/CreateEdit', [
            'ticket' => $ticket,
            'projects' => Project::where(
                'company_id',
                request()->user()->company_id
            )->get()
        ]);
    }

    public function update(UpdateRequest $request, Ticket $ticket, TicketService $ticketService)
    {
        $this->authorize('update', $ticket);

        $ticketService->update(
            $ticket,
            $request->validated(),
            $request->file('attachment')
        );

        return redirect()->route('tickets.index');
    }

    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);
        $ticket->delete();

        return redirect()->route('tickets.index');
    }
}
