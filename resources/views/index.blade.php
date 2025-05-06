<x-app-layout>
    <x-slot name="header">Adresár osôb</x-slot>

    <div class="mb-4 flex items-center justify-between">
        <form method="get" class="flex gap-2">
            <x-text-input name="q" placeholder="Hľadať..." value="{{ $search }}" />
            <x-primary-button>Filtrovať</x-primary-button>
        </form>

        <a href="{{ route('contacts.create') }}" class="text-sm font-medium text-indigo-600">+ Nová osoba</a>
    </div>

    <x-success :message="session('ok')" />

    <table class="min-w-full text-sm">
        <thead class="bg-gray-100">
        <tr>
            <th>Meno</th><th>E‑mail</th><th>Formálnosť</th><th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($contacts as $c)
            <tr class="border-b">
                <td>{{ $c->first_name }} {{ $c->last_name }}</td>
                <td>{{ $c->email }}</td>
                <td>{{ ucfirst($c->formality) }}</td>
                <td class="text-right">
                    <a href="{{ route('contacts.edit', $c) }}" class="text-indigo-600">Upraviť</a>
                    <form method="post" action="{{ route('contacts.destroy', $c) }}" class="inline">
                        @csrf @method('delete')
                        <button onclick="return confirm('Naozaj?')" class="text-red-600 ml-3">Zmazať</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $contacts->links() }}</div>
</x-app-layout>
