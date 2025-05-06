@props(['message'])

@if ($message)
    <div {{ $attributes->merge([
            'class' => 'rounded bg-green-100 border border-green-300 text-green-800 px-4 py-2'
        ]) }}>
        {{ $message }}
    </div>
@endif
