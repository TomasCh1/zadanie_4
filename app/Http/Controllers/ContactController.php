<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;


class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Contact::query();

        // filtrácia podľa „reťazca z adaného vstupu“
        if ($search = $request->input('q')) {
            $query->where(fn ($q) => $q
                ->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name',  'like', "%{$search}%")
                ->orWhere('email',      'like', "%{$search}%"));
        }

        $contacts = $query->latest()->paginate(10)->withQueryString();

        return view('contacts.index', compact('contacts', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()  { return view('contacts.create'); }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactRequest $r)
    {
        Contact::create($r->validated());
        return redirect()->route('contacts.index')->with('ok','Pridané');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact) { return view('contacts.edit', compact('contact')); }


    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRequest $r, Contact $contact)
    {
        $contact->update($r->validated());
        return back()->with('ok','Uložené');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return back()->with('ok','Zmazané');
    }
}
