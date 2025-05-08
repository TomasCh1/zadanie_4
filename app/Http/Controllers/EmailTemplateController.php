<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

class EmailTemplateController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $templates = EmailTemplate::when($q, fn($qb) =>
        $qb->where('name','like',"%{$q}%")
            ->orWhere('subject','like',"%{$q}%")
        )
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('templates.index', compact('templates','q'));
    }

    public function create()
    {
        return view('templates.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|unique:email_templates,name',
            'subject'  => 'required|string',
            'body'     => 'required|string',
            'is_html'  => 'sometimes|boolean',
        ]);

        EmailTemplate::create($data + ['is_html' => $request->has('is_html')]);

        return redirect()
            ->route('templates.index')
            ->with('ok','Šablóna úspešne vytvorená.');
    }

    public function show(Request $request, EmailTemplate $template)
    {
        $mode = $request->input('mode','raw');
        $type = $request->input('type','tykanie');
        $renderedBody = null;

        if ($mode==='preview') {
            $demo = (object)[
                'first_name'=>'Jana',
                'last_name'=>'Nováková',
                'formality'=>$type,
                'salutation'=> $type==='vykani'
                    ? 'Vážená pani Nováková'
                    : 'Ahoj Jana',
            ];
            $renderedBody = Blade::render(
                $template->body,
                ['contact'=>$demo]
            );
        }

        return view('templates.show', compact(
            'template','mode','type','renderedBody'
        ));
    }
    public function edit(EmailTemplate $template)
    {
        return view('templates.edit', compact('template'));
    }

    /**
     * PUT  /templates/{template}
     * Spracuje úpravu a uloží zmeny.
     */
    public function update(Request $request, EmailTemplate $template)
    {
        $data = $request->validate([
            'name'     => 'required|string|unique:email_templates,name,'.$template->id,
            'subject'  => 'required|string',
            'body'     => 'required|string',
            'is_html'  => 'sometimes|boolean',
        ]);

        // Upravíme model
        $template->update($data + ['is_html' => $request->has('is_html')]);

        return redirect()
            ->route('templates.index')
            ->with('ok','Šablóna “'.$template->name.'” bola upravená.');
    }

    public function destroy(EmailTemplate $template)
    {
        $name = $template->name;
        $template->delete();

        return redirect()
            ->route('templates.index')
            ->with('ok', "Šablóna „{$name}“ bola zmazaná.");
    }
    public function duplicate(EmailTemplate $template)
    {
        // Vytvoríme kópiu
        $new = $template->replicate();
        // Pridáme suffix do názvu
        $new->name = $template->name . ' (copy)';
        $new->save();

        // Presmerujeme na edit, aby sa mohol užívateľ upraviť
        return redirect()
            ->route('templates.edit', $new)
            ->with('ok', 'Šablóna bola skopírovaná, môžete ju upraviť.');
    }
}
