@php
    // pomocné premenné
    $isTykanie = $contact->formality === 'tykanie';

    // oslovenie – ak je uložené v DB použij ho, inak zostroj
    $hello = $contact->salutation
             ?: ($isTykanie
                    ? "Ahoj {$contact->first_name}"
                    : "Vážený/á {$contact->last_name}");
@endphp
        <!DOCTYPE html>
<html><head><meta charset="utf-8"></head>
<body>
<p>{{ $hello }},</p>

<p>
    Toto je automaticky vygenerovaný e‑mail s našimi základnými informáciami.
</p>

@if($isTykanie)
    <p>Ak by si mal(a) otázky, pokojne sa ozvi.</p>
@else
    <p>Ak by ste mali otázky, prosím, neváhajte ma kontaktovať.</p>
@endif

<p>S pozdravom,<br> Tím Laravel App</p>
</body></html>
