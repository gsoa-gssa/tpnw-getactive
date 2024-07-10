<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PRINTING VIEW</title>
</head>
<body>
<style>
    html {
        background: white;
    }
    body {
        font-family: Arial, sans-serif;
        font-size: 14px;
        margin: 0;
    }

    .container {
        max-width: 29.7cm;
        position: relative;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        page-break-inside: auto;
    }

    table, th, td {
        border: 1px solid black;
    }

    th, td {
        padding: 10px;
        text-align: left;
    }

    .td-wide {
        min-width: 8cm;
    }

    th {
        background-color: #afafaf;
        font-size: 12px;
    }

    table.signups tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .event-info p {
        margin: 0.25em 0;
    }

    .event-info {
        margin-bottom: 1.5em;
    }

    tr.body td {
        height: 1.2cm;
        vertical-align: top;
    }
</style>
    <div class="container">

        <h1 style="font-weight: bold; text-transform: uppercase; font-size: 1.5rem;">{{__("events.export.signups.title", ["eventname" => $event->getTranslatable("name", app()->getLocale())])}}</h1>
        <table style="table-layout: fixed; margin: 2rem 0">
            <tr>
                <td style="border: none;">
                    <table style="border: none; table-layout: fixed;">
                        <tr style="border: none;">
                            <td style="border: none;">{{__("events.export.date")}}</td>
                            <td style="border: none; background: rgb(229,231,235); text-align: end; font-weight: bold;">{{date("d.m.Y", strtotime($event->date))}}</td>
                        </tr>
                    </table>
                </td>
                <td style="border: none;">
                    <table style="border: none; table-layout: fixed;">
                        <tr style="border: none;">
                            <td style="border: none;">{{__("events.export.time")}}</td>
                            <td style="border: none; background: rgb(229,231,235); text-align: end; font-weight: bold;">{{$event->getTranslatable("time", app()->getLocale())}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="border: none;">
                    <table style="border: none; table-layout: fixed;">
                        <tr style="border: none;">
                            <td style="border: none;">{{__("events.export.contactinfo.name")}}</td>
                            <td style="border: none; background: rgb(229,231,235); text-align: end; font-weight: bold;">{{$event->contact->firstname}} {{$event->contact->lastname}}</td>
                        </tr>
                    </table>
                </td>
                <td style="border: none;">
                    <table style="border: none; table-layout: fixed;">
                        <tr style="border: none;">
                            <td style="border: none;">{{__("events.export.contactinfo.email")}}</td>
                            <td style="border: none; background: rgb(229,231,235); text-align: end; font-weight: bold;">{{$event->contact->email}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="border: none;">
                    <table style="border: none; table-layout: fixed;">
                        <tr style="border: none;">
                            <td style="border: none;">{{__("events.export.contactinfo.phone")}}</td>
                            <td style="border: none; background: rgb(229,231,235); text-align: end; font-weight: bold;">{{$event->contact->phone}}</td>
                        </tr>
                    </table>
                </td>
                <td style="border: none;">
                    <table style="border: none; table-layout: fixed;">
                        <tr style="border: none;">
                            <td style="border: none;">{{__("events.export.location")}}</td>
                            <td style="border: none; background: rgb(229,231,235); text-align: end; font-weight: bold;">{{$event->getTranslatable("location", app()->getLocale())}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="signups">
            <thead>
                <tr>
                    <th>{{__("events.export.signups.name")}}</th>
                    <th>{{__("events.export.signups.phone")}}</th>
                    <th>{{__("events.export.signups.attendance")}}</th>
                    <th>{{__("events.export.signups.numberOfSignatures")}}</th>
                    <th>{{__("events.export.signups.followup")}}</th>
                    <th class="td-wide">{{__("events.export.signups.notes")}}</th>
                </tr>
            </thead>
            <tr class="body">
                <td>{{$event->contact->firstname}} {{$event->contact->lastname}}</td>
                <td>{{$event->contact->phone}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td class="td-wide">{{__("events.export.signups.in_charge")}}</td>
            </tr>
            @foreach($event->signups as $signup)
                <tr class="body">
                    <td>{{$signup->contact->firstname}} {{$signup->contact->lastname}}</td>
                    <td>{{$signup->contact->phone}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="td-wide"></td>
                </tr>
            @endforeach
        </table>
    </div>
</body>
</html>
