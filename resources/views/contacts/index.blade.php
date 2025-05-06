<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Adresár osôb</h2>
    </x-slot>

    {{-- Flash správa po create / update / delete --}}
    <x-success :message="session('ok')" class="mb-4" />

    {{-- filter + tlačidlo “+ Nová osoba” --}}
    <div class="mb-6 flex items-center justify-between">
        <form method="get" class="flex gap-2">
            <x-text-input name="q" value="{{ request('q') }}" placeholder="Hľadať..." />
            <x-primary-button>Filtrovať</x-primary-button>
        </form>

        <a href="{{ route('contacts.create') }}" class="text-sm font-medium text-indigo-600">
            + Nová osoba
        </a>
    </div>

    {{-- tabuľka osôb --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
            <tr class="text-left">
                <th class="p-2">Meno</th>
                <th class="p-2">E‑mail</th>
                <th class="p-2">Formálnosť</th>
                <th class="p-2 w-px"></th>
            </tr>
            </thead>
            <tbody>
            @forelse ($contacts as $c)
                <tr class="border-b">
                    <td class="p-2">{{ $c->first_name }} {{ $c->last_name }}</td>
                    <td class="p-2">{{ $c->email }}</td>
                    <td class="p-2">{{ ucfirst($c->formality) }}</td>
                    <td class="p-2 text-right whitespace-nowrap">
                        <a href="{{ route('contacts.edit', $c) }}" class="text-indigo-600">Upraviť</a>

                        {{-- delete --}}
                        <form method="post" action="{{ route('contacts.destroy', $c) }}" class="inline">
                            @csrf @method('delete')
                            <button onclick="return confirm('Naozaj zmazať?')" class="text-red-600 ml-3">
                                Zmazať
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="p-4 text-center text-red-500">Žiadne záznamy</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $contacts->links() }}</div>
</x-app-layout>
