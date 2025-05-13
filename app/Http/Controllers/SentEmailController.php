<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SentEmail;

class SentEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->input('q');

        $history = SentEmail::with('template')
            ->when($q, function($query) use ($q) {
                $query->where('recipients', 'like', "%{$q}%")
                    ->orWhere('subject', 'like', "%{$q}%")
                    ->orWhereHas('template', function($q2) use ($q) {
                        $q2->where('name', 'like', "%{$q}%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $history->appends(['q' => $q]);

        return view('sent_emails.index', compact('history', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SentEmail $sentEmail)
    {
        return view('sent_emails.show', compact('sentEmail'));
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
