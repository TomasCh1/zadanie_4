@php
    $hello = $contact->salutation
           ?: ($contact->formality==='tykanie'
                ? "Ahoj {$contact->first_name}"
                : "Vážený/á {$contact->last_name}");

    $mainText = $contact->formality==='tykanie'
                ? "Vieš, že programátori nikdy nezabudnú? No dobre... zabudnú, ale majú na to commit history! Maj super deň a nech ti bugy obchádzajú cestu!"
                : "Vedeli ste, že programátori nikdy nezabúdajú? No dobre... občas zabudnú, ale našťastie majú commit history. Prajeme Vám príjemný deň a nech Vás žiadne chyby neprekvapia!";
@endphp

        <!DOCTYPE html>
<html><body>
<p>{{ $hello }},</p>
<p>{{ $mainText }}</p>
<p>S pozdravom,<br>Tím Laravel App</p>
</body></html>
