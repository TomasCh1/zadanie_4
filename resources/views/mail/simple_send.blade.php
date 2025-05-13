{{-- resources/views/mail/simple_send.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Odoslať e-mail zo šablóny
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">

            @if(session('ok'))
                <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded">
                    {{ session('ok') }}
                </div>
            @endif

            <form method="POST"
                  action="{{ route('simple-mail.store') }}"
                  enctype="multipart/form-data"
                  class="space-y-4">
                @csrf

                {{-- Výber jedného alebo viacerých kontaktov --}}
                <div>
                    <x-input-label for="contact_ids" value="Kontakty" />
                    <select id="contact_ids"
                            name="contact_ids[]"
                            multiple
                            class="block w-full">
                        @foreach($contacts as $c)
                            <option value="{{ $c->id }}"
                                    {{ in_array(
                                        $c->id,
                                        old('contact_ids', $contact_ids ?? [])
                                     ) ? 'selected' : '' }}>
                                {{ $c->first_name }} {{ $c->last_name }}
                                ({{ $c->email }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('contact_ids.*')" />
                </div>

                {{-- Výber šablóny --}}
                <div>
                    <x-input-label for="template_id" value="Šablóna" />
                    <select name="template_id"
                            id="template_id"
                            class="w-full border-gray-300 rounded">
                        <option value="">-- vyber šablónu --</option>
                        @foreach($templates as $tpl)
                            <option value="{{ $tpl->id }}"
                                    {{ old(
                                          'template_id',
                                          $selected_template_id ?? null
                                       ) == $tpl->id
                                       ? 'selected'
                                       : '' }}>
                                {{ $tpl->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('template_id')" />
                </div>

                {{-- Prílohy --}}
                <div>
                    <x-input-label for="attachments" value="Prílohy (voliteľné)" />
                    <input id="attachments"
                           type="file"
                           name="attachments[]"
                           multiple
                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip"
                           class="block w-full text-sm text-gray-900 bg-gray-50 rounded border border-gray-300 cursor-pointer"
                    >
                    <x-input-error :messages="$errors->get('attachments.*')" />
                </div>

                <div>
                    <x-primary-button>Odoslať e-mail</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new TomSelect('#contact_ids', {
                placeholder: 'Vyberte jedného alebo viac príjemcov',
                plugins: ['remove_button'],
                maxItems: null,
            });
        });
    </script>
</x-app-layout>
