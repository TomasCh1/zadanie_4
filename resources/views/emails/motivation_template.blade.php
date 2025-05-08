@php
    $hello = $contact->salutation
           ?: ($contact->formality==='tykanie'
                ? "Ahoj {$contact->first_name}"
                : "Vážený/á {$contact->last_name}");

    $mainText = $contact->formality==='tykanie'
                ? "\"Úspech nepríde k tomu, kto ho čaká. Príde k tomu, kto preň vstáva o hodinu skôr.\" Nezastavuj sa a posuň sa dnes o krok ďalej."
                : "\"Úspech nepríde k tomu, kto ho čaká. Príde k tomu, kto preň vstáva o hodinu skôr.\" Nezastavujte sa a posuňte sa dnes o krok ďalej.";
@endphp

        <!DOCTYPE html>
<html><body>
<p>{{ $hello }},</p>
<p>{{ $mainText }}</p>
<p>S pozdravom,<br>Tím Laravel App</p>
</body></html>
