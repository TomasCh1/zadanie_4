<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size:1.25rem;font-weight:600;">
            Vytvoriť novú e-mailovú šablónu
        </h2>
    </x-slot>

    <div style="max-width:600px;margin:2rem auto;padding:1.5rem;background:#fff;border-radius:0.5rem;box-shadow:0 2px 8px rgba(0,0,0,0.1);">
        @if(session('ok'))
            <div style="margin-bottom:1rem;padding:0.75rem;background:#d1fae5;color:#065f46;border-radius:0.25rem;">
                {{ session('ok') }}
            </div>
        @endif

        <form method="POST" action="{{ route('templates.store') }}">
            @csrf

            <div style="margin-bottom:1rem;">
                <label for="name" style="display:block;font-weight:600;">Názov</label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       style="width:100%;padding:0.5rem;border:1px solid #ccc;border-radius:0.25rem;"
                >
                @error('name')
                <div style="color:#b91c1c;margin-top:0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom:1rem;">
                <label for="subject" style="display:block;font-weight:600;">Predmet</label>
                <input type="text"
                       id="subject"
                       name="subject"
                       value="{{ old('subject') }}"
                       style="width:100%;padding:0.5rem;border:1px solid #ccc;border-radius:0.25rem;"
                >
                @error('subject')
                <div style="color:#b91c1c;margin-top:0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom:1rem;">
                <label for="body" style="display:block;font-weight:600;">Telo šablóny (Blade)</label>
                <textarea id="body"
                          name="body"
                          rows="6"
                          style="width:100%;padding:0.5rem;border:1px solid #ccc;border-radius:0.25rem; font-family:monospace;"
                >{{ old('body') }}</textarea>
                @error('body')
                <div style="color:#b91c1c;margin-top:0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: none">
                <label>
                    <input type="checkbox"
                           name="is_html"
                            {{ old('is_html') ? 'checked':'' }}>
                    Použiť ako HTML šablónu
                </label>
            </div>

            <div style="display:flex;gap:1rem;">
                <button type="submit"
                        style="background:#3b82f6;color:#fff;padding:0.5rem 1rem;border:none;border-radius:0.25rem;font-weight:600;cursor:pointer;">
                    Uložiť šablónu
                </button>
                <a href="{{ route('templates.index') }}"
                   style="align-self:center;color:#374151;text-decoration:underline;">
                    Zrušiť
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
