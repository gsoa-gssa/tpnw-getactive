<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
        }

        .gjs-grid-column {
            flex: 1 1 0%;
            padding: 5px 0;
        }

        .gjs-grid-row {
            display: flex;
            justify-content: flex-start;
            align-items: stretch;
            flex-direction: row;
            min-height: auto;
            padding: 10px 0;
        }

        .gjs-grid-column {
            flex: 1 1 0%;
            padding: 5px 0;
        }

        .gjs-grid-row {
            display: flex;
            justify-content: flex-start;
            align-items: stretch;
            flex-direction: row;
            min-height: auto;
            padding: 10px 0;
        }

        .gjs-grid-column.feature-item {
            padding-top: 15px;
            padding-right: 15px;
            padding-bottom: 15px;
            padding-left: 15px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            min-width: 30%;
        }

        .gjs-grid-column.testimonial-item {
            padding-top: 15px;
            padding-right: 15px;
            padding-bottom: 15px;
            padding-left: 15px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            min-width: 45%;
            background-color: rgba(247, 247, 247, 0.23);
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            border-bottom-left-radius: 5px;
            align-items: flex-start;
            border-top-width: 1px;
            border-right-width: 1px;
            border-bottom-width: 1px;
            border-left-width: 1px;
            border-top-style: solid;
            border-right-style: solid;
            border-bottom-style: solid;
            border-left-style: solid;
            border-top-color: rgba(0, 0, 0, 0.06);
            border-right-color: rgba(0, 0, 0, 0.06);
            border-bottom-color: rgba(0, 0, 0, 0.06);
            border-left-color: rgba(0, 0, 0, 0.06);
        }

        #ipwl8z {
            padding-top: 0px;
            padding-right: 0px;
            padding-bottom: 0px;
            padding-left: 0px;
            background-color: rgba(235, 235, 235, 1);
            line-height: 140%;
        }

        #i7ia9o {
            max-width: 650px;
            margin-top: auto;
            margin-right: auto;
            margin-bottom: auto;
            margin-left: auto;
            background-color: rgba(255, 255, 255, 1);
            padding-top: 0px;
            padding-bottom: 0px;
        }

        #i26i05 {
            padding: 10px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 22px;
        }

        #ipbwk7 {
            color: black;
            width: 100%;
        }

        #iuxpfg {
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 30px;
            padding-bottom: 30px;
        }

        #iwp6he {
            padding: 10px;
            font-family: Arial, Helvetica, sans-serif;
        }

        @media (max-width:992px) {
            .gjs-grid-row {
                flex-direction: column;
            }

            .gjs-grid-row {
                flex-direction: column;
            }
        }
    </style>
</head>

<body id="ipwl8z">
    <div id="iuxpfg" class="gjs-grid-row">
        <div id="i7ia9o" class="gjs-grid-column"><img id="ipbwk7" src="{{url('images/emails/MC_Head_it.png')}}"
                alt="Logo" />
            <div id="i26i05"><b id="ijn4gj">Ciao {{$contact->firstname}}!</b></div>
            <div id="iwp6he">Ottimo, ha funzionato! Hai appena creato con successo un evento per la raccolta
                «{{$event->getTranslatable("name", $contact->language)}}» sulla nostra homepage. Grazie mille per il tuo
                impegno! 💖<br><br>
                Prima che il tuo evento di raccolta firme venga visualizzato sul sito web, dobbiamo prima attivarlo.
                Questo potrebbe richiedere un po' di tempo e ti chiediamo di avere pazienza. Esamineremo la tua proposta
                il prima possibile e, se necessario, ti contatteremo per discutere se e come possiamo supportarti. Se
                dovessimo metterci troppo per risponderti, per favore scrivimi un'email a <a
                    href="mailto:{{$user->email}}">{{$user->email}}</a>.<br><br>
                <b>Cordiali saluti e a presto,</b><br />
                {{$user->name}}<br>
                {{$user->email}}<br>
            </div>
        </div>
    </div>
</body>

</html>