<x-app-layout>
    <x-slot name="header"><h2>Odoslať preddefinovaný e‑mail</h2></x-slot>

    @if(session('ok'))
        <div class="mb-4 rounded bg-green-100 text-green-800 px-4 py-2">{{ session('ok') }}</div>
    @elseif(session('error'))
        <div class="mb-4 rounded bg-red-100  text-red-800  px-4 py-2">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('simple-mail.store') }}" enctype="multipart/form-data" class="space-y-4 max-w-lg">
        @csrf

        <div>
            <x-input-label for="contact_id" value="Kontakt" />
            <select name="contact_id" id="contact_id" class="w-full border-gray-300 rounded">
                <option value="">-- vyber --</option>
                @foreach($contacts as $c)
                    <option value="{{ $c->id }}">{{ $c->first_name }} {{ $c->last_name }} ({{ $c->email }})</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('contact_id')" />
        </div>

        <div>
            <x-input-label value="Prílohy (voliteľné)" />
            <input type="file" name="attachments[]" multiple class="block w-full">
            <x-input-error :messages="$errors->get('attachments')" />
        </div>

        <x-primary-button>Odoslať e‑mail</x-primary-button>
    </form>
</x-app-layout>
