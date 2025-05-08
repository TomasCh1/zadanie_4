<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Odoslať e-mail zo šablóny
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">

            {{-- flash správy --}}
            @if(session('ok'))
                <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded">
                    {{ session('ok') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 px-4 py-2 bg-red-100 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST"
                  action="{{ route('simple-mail.store') }}"
                  enctype="multipart/form-data"
                  class="space-y-4">
                @csrf

                {{-- Kontakt --}}
                <div>
                    <x-input-label for="contact_id" value="Kontakt" />
                    <select name="contact_id" id="contact_id"
                            class="w-full border-gray-300 rounded">
                        <option value="">-- vyber --</option>
                        @foreach($contacts as $c)
                            <option value="{{ $c->id }}"
                                    {{ old('contact_id')==$c->id?'selected':'' }}>
                                {{ $c->first_name }} {{ $c->last_name }}
                                ({{ $c->email }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('contact_id')" />
                </div>

                {{-- Šablóna --}}
                <div>
                    <x-input-label for="template_id" value="Šablóna" />
                    <select name="template_id" id="template_id"
                            class="w-full border-gray-300 rounded">
                        <option value="">-- vyber šablónu --</option>
                        @foreach($templates as $tpl)
                            <option value="{{ $tpl->id }}"
                                    {{ old('template_id')==$tpl->id?'selected':'' }}>
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

                {{-- Odošli --}}
                <div>
                    <x-primary-button>Odoslať e-mail</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
