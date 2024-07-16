<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <p>Hallo {{$contact->firstname}}</p>
    <p>Du hast dich für den Event «{{$event->getTranslatable("name", $language)}}» angemeldet, welcher bald stattfindet. <b>Danke dafür!</b></p>
    <p>Hier einige Details dazu:</p>

    <p>
        <ul>
            <li><b>Kontaktperson vor Ort:</b> {{$event->contact->firstname}} {{$event->contact->lastname}}</li>
            <ul>
                @if ($event->contact->phone)
                    <li><b>Telefonnummer:</b> {{$event->contact->phone}}</li>
                @endif
                <li><b>E-Mail Adresse:</b> {{$event->contact->email}}</li>
            </ul>
            <li><b>Datum:</b> {{$event->date->format("d.m.Y")}}@if ($event->getTranslatable("time", $language)), {{$event->getTranslatable("time", $language)}}@endif</li>
            <li><b>Ort:</b> {{$event->getTranslatable("location", $language)}}</li>
        </ul>
    </p>
    <p><br></p>
    @if ($event->getTranslatable("description", $language))
        <p><b>Weitere Infos zum Event</b></p>
        {!!$event->getTranslatable("description", $language)!!}
    @endif
    <p><br></p>
    @if ($signup->additional_information)
        <p><b>Zusätzliche Informationen zu deiner Anmeldung:</b></p>
        {!!$signup->additional_information!!}
    @endif

    <p><br></p>
    <p>Falls du irgendwelche Fragen hast, melde dich bei mir!</p>

    <p>
        <b>Liebe Grüsse</b><br>
        {{$user->name}}<br>
        {{$user->email}}<br>
    </p>
</body>
</html>


