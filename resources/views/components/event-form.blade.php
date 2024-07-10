<div class="tpnw-getactive-form">
    <form action="{{route("event.create")}}" method="POST">
        @csrf
        <h2 class="text-2xl font-bold col-span-full">{{__("event.create.title.event")}}</h2>
        <div class="tpnw-getactive-form__input--group col-span-full">
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
        <div class="tpnw-getactive-form__input--group col-span-full">
            <label for="event[location]">{{__("event.create.location.label")}}</label>
            <input type="text" id="event[location]" name="event[location]" value="{{old("event[location]")}}" placeholder="{{__("event.create.location.placeholder")}}" required>
            @if ($errors->has("event[location]"))
                <span class="text-red-500">{{ $errors->first("event[location]") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group">
            <label for="event[canton]">{{__("event.create.canton.label")}}</label>
            <select id="event[canton]" name="event[canton]" required>
                <option>{{__("event.create.canton.placeholder")}}</option>
                @foreach($cantons as $canton)
                    <option value="{{$canton->code}}" @if(old("event[canton]") == $canton->id) selected @endif>{{$canton->getName(app()->getLocale())}}</option>
                @endforeach
            </select>
            @if ($errors->has("event[canton]"))
                <span class="text-red-500">{{ $errors->first("event[canton]") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group">
            <label for="event[type]">{{__("event.create.type.label")}}</label>
            <select id="event[type]" name="event[type]" required>
                <option value="signatureCollection" @if(old("event[type]") == "signatureCollection") selected @endif>{{__("event.create.type.signatureCollection")}}</option>
                <option value="certification" @if(old("event[type]") == "certification") selected @endif>{{__("event.create.type.certification")}}</option>
            </select>
            @if ($errors->has("event[type]"))
                <span class="text-red-500">{{ $errors->first("event[type]") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group col-span-full">
            <label for="event[description]">{{__("event.create.description.label")}}</label>
            <textarea type="text" id="event[description]" name="event[description]" placeholder="{{__("event.create.description.placeholder")}}" required>{{old("event[description]")}}</textarea>
            @if ($errors->has("event[description]"))
                <span class="text-red-500">{{ $errors->first("event[description]") }}</span>
            @endif
        </div>
        <h2 class="text-2xl mt-4 mb-0 font-bold col-span-full">{{__("event.create.title.contact")}}</h2>
        <h3 class="text-lg -mt-4 col-span-full">{{__("event.create.subtitle.contact")}}</h3>
        <div class="tpnw-getactive-form__input--group">
            <label for="contact[firstname]">{{__("event.create.firstname.label")}}</label>
            <input type="text" id="contact[firstname]" name="contact[firstname]" value="{{old("contact[firstname]")}}" placeholder="{{__("event.create.firstname.placeholder")}}" required>
            @if ($errors->has("contact[firstname]"))
                <span class="text-red-500">{{ $errors->first("contact[firstname]") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group">
            <label for="contact[lastname]">{{__("event.create.lastname.label")}}</label>
            <input type="text" id="contact[lastname]" name="contact[lastname]" value="{{old("contact[lastname]")}}" placeholder="{{__("event.create.lastname.placeholder")}}" required>
            @if ($errors->has("contact[lastname]"))
                <span class="text-red-500">{{ $errors->first("contact[lastname]") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group col-span-full">
            <label for="contact[email]">{{__("event.create.email.label")}}</label>
            <input type="email" id="contact[email]" name="contact[email]" value="{{old("contact[email]")}}" placeholder="{{__("event.create.email.placeholder")}}" required>
            @if ($errors->has("contact[email]"))
                <span class="text-red-500">{{ $errors->first("contact[email]") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group">
            <label for="contact[phone]">{{__("event.create.phone.label")}}</label>
            <input type="text" id="contact[phone]" name="contact[phone]" value="{{old("contact[phone]")}}" placeholder="{{__("event.create.phone.placeholder")}}" required>
            @if ($errors->has("contact[phone]"))
                <span class="text-red-500">{{ $errors->first("contact[phone]") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group">
            <label for="contact[zip]">{{__("event.create.zip.label")}}</label>
            <input type="text" id="contact[zip]" name="contact[zip]" value="{{old("contact[zip]")}}" placeholder="{{__("event.create.zip.placeholder")}}" required>
            @if ($errors->has("contact[zip]"))
                <span class="text-red-500">{{ $errors->first("contact[zip]") }}</span>
            @endif
        </div>
        <input type="hidden" name="locale" value="{{app()->getLocale()}}">
        <div class="tpnw-getactive-form__input--group col-span-full">
            <button type="submit" class="tpnw-getactive-form__input__submit">{{__("event.create.submit")}}</button>
        </div>
    </form>
</div>
