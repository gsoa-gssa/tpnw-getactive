<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export for {{$event->name[app()->getLocale()]}}</title>
</head>

<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    .container {
        max-width: 29.7cm;
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
        min-width: 3cm;
    }

    th {
        background-color: #afafaf;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .event-info p {
        margin: 0.25em 0;
    }

    .event-info {
        margin-bottom: 1.5em;
    }
</style>

<body>
    <div class="container">
        <h1>{{__("events.export.signups.title", ["eventname" => $event->name[app()->getLocale()]])}}</h1>
        <table>
            <thead>
                <tr>
                    <th>{{__("events.export.signups.firstname")}}</th>
                    <th>{{__("events.export.signups.lastname")}}</th>
                    <th>{{__("events.export.signups.email")}}</th>
                    <th>{{__("events.export.signups.phone")}}</th>
                    <th>{{__("events.export.signups.status")}}</th>
                    <th>{{__("events.export.signups.attendance")}}</th>
                    <th>{{__("events.export.signups.followup")}}</th>
                </tr>
            </thead>
            @foreach($event->signups as $signup)
                <tr>
                    <td>{{$signup->contact->firstname}}</td>
                    <td>{{$signup->contact->lastname}}</td>
                    <td>{{$signup->contact->email}}</td>
                    <td>{{$signup->contact->phone}}</td>
                    <td>{{$signup->status}}</td>
                    <td class="td-wide"></td>
                    <td class="td-wide"></td>
                </tr>
            @endforeach
        </table>
    </div>
</body>
</html>
