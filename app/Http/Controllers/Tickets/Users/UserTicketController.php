<?php

namespace App\Http\Controllers\Tickets\Users;

use App\Http\Controllers\Controller;
use App\Models\Ticket\Category;
use Illuminate\Http\Request;
use App\Models\Ticket\Ticket;
use Illuminate\Support\Facades\Session;
use App\Policies\TicketPolicy;
Use App\Models\User;
class UserTicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('user_id', auth()->id())->get();

        return view('tickets.users.index',compact('tickets'));
    }

    public function create()
    {
        $this->authorize('create', Ticket::class);
        $categories = Category::all();
        return view('tickets.users.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $this->authorize('create', Ticket::class);
        $request->validate([
            'title' => 'required|min:10|max:255',
            'description' => 'required|min:10',
            'priority' => 'required|in:low,medium,high,urgent',
            'category_id' => 'required|exists:categories,id'
        ]);

        Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'category_id' => $request->category_id,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('user.tickets.index')->with('success', 'Ticket creado con éxito');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $this->authorize('view', [Ticket::class , $ticket]);
        return view('tickets.users.show', compact('ticket'));
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
        //
    }
}
