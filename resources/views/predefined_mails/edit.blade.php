{{-- resources/views/predefined_mails/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editovať preddefinovaný e-mail
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
            @if(session('ok'))
                <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded">
                    {{ session('ok') }}
                </div>
            @endif

            @php
                // definujeme premenné pre partial
                $action = route('predefined-mails.update', $predefinedMail);
                $update = true;
            @endphp

            @include('predefined_mails.form')
        </div>
    </div>
</x-app-layout>
