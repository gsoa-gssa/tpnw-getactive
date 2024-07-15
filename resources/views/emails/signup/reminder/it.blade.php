<!DOCTYPE html>
<html lang="it">
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
    <p>Ciao {{$contact->firstname}}</p>
    <p>Ti sei iscritto all'evento «{{$event->getTranslatable("name", $language)}}» che si terrà presto. <b>Grazie per questo!</b></p>
    <p>Ecco alcuni dettagli:</p>

    <p>
        <ul>
            <li><b>Contatto sul posto:</b> {{$event->contact->firstname}} {{$event->contact->lastname}}</li>
            <ul>
                @if ($event->contact->phone)
                    <li><b>Numero di telefono:</b> {{$event->contact->phone}}</li>
                @endif
                <li><b>Indirizzo e-mail:</b> {{$event->contact->email}}</li>
            </ul>
            <li><b>Data:</b> {{$event->date}}</li>
            <li><b>Orario:</b> {{$event->getTranslatable("time", $language)}}</li>
            <li><b>Luogo:</b> {{$event->getTranslatable("location", $language)}}</li>
        </ul>
    </p>
    @if ($signup->additional_information)
        <p><b>Informazioni aggiuntive sulla tua iscrizione:</b></p>{!!$signup->additional_information!!}
    @endif

    <p><br></p>
    <p>Se hai domande, contattami!</p>

    <p>
        <b>Saluti</b><br>
        {{$user->name}}<br>
        {{$user->email}}<br>
    </p>
</body>
</html>
