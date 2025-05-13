<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            História odoslaných mailov
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">

            <!-- Vyhľadávací formulár -->
            <form method="GET"
                  action="{{ route('sent_emails.index') }}"
                  class="mb-4 flex gap-2">
                <input type="text"
                       name="q"
                       value="{{ old('q', $q) }}"
                       placeholder="Hľadať v príjemcoch, šablóne alebo predmete..."
                       class="flex-1 border-gray-300 rounded px-3 py-2" />
                <button type="submit"
                        class="btn-primary">
                    Hľadať
                </button>
            </form>

            <table class="w-full table-auto border-collapse">
                <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Dátum</th>
                    <th class="border px-4 py-2">Príjemcovia</th>
                    <th class="border px-4 py-2">Šablóna</th>
                    <th class="border px-4 py-2">Predmet</th>
                        <th class="border px-4 py-2">Akcie</th>
                </tr>
                </thead>
                <tbody>
                @forelse($history as $sent)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 text-sm text-gray-600">
                            {{ $sent->created_at->format('Y-m-d H:i') }}
                        </td>
                        <td class="border px-4 py-2 text-sm whitespace-pre-wrap">
                            {!! nl2br(e($sent->recipients)) !!}
                        </td>
                        <td class="border px-4 py-2 text-sm">
                            {{ $sent->template->name }}
                        </td>
                        <td class="border px-4 py-2 text-sm">
                            {{ $sent->subject }}
                        </td>
                        <td class="border px-4 py-2 text-sm">
                            <div x-data="{ open: false }">
                                <a href="{{ route('simple-mail.replicate', $sent) }}"
                                   class="btn-primary">
                                    Replikovať / Znovu odoslať
                                </a>
                                <a href="{{ route('sent_emails.show', $sent) }}"
                                   class="btn-primary">
                                    Detail
                                </a>

                                <div x-show="open" class="mt-2 bg-gray-50 p-2 rounded text-xs whitespace-pre-wrap">
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
