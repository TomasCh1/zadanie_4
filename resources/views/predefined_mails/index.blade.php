<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Preddefinované maily</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
            <a href="{{ route('predefined-mails.create') }}" class="btn-primary mb-4">Vytvoriť nový</a>
            <table class="w-full table-auto border-collapse table-new">
                <thead><tr class="bg-gray-100">
                    <th class="border px-4 py-2">Názov</th>
                    <th class="border px-4 py-2">Odoslať</th>
                    <th class="border px-4 py-2">Plán</th>
                    <th class="border px-4 py-2">Akcie</th>
                </tr></thead>
                <tbody>
                @forelse($mails as $mail)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $mail->name }}</td>
                        <td class="border px-4 py-2 text-center">
                            <form action="{{ route('predefined-mails.send', $mail) }}"
                                  method="POST"
                                  style="display:inline">
                                @csrf
                                <button type="submit"
                                        class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                    Odoslať
                                </button>
                            </form>
                        </td>
                        <td class="border px-4 py-2">{{ optional($mail->scheduled_at)->format('Y-m-d H:i') }}</td>
                        <td class="border px-4 py-2 space-x-2">
                            <a href="{{ route('predefined-mails.edit',$mail) }}" class="text-green-600">Edit</a>
                            <form action="{{ route('predefined-mails.duplicate',$mail) }}" method="POST" class="inline">
                                @csrf
                                <button class="text-blue-600">Copy</button>
                            </form>
                            <form action="{{ route('predefined-mails.destroy',$mail) }}" method="POST" class="inline" onsubmit="return confirm('Zmazať?');">
                                @csrf @method('DELETE')
                                <button class="text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-4">Žiadne preddefinované maily.</td></tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-4">{{ $mails->links() }}</div>
        </div>
    </div>
</x-app-layout>