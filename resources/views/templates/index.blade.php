<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Prehľad e-mailových šablón
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">

            {{-- 1) Vyhľadávací formulár + Vytvoriť šablónu --}}
            <div class="mb-6 flex items-center justify-between">
                <form method="GET"
                      action="{{ route('templates.index') }}"
                      class="flex-1 flex gap-2">
                    <input type="text"
                           name="q"
                           value="{{ old('q', $q) }}"
                           placeholder="Hľadať v názve alebo predmete..."
                           oninput="this.form.submit()"
                           class="flex-1 border-gray-300 rounded px-3 py-2" />

                    <button type="submit"
                            class="btn-primary">
                        Hľadať
                    </button>
                </form>

                <a href="{{ route('templates.create') }}"
                   class="btn-primary">
                    Vytvoriť šablónu
                </a>
            </div>

            {{-- 2) Tabuľka výsledkov s Alpine.js modálom pre mazanie --}}
            <table class="w-full table-auto border-collapse">
                <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2 text-left">Názov</th>
                    <th class="border px-4 py-2 text-left">Predmet</th>
                    <th class="border px-4 py-2">Akcie</th>
                </tr>
                </thead>
                <tbody>
                @forelse($templates as $tpl)
                    <tr x-data="{ showDeleteModal: false }" class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $tpl->name }}</td>
                        <td class="border px-4 py-2">{{ $tpl->subject }}</td>
                        <td class="border px-4 py-2 text-right">

                            <a href="{{ route('templates.show', $tpl) }}"
                               class="btn-primary">
                                Pozrieť
                            </a>

                            <a href="{{ route('templates.edit', $tpl) }}"
                               class="btn-primary">
                                Editovať
                            </a>

                            <form action="{{ route('templates.duplicate', $tpl) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit"
                                        class="bg-gray-500 text-white px-2 py-1 rounded text-sm hover:bg-gray-600">
                                    Kopírovať
                                </button>
                            </form>

                            <button @click="showDeleteModal = true"
                                    class="inline-block bg-red-600 text-white px-3 py-1 rounded text-sm">
                                Zmazať
                            </button>

                            {{-- Modál na potvrdenie mazania --}}
                            <div
                                    x-show="showDeleteModal"
                                    x-transition
                                    style="position:fixed; inset:0; background:rgba(0,0,0,0.5);
                                     display:flex; align-items:center; justify-content:center; z-index:50;"
                            >
                                <div class="bg-white rounded-lg overflow-hidden shadow-xl max-w-md w-full">
                                    <div class="p-6">
                                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                                            Potvrď vymazanie
                                        </h3>
                                        <p class="text-sm text-gray-700 mb-6">
                                            Skutočne chcete zmazať šablónu
                                            <strong>{{ $tpl->name }}</strong>?
                                        </p>
                                        <div class="flex justify-end gap-3">
                                            <button @click="showDeleteModal = false"
                                                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                                                Nie
                                            </button>
                                            <form x-ref="deleteForm"
                                                  action="{{ route('templates.destroy', $tpl) }}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                        @click="$refs.deleteForm.submit()"
                                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                                    Áno, zmazať
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- /Modál --}}

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="border px-4 py-2 text-center text-gray-500">
                            Žiadne šablóny nevyhovujú vyhľadávaniu.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{-- 3) Paginácia --}}
            <div class="mt-4">
                {{ $templates->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
