<x-app-layout>
    <x-slot name="header"><h2>Detail preddefinovaného mailu</h2></x-slot>
    <div class="py-6"><div class="max-w-3xl mx-auto bg-white p-6 rounded shadow space-y-4">
            <a href="{{ route('predefined-mails.index') }}" class="text-indigo-600 hover:underline">← Späť</a>
            <h3 class="text-lg font-semibold">{{ $predefinedMail->name }}</h3>
            <p><strong>Príjemcovia:</strong> {!! nl2br(e(implode(', ',App\Models\Contact::whereIn('id',$predefinedMail->contact_ids)->pluck('email')->toArray()))) !!}</p>
            <p><strong>Šablóna:</strong> {{ $predefinedMail->template->name }}</p>
            <p><strong>Plánované na:</strong> {{ optional($predefinedMail->scheduled_at)->format('Y-m-d H:i') }}</p>
            <div><strong>Telo šablóny:</strong>
                <div class="mt-2 p-4 bg-gray-50 rounded prose max-w-none">
                    {!! Blade::render($predefinedMail->template->body,[ 'contact'=>App\Models\Contact::find($predefinedMail->contact_ids[0]) ]) !!}
                </div>
            </div>
        </div></div>
</x-app-layout>