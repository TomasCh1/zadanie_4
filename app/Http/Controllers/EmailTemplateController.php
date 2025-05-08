<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class EmailTemplateController extends Controller
{
    public function index(Request $request)
    {
        $templates = EmailTemplate::when($request->q, fn($q) =>
        $q->where('name', 'like', '%'.$request->q.'%')
            ->orWhere('subject', 'like', '%'.$request->q.'%')
        )->paginate(10);

        return view('templates.index', compact('templates'));
    }

    public function create()
    {
        return view('templates.form');
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name'    => 'required|unique:email_templates,name',
            'subject' => 'required|string',
            'body'    => 'required|string',
            'is_html' => 'sometimes|boolean',
        ]);

        EmailTemplate::create($data);

        return redirect()->route('templates.index')
            ->with('success','Šablóna uložená.');
    }

    public function edit(EmailTemplate $template)
    {
        return view('templates.form', compact('template'));
    }

    public function update(Request $r, EmailTemplate $template)
    {
        $data = $r->validate([
            'name'    => 'required|unique:email_templates,name,'.$template->id,
            'subject' => 'required|string',
            'body'    => 'required|string',
            'is_html' => 'sometimes|boolean',
        ]);

        $template->update($data);

        return back()->with('success','Šablóna upravená.');
    }

    public function destroy(EmailTemplate $template)
    {
        $template->delete();
        return back()->with('success','Šablóna zmazaná.');
    }
}
