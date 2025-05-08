<?php

namespace App\Http\Controllers;

use App\Mail\DynamicTemplateMail;
use App\Models\Contact;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailSimpleController extends Controller
{
    /** Zobrazí formulár */
    public function create()
    {
        $contacts  = Contact::all();
        $templates = EmailTemplate::all();
        return view('mail.simple_send', compact('contacts','templates'));
    }

    /** Spracuje POST a odošle e-mail aj s prílohami */
    public function store(Request $request)
    {
        $data = $request->validate([
            'contact_id'    => 'required|exists:contacts,id',
            'template_id'   => 'required|exists:email_templates,id',
            'attachments.*' => 'file|max:5120|mimes:pdf,doc,docx,jpg,jpeg,png,zip',
        ]);

        $contact  = Contact::findOrFail($data['contact_id']);
        $template = EmailTemplate::findOrFail($data['template_id']);
        $files    = $request->file('attachments', []);

        Mail::to($contact->email)
            ->send(new DynamicTemplateMail($template, $contact, $files));

        return back()->with('ok','E-mail úspešne odoslaný.');
    }
}
