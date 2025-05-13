<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 mb-0">Adresár osôb</h2>
    </x-slot>

    {{-- Flash správa po create / update / delete --}}
    <x-success :message="session('ok')" class="mb-4" />

    {{-- filter + tlačidlo “+ Nová osoba” --}}
    <div style="margin: 1rem">
        <form method="get" class="d-flex gap-2">
            <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Hľadať..."
                    class="form-control"
            >
            <button type="submit" class="btn btn-primary">
                Filtrovať
            </button>
        </form>
        <div class="add-btn-container">
            <a href="{{ route('contacts.create') }}" class="add-btn">
                + Nová osoba
            </a>
        </div>
    </div>

    {{-- tabuľka osôb --}}
    <div class="center">
        <table class="table">
            <thead>
            <tr>
                <th class="py-2 px-3">Meno</th>
                <th class="py-2 px-3">E‑mail</th>
                <th class="py-2 px-3">Formálnosť</th>
                <th class="py-2 px-3"></th>
            </tr>
            </thead>
            <tbody>
            @forelse ($contacts as $c)
                <tr class="border-bottom">
                    <td class="py-2 px-3">{{ $c->first_name }} {{ $c->last_name }}</td>
                    <td class="py-2 px-3">{{ $c->email }}</td>
                    <td class="py-2 px-3">{{ ucfirst($c->formality) }}</td>
                    <td class="py-2 px-3 text-end text-nowrap">
                        <a href="{{ route('contacts.edit', $c) }}" class="text-primary">Upraviť</a>

                        {{-- delete --}}
                        <form method="post" action="{{ route('contacts.destroy', $c) }}" class="d-inline">
                            @csrf @method('delete')
                            <button
                                    onclick="return confirm('Naozaj zmazať?')"
                                    class="btn btn-link p-0 ms-3 text-danger">
                                Zmazať
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="py-4 text-center text-danger">
                        Žiadne záznamy
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $contacts->links() }}
    </div>
</x-app-layout>
