<?php

namespace App\Http\Controllers;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Http\Requests\Tickets\CreateTicketRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'userName' => 'nullable|string',
            'userEmail' => 'nullable|email',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:open,in_progress,closed',
            'dateStart' => 'nullable|date',
            'dateEnd' => 'nullable|date'
        ]);
        $totalTicketsWithoutFilter = Ticket::count();
        $query = Ticket::with('user');
        if($request->filled('title')){
            $query->orWhere('title', 'like', "%{$request->title}%");
        }
        if($request->filled('description')){
            $query->orWhere('description', 'like', "%{$request->description}%");
        }
        if($request->filled('priority')){
            $query->orWhere('priority', $request->priority);
        }
        if($request->filled('status')){
            $query->orWhere('status', $request->status);
        }
        if($request->filled('userName')){
            $query->orWhereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->userName}%");
            });
        }
        if($request->filled('userEmail')){
            $query->orWhereHas('user', function ($q) use ($request) {
                $q->where('email', $request->userEmail);
            });
        }

        // Date filtering
        if ($request->dateStart && !$request->dateEnd) {
            $query->orWhere(
                'updated_at',
                '>=',
                Carbon::parse($request->dateStart)->startOfDay()
            );
        } else if (!$request->dateStart && $request->dateEnd) {
            $query->orWhere(
                'updated_at',
                '<=',
                Carbon::parse($request->dateEnd)->endOfDay()
            );
        } else if($request->dateStart && $request->dateEnd){
            $query->orWhereBetween(
                'updated_at',
                [
                    Carbon::parse($request->dateStart)->startOfDay(),
                    Carbon::parse($request->dateEnd)->endOfDay(),
                ]
            );
        }

        $tickets = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return inertia('Tickets/Index', [
            'tickets' => $tickets,
            'totalWithoutFilter' => $totalTicketsWithoutFilter
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Tickets/CreateTicket');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTicketRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->id();

        Ticket::create($data);

        return redirect()->route('tickets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = Ticket::with('user', 'responses')->findOrFail($id);
        return inertia('Tickets/Show', [
            'ticket' => $ticket,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        return redirect()->route('tickets.index');
    }
}
