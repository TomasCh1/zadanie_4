<?php

namespace App\Http\Controllers;

use App\Models\PredefinedMail;
use App\Models\Contact;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Blade;
use App\Mail\DynamicTemplateMail;
use App\Models\SentEmail;

class PredefinedMailController extends Controller
{
    public function index()
    {
        $mails = PredefinedMail::orderBy('scheduled_at', 'desc')->paginate(10);
        return view('predefined_mails.index', compact('mails'));
    }

    public function create()
    {
        // Prázdna inštancia, aby form.blade videl $predefinedMail->...
        $predefinedMail = new PredefinedMail();

        // Načítame kontakty a šablóny do select polí
        $contacts  = Contact::all();
        $templates = EmailTemplate::all();

        return view('predefined_mails.create', compact(
            'predefinedMail',
            'contacts',
            'templates'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'contact_ids'    => 'required|array|min:1',
            'contact_ids.*'  => 'exists:contacts,id',
            'template_id'    => 'required|exists:email_templates,id',
            'attachments.*'  => 'file|max:5120',
            'scheduled_at'   => 'nullable|date',
        ]);

        // Ulož attachments do storage a získaj cesty
        $paths = [];
        foreach ($request->file('attachments', []) as $file) {
            $paths[] = $file->store('predefined_attachments');
        }
        $data['attachments']  = $paths;
        $data['contact_ids']  = array_map('intval', $data['contact_ids']);

        PredefinedMail::create($data);

        return redirect()->route('predefined-mails.index')
            ->with('ok', 'Preddefinovaný mail uložený.');
    }

    public function show(PredefinedMail $predefinedMail)
    {
        return view('predefined_mails.show', compact('predefinedMail'));
    }

    public function edit(PredefinedMail $predefinedMail)
    {
        $contacts  = Contact::all();
        $templates = EmailTemplate::all();

        return view('predefined_mails.edit', compact(
            'predefinedMail',
            'contacts',
            'templates'
        ));
    }

    public function update(Request $request, PredefinedMail $predefinedMail)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'contact_ids'    => 'required|array|min:1',
            'contact_ids.*'  => 'exists:contacts,id',
            'template_id'    => 'required|exists:email_templates,id',
            'attachments.*'  => 'file|max:5120',
            'scheduled_at'   => 'nullable|date',
        ]);

        $paths = $predefinedMail->attachments ?? [];
        foreach ($request->file('attachments', []) as $file) {
            $paths[] = $file->store('predefined_attachments');
        }
        $data['attachments']  = $paths;
        $data['contact_ids']  = array_map('intval', $data['contact_ids']);

        $predefinedMail->update($data);

        return back()->with('ok', 'Preddefinovaný mail aktualizovaný.');
    }

    public function destroy(PredefinedMail $predefinedMail)
    {
        $predefinedMail->delete();

        return back()->with('ok', 'Preddefinovaný mail odstránený.');
    }

    /**
     * Skopíruj mail (duplicate)
     */
    public function duplicate(PredefinedMail $predefinedMail)
    {
        $copy = $predefinedMail->replicate();
        $copy->name = $predefinedMail->name . ' (copy)';
        $copy->save();

        return redirect()->route('predefined-mails.edit', $copy)
            ->with('ok', 'Mail skopírovaný.');
    }

    /**
     * Odošli preddefinovaný mail teraz
     */
    public function send(PredefinedMail $predefinedMail)
    {
        // 1) pripravíme dáta
        $ids       = $predefinedMail->contact_ids ?: [];
        $contacts  = Contact::whereIn('id', $ids)->get();
        $template  = EmailTemplate::findOrFail($predefinedMail->template_id);
        $paths     = $predefinedMail->attachments ?: [];
        $bodies    = [];

        // 2) odošleme mail každému kontaktu
        foreach ($contacts as $contact) {
            $html = Blade::render($template->body, ['contact' => $contact]);

            Mail::to($contact->email)
                ->send(new DynamicTemplateMail($template, $contact, $paths));

            $bodies[$contact->email] = $html;
        }

        // 3) uložíme záznam do histórie
        SentEmail::create([
            'template_id' => $template->id,
            'recipients'  => implode(', ', $contacts->pluck('email')->toArray()),
            'bodies'      => $bodies,
            'subject'     => $template->subject,
            'body'        => array_values($bodies)[0],
        ]);

        // 4) odstránime pôvodný preddefinovaný mail
        $predefinedMail->delete();

        // 5) redirect na index preddefinovaných mailov (bez toho, čo sme práve vymazali)
        return redirect()
            ->route('predefined-mails.index')
            ->with('ok', 'Mail bol odoslaný, zaznamenaný v histórii a odstránený z preddefinovaných.');
    }
}
