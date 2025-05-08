<?php

namespace App\Http\Controllers;

use App\Mail\DynamicTemplateMail;
use App\Models\Contact;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailSimpleController extends Controller
{
    public function create()
    {
        $contacts  = Contact::all();
        $templates = EmailTemplate::all();
        return view('mail.simple_send', compact('contacts','templates'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'contact_ids'   => 'required|array|min:1',
            'contact_ids.*' => 'exists:contacts,id',
            'template_id'   => 'required|exists:email_templates,id',
            'attachments.*' => 'file|max:5120|mimes:pdf,doc,docx,jpg,jpeg,png,zip',
        ]);

        // Načítame vybrané kontakty a šablónu
        $contacts = Contact::whereIn('id', $data['contact_ids'])->get();
        $template = EmailTemplate::findOrFail($data['template_id']);
        $files    = $request->file('attachments', []);

        // Pre každý kontakt pošleme samostatný e-mail
        foreach ($contacts as $contact) {
            Mail::to($contact->email)
                ->send(new DynamicTemplateMail($template, $contact, $files));
        }

        return back()->with('ok','E-maily boli úspešne odoslané vybraným kontaktom.');
    }
}
