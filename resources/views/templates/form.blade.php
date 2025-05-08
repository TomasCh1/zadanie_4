{{-- resources/views/templates/form.blade.php --}}
<x-app-layout>
    <!-- Slot pre hlavičku stránky -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $template->exists ? 'Upraviť šablónu' : 'Nová šablóna' }}
        </h2>
    </x-slot>

    <div class="max-w-lg mx-auto py-6 px-4 space-y-6">
        <form method="POST" action="{{ $action }}">
            @csrf
            @if(in_array(strtoupper($method), ['PUT','PATCH']))
                @method($method)
            @endif

            <!-- Názov šablóny -->
            <div>
                <x-input-label for="name" value="Názov šablóny" />
                <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $template->name) }}"
                        class="w-full border rounded px-2 py-1"
                >
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <!-- Predmet (subject) -->
            <div>
                <x-input-label for="subject" value="Predmet (subject)" />
                <input
                        type="text"
                        id="subject"
                        name="subject"
                        value="{{ old('subject', $template->subject) }}"
                        class="w-full border rounded px-2 py-1"
                >
                <x-input-error :messages="$errors->get('subject')" />

                <small class="text-sm text-gray-600">
                    Môže obsahovať placeholdery:
                    @{{ first_name }}, @{{ last_name }}, @{{ contact.email }} atď.
                </small>
            </div>

            <!-- HTML telo -->
            <div>
                <x-input-label for="body_html" value="HTML telo" />
                <textarea
                        id="body_html"
                        name="body_html"
                        rows="8"
                        class="w-full border rounded px-2 py-1"
                >{{ old('body_html', $template->body_html) }}</textarea>
                <x-input-error :messages="$errors->get('body_html')" />
            </div>

            <!-- Plain-text telo -->
            <div>
                <x-input-label for="body_text" value="Plain-text telo" />
                <textarea
                        id="body_text"
                        name="body_text"
                        rows="4"
                        class="w-full border rounded px-2 py-1"
                >{{ old('body_text', $template->body_text) }}</textarea>
                <x-input-error :messages="$errors->get('body_text')" />
            </div>

            <!-- Tlačidlo Uložiť/Vytvoriť -->
            <div class="pt-4">
                <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700"
                >
                    {{ $template->exists ? 'Uložiť šablónu' : 'Vytvoriť šablónu' }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
