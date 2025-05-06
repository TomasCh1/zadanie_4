<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Upraviť osobu</h2>
    </x-slot>

    <form method="post" action="{{ route('contacts.update', $contact) }}" class="max-w-lg">
        <x-contacts.form :contact="$contact" />
    </form>
</x-app-layout>
