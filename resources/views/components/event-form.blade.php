<div class="tpnw-getactive-form">
    <form action="{{route("event.create")}}" method="POST">
        <h2 class="text-2xl font-bold col-span-full">{{__("event.create.title.event")}}</h2>
        <div class="tpnw-getactive-form__input--group">
            <label for="event[name]">{{__("event.create.name.label")}}</label>
            <input type="text" id="event[name]" name="event[name]" value="{{old("event[name]")}}" placeholder="{{__("event.create.name.placeholder")}}" required>
            @if ($errors->has("event[name]"))
                <span class="text-red-500">{{ $errors->first("event[name]") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group">
            <label for="event[date]">{{__("event.create.date.label")}}</label>
            <input type="date" id="event[date]" name="event[date]" value="{{old("event[date]")}}" placeholder="{{__("event.create.date.placeholder")}}" required>
            @if ($errors->has("event[date]"))
                <span class="text-red-500">{{ $errors->first("event[date]") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group">
            <label for="event[time]">{{__("event.create.time.label")}}</label>
            <input type="text" id="event[time]" name="event[time]" value="{{old("event[time]")}}" placeholder="{{__("event.create.time.placeholder")}}" required>
            @if ($errors->has("event[time]"))
                <span class="text-red-500">{{ $errors->first("event[time]") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group">
            <label for="event[location]">{{__("event.create.location.label")}}</label>
            <input type="text" id="event[location]" name="event[location]" value="{{old("event[location]")}}" placeholder="{{__("event.create.location.placeholder")}}" required>
            @if ($errors->has("event[location]"))
                <span class="text-red-500">{{ $errors->first("event[location]") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group">
            <label for="event[canton]">{{__("event.create.canton.label")}}</label>
            <select id="event[canton]" name="event[canton]" required>
                <option value="">{{__("event.create.canton.placeholder")}}</option>
                @foreach($cantons as $canton)
                    <option value="{{$canton->id}}" @if(old("event[canton]") == $canton->id) selected @endif>{{$canton->name}}</option>
                @endforeach
            </select>
            @if ($errors->has("event[canton]"))
                <span class="text-red-500">{{ $errors->first("event[canton]") }}</span>
            @endif
        </div>
    </form>
</div>
