{{-- resources/views/predefined_mails/form.blade.php --}}
<form method="POST"
      action="{{ $action }}"
      enctype="multipart/form-data"
      class="space-y-4">
    @csrf
    @if($update)
        @method('PUT')
    @endif

    {{-- Názov --}}
    <div>
        <x-input-label for="name" value="Názov" />
        <x-text-input id="name"
                      name="name"
                      type="text"
                      class="block w-full"
                      value="{{ old('name', $predefinedMail->name ?? '') }}" />
        <x-input-error :messages="$errors->get('name')" />
    </div>

    {{-- Výber kontaktov --}}
    <div>
        <x-input-label for="contact_ids" value="Príjemcovia" />
        <select id="contact_ids"
                name="contact_ids[]"
                multiple
                class="block w-full">
            @foreach($contacts as $c)
                <option value="{{ $c->id }}"
                        {{ in_array(
                              $c->id,
                              old('contact_ids', $predefinedMail->contact_ids ?? [])
                           ) ? 'selected' : '' }}>
                    {{ $c->first_name }} {{ $c->last_name }}
                    ({{ $c->email }})
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('contact_ids.*')" />
    </div>

    {{-- Výber šablóny --}}
    <div>
        <x-input-label for="template_id" value="Šablóna" />
        <select id="template_id"
                name="template_id"
                class="block w-full border-gray-300 rounded">
            <option value="">-- vyber --</option>
            @foreach($templates as $t)
                <option value="{{ $t->id }}"
                        {{ old('template_id', $predefinedMail->template_id ?? '') == $t->id
                           ? 'selected'
                           : '' }}>
                    {{ $t->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('template_id')" />
    </div>

    {{-- Prílohy --}}
    <div>
        <x-input-label for="attachments" value="Prílohy" />
        <input id="attachments"
               type="file"
               name="attachments[]"
               multiple
               class="block w-full text-sm bg-gray-50 rounded border border-gray-300 cursor-pointer" />
        @if(!empty($predefinedMail->attachments))
            <div class="text-sm mt-1">
                Súbory: {{ implode(', ', $predefinedMail->attachments) }}
            </div>
        @endif
        <x-input-error :messages="$errors->get('attachments.*')" />
    </div>

    {{-- Naplánovať na --}}
    <div>
        <x-input-label for="scheduled_at" value="Naplánovať na" />
        <x-text-input id="scheduled_at"
                      name="scheduled_at"
                      type="datetime-local"
                      class="block w-full"
                      value="{{ old(
                                 'scheduled_at',
                                 optional($predefinedMail->scheduled_at)
                                     ->format('Y-m-d\TH:i')
                             ) }}" />
        <x-input-error :messages="$errors->get('scheduled_at')" />
    </div>

    <div>
        <x-primary-button>
            {{ $update ? 'Aktualizovať preddefinovaný mail' : 'Vytvoriť preddefinovaný mail' }}
        </x-primary-button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        new TomSelect('#contact_ids', {
            placeholder: 'Vyberte jedného alebo viac príjemcov',
            plugins: ['remove_button'],
            maxItems: null,
        });
    });
</script>
