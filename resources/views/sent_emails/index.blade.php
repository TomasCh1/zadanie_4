<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            História odoslaných mailov
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
            <table class="w-full table-auto border-collapse">
                <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Dátum</th>
                    <th class="border px-4 py-2">Kontakt</th>
                    <th class="border px-4 py-2">Šablóna</th>
                    <th class="border px-4 py-2">Predmet</th>
                    <th class="border px-4 py-2">Telo e-mailu</th>
                </tr>
                </thead>
                <tbody>
                @forelse($history as $sent)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 text-sm text-gray-600">
                            {{ $sent->created_at->format('Y-m-d H:i') }}
                        </td>
                        <td class="border px-4 py-2 text-sm">
                            {{ $sent->contact->first_name }} {{ $sent->contact->last_name }}
                            ({{ $sent->contact->email }})
                        </td>
                        <td class="border px-4 py-2 text-sm">
                            {{ $sent->template->name }}
                        </td>
                        <td class="border px-4 py-2 text-sm">
                            {{ $sent->subject }}
                        </td>
                        <td class="border px-4 py-2 text-sm">
                            <button @click="show = (show==={{ $sent->id }}? null : {{ $sent->id }})"
                                    class="text-indigo-600 hover:underline">
                                Zobraziť
                            </button>
                            <div x-data="{ show: null }">
                                <div x-show="show==={{ $sent->id }}"
                                     class="mt-2 p-2 bg-gray-50 rounded text-xs whitespace-pre-wrap">
                                    {!! nl2br(e($sent->body)) !!}
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border px-4 py-2 text-center text-gray-500">
                            Žiadna história odoslaných mailov.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $history->links() }}
            </div>
        </div>
    </div>
</x-app-layout>