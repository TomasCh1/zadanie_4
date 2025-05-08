<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class EmailTemplateController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $templates = EmailTemplate::when($q, fn($qb) => $qb->where('name','like',"%{$q}%"))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('templates.index', compact('templates','q'));
    }

    public function create()
    {
        return view('templates.form', [
            'template' => new EmailTemplate(),
            'action'   => route('templates.store'),
            'method'   => 'POST',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'      => 'required|unique:email_templates,name',
            'subject'   => 'required|string',
            'body_html' => 'nullable|string',
            'body_text' => 'nullable|string',
        ]);

        EmailTemplate::create($data);

        return redirect()->route('templates.index')
            ->with('ok','Šablóna vytvorená');
    }

    public function edit(EmailTemplate $template)
    {
        return view('templates.form', [
            'template' => $template,
            'action'   => route('templates.update',$template),
            'method'   => 'PUT',
        ]);
    }

    public function update(Request $request, EmailTemplate $template): RedirectResponse
    {
        $data = $request->validate([
            'name'      => "required|unique:email_templates,name,{$template->id}",
            'subject'   => 'required|string',
            'body_html' => 'nullable|string',
            'body_text' => 'nullable|string',
        ]);

        $template->update($data);

        return back()->with('ok','Šablóna uložená');
    }

    public function destroy(EmailTemplate $template): RedirectResponse
    {
        $template->delete();
        return back()->with('ok','Šablóna odstránená');
    }

    public function copy(EmailTemplate $template): RedirectResponse
    {
        $copy = $template->replicate();
        $copy->name = $template->name . ' (kopie)';
        $copy->push();

        return redirect()->route('templates.edit', $copy)
            ->with('ok','Šablóna skopírovaná, uprav názov a ulož');
    }
}
