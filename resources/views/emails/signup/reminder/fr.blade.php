<!DOCTYPE html>
<html lang="fr">
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
    <p>Bonjour {{$contact->firstname}}</p>
    <p>Vous vous êtes inscrit à l'événement «{{$event->getTranslatable("name", $language)}}» qui aura lieu bientôt. <b>Merci pour cela !</b></p>
    <p>Voici quelques détails :</p>

    <p>
        <ul>
            <li><b>Contact sur place :</b> {{$event->contact->firstname}} {{$event->contact->lastname}}</li>
            <ul>
                @if ($event->contact->phone)
                    <li><b>Numéro de téléphone :</b> {{$event->contact->phone}}</li>
                @endif
                <li><b>Adresse e-mail :</b> {{$event->contact->email}}</li>
            </ul>
            <li><b>Date :</b> {{$event->date}}</li>
            <li><b>Heure :</b> {{$event->getTranslatable("time", $language)}}</li>
            <li><b>Lieu :</b> {{$event->getTranslatable("location", $language)}}</li>
        </ul>
    </p>
    @if ($event->getTranslatable("description", $language))
        <p><br></p>
        <p><b>Plus d'informations sur l'événement</b></p>
        {!!$event->getTranslatable("description", $language)!!}
    @endif
    @if ($signup->additional_information)
        <p><br></p>
        <p><b>Informations supplémentaires concernant votre inscription :</b></p>{!!$signup->additional_information!!}
    @endif

    <p><br></p>
    <p>Si vous avez des questions, n'hésitez pas à me contacter !</p>

    <p>
        <b>Cordialement</b><br>
        {{$user->name}}<br>
        {{$user->email}}<br>
    </p>
</body>
</html>
