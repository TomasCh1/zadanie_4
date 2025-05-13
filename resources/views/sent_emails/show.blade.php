{{-- resources/views/sent_emails/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail odoslaného e-mailu
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow space-y-4">
            <a href="{{ route('sent_emails.index') }}"
               class="inline-block text-indigo-600 hover:underline">
                ← Späť na históriu
            </a>

            <div>
                <h3 class="text-lg font-medium text-gray-900">Dátum odoslania</h3>
                <p class="mt-1 text-gray-700">{{ $sentEmail->created_at->format('Y-m-d H:i') }}</p>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900">Príjemcovia</h3>
                <p class="mt-1 text-gray-700 whitespace-pre-wrap">
                    {!! nl2br(e($sentEmail->recipients)) !!}
                </p>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900">Šablóna</h3>
                <p class="mt-1 text-gray-700">{{ $sentEmail->template->name }}</p>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900">Predmet</h3>
                <p class="mt-1 text-gray-700">{{ $sentEmail->subject }}</p>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900">Telo správy</h3>
                <div class="mt-1 p-4 bg-gray-50 rounded prose max-w-none">
                    {!! $sentEmail->body !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
