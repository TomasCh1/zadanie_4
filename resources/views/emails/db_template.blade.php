@php
    $isTykanie = $contact->formality === 'tykanie';

    // oslovenie
    $hello = $contact->salutation
        ?: ($isTykanie
            ? "Ahoj {$contact->first_name}"
            : "Vážený/á {$contact->last_name}");
@endphp

        <!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body>
<p>{{ $hello . ", " . $contact->first_name . " " . $contact->last_name}},</p>

@if($isTykanie)
    <p>Len sme ti chceli popriať krásny deň a pripomenúť, že si váženou súčasťou našej komunity.</p>
    <p>Uži si ho naplno!</p>
@else
    <p>Len sme vám chceli popriať krásny deň a pripomenúť, že ste váženou súčasťou našej komunity.</p>
    <p>Užite si ho naplno!</p>
@endif


<p>S pozdravom,<br>Tím Laravel App</p>
</body>
</html>
