<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Pridať osobu</h2>
    </x-slot>

    <form method="post" action="{{ route('contacts.store') }}" class="max-w-lg">
        <x-contacts.form :contact="\App\Models\Contact::make()" />
    </form>
</x-app-layout>
