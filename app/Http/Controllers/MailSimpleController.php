<?php

namespace App\Http\Controllers;

use App\Mail\DynamicTemplateMail;
use App\Models\Contact;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use App\Models\SentEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Blade;

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

        $contacts = Contact::whereIn('id', $data['contact_ids'])->get();
        $template = EmailTemplate::findOrFail($data['template_id']);
        $files    = $request->file('attachments', []);

        foreach ($contacts as $contact) {
            // 1) Vyrenderujeme HTML
            $bodyHtml = Blade::render(
                $template->body,
                ['contact' => $contact]
            );

            // 2) Odošleme mail s personalizáciou
            Mail::to($contact->email)
                ->send(new DynamicTemplateMail($template, $contact, $files));

            // 3) Uložíme do histórie (sent_emails)
            SentEmail::create([
                'contact_id'  => $contact->id,
                'template_id' => $template->id,
                'subject'     => $template->subject,
                'body'        => $bodyHtml,
            ]);
        }

        return back()->with('ok','E-maily boli úspešne odoslané a uložené do histórie.');
    }
}