@props(['contact'])

@csrf
@if($contact->exists) @method('put') @endif

<div>
    {{-- meno --}}
    <div>
        <x-input-label for="first_name" value="Meno" />
        <x-text-input id="first_name" name="first_name"
                      value="{{ old('first_name', $contact->first_name) }}"
                      required autofocus />
        <x-input-error :messages="$errors->get('first_name')" />
    </div>

    {{-- priezvisko --}}
    <div>
        <x-input-label for="last_name" value="Priezvisko" />
        <x-text-input id="last_name" name="last_name"
                      value="{{ old('last_name', $contact->last_name) }}"
                      required />
        <x-input-error :messages="$errors->get('last_name')" />
    </div>

    {{-- e‑mail --}}
    <div>
        <x-input-label for="email" value="E‑mail" />
        <x-text-input id="email" type="email" name="email"
                      value="{{ old('email', $contact->email) }}"
                      required />
        <x-input-error :messages="$errors->get('email')" />
    </div>

    {{-- formálnosť --}}
    <div>
        <x-input-label for="formality" value="Formálnosť" />
        <select id="formality" name="formality"
                class="border-gray-300 rounded w-full">
            @foreach(['vykanie'=>'Vykanie','tykanie'=>'Tykanie'] as $val=>$label)
                <option value="{{ $val }}" @selected(old('formality',$contact->formality)==$val)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('formality')" />
    </div>

    {{-- oslovenie --}}
    <div>
        <x-input-label for="salutation" value="Oslovenie" />
        <x-text-input id="salutation" name="salutation"
                      value="{{ old('salutation', $contact->salutation) }}" />
        <x-input-error :messages="$errors->get('salutation')" />
    </div>

    <x-primary-button>
        {{ $contact->exists ? 'Uložiť' : 'Pridať' }}
    </x-primary-button>
</div>
