<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Zoznam šablón
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto space-y-4 px-4">
        {{-- filter --}}
        <form method="GET" action="{{ route('templates.index') }}" class="flex">
            <input name="q" value="{{ $q }}" placeholder="Hľadaj šablóny..."
                   class="border rounded-l px-3 py-1 flex-grow">
            <button type="submit" class="bg-blue-500 text-white px-4 rounded-r">Hľadať</button>
        </form>

        {{-- nové tlačidlo --}}
        <a href="{{ route('templates.create') }}"
           class="inline-block bg-green-500 text-white px-4 py-2 rounded">
            Nová šablóna
        </a>

        {{-- tabuľka --}}
        <div class="overflow-x-auto">
            <table class="w-full bg-white shadow rounded">
                <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 text-left">Názov</th>
                    <th class="p-2">Akcie</th>
                </tr>
                </thead>
                <tbody>
                @forelse($templates as $template)
                    <tr class="border-t">
                        <td class="p-2">{{ $template->name }}</td>
                        <td class="p-2 space-x-1 text-center">
                            <a href="{{ route('templates.edit',$template) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('templates.destroy',$template) }}"
                                  method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button class="text-red-600">Delete</button>
                            </form>
                            <form action="{{ route('templates.copy',$template) }}"
                                  method="POST" class="inline">
                                @csrf
                                <button class="text-gray-600">Copy</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="p-2 text-center">Žiadne šablóny</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- pagination --}}
        <div class="mt-4">
            {{ $templates->links() }}
        </div>
    </div>
</x-app-layout>
