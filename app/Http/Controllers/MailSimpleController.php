<?php

namespace App\Http\Controllers;

use App\Mail\DynamicTemplateMail;
use App\Models\Contact;
use App\Models\EmailTemplate;
use App\Models\SentEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Blade;

class MailSimpleController extends Controller
{
    /**
     * Zobrazí formulár pre odoslanie jednoduchého e-mailu.
     */
    public function create()
    {
        // Načítame zoznam kontaktov a šablón
        $contacts  = Contact::all();
        $templates = EmailTemplate::all();

        // Vrátime view s formulárom
        return view('mail.simple_send', compact('contacts','templates'));
    }

    /**
     * Spracuje request, odošle e-maily a zapíše do histórie.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'contact_ids'   => 'required|array|min:1',
            'contact_ids.*' => 'exists:contacts,id',
            'template_id'   => 'required|exists:email_templates,id',
            'attachments.*' => 'file|max:5120|mimes:pdf,doc,docx,jpg,jpeg,png,zip',
        ]);

        $contacts = Contact::whereIn('id', $data['contact_ids'])->get();
        $template = EmailTemplate::findOrFail($data['template_id']);
        $files    = $request->file('attachments', []);

        // Zoznam emailov pre DB
        $emails = $contacts->pluck('email')->toArray();

        // Pošleme každému personalizovaný e-mail
        foreach ($contacts as $contact) {
            $bodyHtml = Blade::render(
                $template->body,
                ['contact' => $contact]
            );

            Mail::to($contact->email)
                ->send(new DynamicTemplateMail($template, $contact, $files));
        }

        // Uložíme JEDEN záznam so všetkými príjemcami
        SentEmail::create([
            // 'contact_id'  => null, // už nepotrebuješ
            'template_id' => $template->id,
            'recipients'  => implode(', ', $emails),
            'subject'     => $template->subject,
            'body'        => Blade::render($template->body, ['contact' => $contacts->first()]),
        ]);

        return back()->with('ok','E-maily boli úspešne odoslané a zaznamenané v histórii.');
    }

    public function replicate(SentEmail $sentEmail)
    {
        // všetky kontakty pre drop-down
        $contacts  = Contact::all();
        $templates = EmailTemplate::all();

        // z uloženého stringu príjemcov rozdelíme e-maily
        $recipientEmails = explode(', ', $sentEmail->recipients);

        // hľadáme ich ID
        $contact_ids = Contact::whereIn('email', $recipientEmails)
            ->pluck('id')
            ->toArray();

        // id šablóny
        $selected_template_id = $sentEmail->template_id;

        // presmerujeme na rovnaký view ako create, len s preprefill
        return view('mail.simple_send', compact(
            'contacts',
            'templates',
            'contact_ids',
            'selected_template_id'
        ));
    }
}
