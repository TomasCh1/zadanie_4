<?php

namespace App\Http\Controllers;

use App\Mail\SimplePredefinedMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MailSimpleController extends Controller
{
    public function create()
    {
        // 1) všetky kontakty
        $contacts = Contact::all();

        // 2) dostupné šablóny (zatiaľ file-based; neskôr môžeš čítať z DB)
        $templates = [
            'db_template'          => 'Pozdrav',
            'funny_template'       => 'Vtip',
            'motivation_template'  => 'Motivácia',
        ];

        return view('mail.simple_send', compact('contacts', 'templates'));
    }

    public function store(Request $request): RedirectResponse
    {
        // definuj si kľúče, na ktorých ťa záleží
        $fileKeys = ['db_template','funny_template','motivation_template'];

        $data = $request->validate([
            'contact_id'    => 'required|exists:contacts,id',
            // validuj len tie z fileKeys
            'template'      => ['required','string', \Illuminate\Validation\Rule::in($fileKeys)],
            'attachments'   => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,jpg,jpeg,png,zip|max:10240',
        ]);

        // zvyšok store() nech ostane rovnaký
        $contact = Contact::findOrFail($data['contact_id']);

        $paths = collect($request->file('attachments', []))
            ->map(fn($file) => $file->storeAs(
                'attachments',
                now()->format('Ymd_His_').'_'.
                Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                .'.'.$file->getClientOriginalExtension()
            ))->all();

        Mail::to($contact->email)
            ->send(new SimplePredefinedMail(
                $contact,
                $paths,
                $data['template']
            ));

        return back()->with('ok','E-mail bol úspešne odoslaný.');
    }

}