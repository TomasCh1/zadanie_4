<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h2 style="font-size:1.25rem; font-weight:600;">
                Náhľad šablóny: {{ $template->name }}
            </h2>

            <div>
                {{-- Prepínač režimu --}}
                <a href="{{ route('templates.show', ['template'=>$template->id, 'mode'=>'raw']) }}"
                   class="btn-link"
                   style="margin-right:0.5rem;">
                    Raw Blade
                </a>

                <a href="{{ route('templates.show', ['template'=>$template->id, 'mode'=>'preview', 'type'=>'tykanie']) }}"
                   class="btn-link"
                   style="margin-right:0.5rem;">
                    Preview (tykanie)
                </a>

                <a href="{{ route('templates.show', ['template'=>$template->id, 'mode'=>'preview', 'type'=>'vykanie']) }}"
                   class="btn-link">
                    Preview (vykání)
                </a>
            </div>
            <div style="margin-top:1rem;">
                <a href="{{ route('templates.edit', $template) }}"
                   style="color:#1d4ed8;text-decoration:underline;">
                    ✎ Editovať túto šablónu
                </a>
            </div>

        </div>
    </x-slot>

    <div style="padding:1.5rem; max-width:800px; margin:0 auto; background:#fff; border-radius:0.5rem; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
        <div style="margin-bottom:1rem;">
            <strong>Predmet:</strong> {{ $template->subject }}
        </div>

        @if($mode === 'raw')
            <div>
                <h3 style="margin-bottom:0.5rem;">Raw Blade:</h3>
                <pre style="background:#f5f5f5; padding:1rem; border-radius:0.25rem; overflow:auto; font-size:0.9rem;">
{!! e($template->body) !!}
        </pre>
            </div>
        @else
            <div>
                <h3 style="margin-bottom:0.5rem;">
                    Preview ({{ $type === 'vykani' ? 'vykanie' : 'tykanie' }}):
                </h3>
                <div style="border:1px solid #e2e8f0; padding:1rem; border-radius:0.25rem;">
                    {{-- tu je skutočný HTML výstup --}}
                    {!! $renderedBody !!}
                </div>
            </div>
        @endif

        <div style="margin-top:1rem;">
            <a href="{{ route('templates.index') }}" class="btn-link">← Späť na zoznam</a>
        </div>
    </div>
</x-app-layout>
