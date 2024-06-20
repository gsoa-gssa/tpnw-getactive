<x-app-layout>
<style>
    html {
        background: white;
    }
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
        min-width: 8cm;
    }

    th {
        background-color: #afafaf;
        font-size: 12px;
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

    tr.body td {
        height: 2cm;
        vertical-align: top;
    }
</style>
    <div class="container relative">
        <x-petition-icon class="w-[200px] absolute top-2 right-2" />
        <h1 class="font-extrabold uppercase text-2xl pt-20">{{__("events.export.signups.title", ["eventname" => $event->getTranslatable("name", app()->getLocale())])}}</h1>
        <div class="grid justify-between p-4 border border-black grid-cols-2 gap-4 my-8">
            <div class="details-group flex flex-1 items-center">
                <p class="flex-1">{{__("events.export.id")}}</p>
                <div class="flex-1 p-1 bg-gray-200 text-end font-bold">{{$event->id}}</div>
            </div>
            <div class="details-group flex flex-1 items-center">
                <p class="flex-1">{{__("events.export.date")}}</p>
                <div class="flex-1 p-1 bg-gray-200 text-end font-bold">{{date("d.m.Y", strtotime($event->date))}}</div>
            </div>
            <div class="details-group flex flex-1 items-center">
                <p class="flex-1">{{__("events.export.contactinfo.name")}}</p>
                <div class="flex-1 p-1 bg-gray-200 text-end font-bold">{{$event->contactinfo["name"]}}</div>
            </div>
            <div class="details-group flex flex-1 items-center">
                <p class="flex-1">{{__("events.export.location")}}</p>
                <div class="flex-1 p-1 bg-gray-200 text-end font-bold">{{$event->getTranslatable("location", app()->getLocale())}}</div>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>{{__("events.export.signups.firstname")}}</th>
                    <th>{{__("events.export.signups.lastname")}}</th>
                    <th>{{__("events.export.signups.phone")}}</th>
                    <th>{{__("events.export.signups.email")}}</th>
                    <th>{{__("events.export.signups.attendance")}}</th>
                    <th>{{__("events.export.signups.numberOfSignatures")}}</th>
                    <th>{{__("events.export.signups.followup")}}</th>
                    <th>{{__("events.export.signups.notes")}}</th>
                </tr>
            </thead>
            @foreach($event->signups as $signup)
                <tr class="body">
                    <td>{{$signup->contact->firstname}}</td>
                    <td>{{$signup->contact->lastname}}</td>
                    <td>{{$signup->contact->phone}}</td>
                    <td>{{$signup->contact->email}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="td-wide"></td>
                </tr>
            @endforeach
        </table>
    </div>
</x-app-layout>
