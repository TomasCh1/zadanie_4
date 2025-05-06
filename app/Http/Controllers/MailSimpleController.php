<?php

namespace App\Http\Controllers;

use App\Helpers\MailHelper;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class MailSimpleController extends Controller
{
    /**
     * Formulár: vyber kontakt + súbory.
     */
    public function create()
    {
        $contacts = Contact::all();
        return view('mail.simple_send', compact('contacts'));
    }

    /**
     * Odoslanie mailu.
     */
    public function store(Request $r): RedirectResponse
    {
        $validated = $r->validate([
            'contact_id'   => 'required|exists:contacts,id',
            'attachments.*'=> 'file|max:10240', // max 10 MB/ks
        ]);

        $contact = Contact::findOrFail($validated['contact_id']);

        // vykresli HTML šablónu s dátami z DB
        $html = View::make('emails.db_template', ['contact' => $contact])->render();

        // ulož nahraté prílohy do tmp a priprav cesty
        $paths = [];
        if ($r->hasFile('attachments')) {
            foreach ($r->file('attachments') as $uploaded) {
                $paths[] = $uploaded->getPathname(); // dočasná cesta
            }
        }

        $ok = MailHelper::send(
            $contact->email,
            'Preddefinovaná správa',
            $html,
            $paths,
        );

        return back()->with($ok ? 'ok' : 'error', $ok ? 'E‑mail odoslaný' : 'Chyba pri odosielaní');
    }
}
