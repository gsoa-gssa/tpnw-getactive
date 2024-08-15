<div class="tpnw-getactive-form">
    @if ($errors->any())
        <div class="tpnw-getactive-form__input--group col-span-full bg-red-100 px-4 py-2 my-4 border border-red-500 rounded-sm">
            <div class="text-red-500">
                {{__("signup.error")}}
            </div>
        </div>
    @endif
    <form action="{{route("signup.create")}}" method="POST">
        @csrf
        <div class="tpnw-getactive-form__input--group">
            <label for="firstname">{{__("signup.firstname")}}</label>
            <input type="text" id="firstname" name="firstname" value="{{old("firstname", request("fname"))}}" required>
            @if ($errors->has("firstname"))
                <span class="text-red-500">{{ $errors->first("firstname") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group">
            <label for="lastname">{{__("signup.lastname")}}</label>
            <input type="text" id="lastname" name="lastname" value="{{old("lastname", request("lname"))}}" required>
            @if ($errors->has("lastname"))
                <span class="text-red-500">{{ $errors->first("lastname") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group col-span-full">
            <label for="email">{{__("signup.email")}}</label>
            <input type="email" id="email" name="email" value="{{old("email", request("email"))}}" required>
            @if ($errors->has("email"))
                <span class="text-red-500">{{ $errors->first("email") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group">
            <label for="phone">{{__("signup.phone")}}</label>
            <input type="tel" id="phone" name="phone" value="{{old("phone", request("phonenumber"))}}" required>
            @if ($errors->has("phone"))
                <span class="text-red-500">{{ $errors->first("phone") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group">
            <label for="zip">{{__("signup.zip")}}</label>
            <input type="text" id="zip" name="zip" value="{{old("zip", request("zip"))}}" required>
            @if ($errors->has("zip"))
                <span class="text-red-500">{{ $errors->first("zip") }}</span>
            @endif
        </div>
        @if ($events->first()->reassign && $events->count() == 1 && $events->first()->subevents->count() > 1)
            <div class="tpnw-getactive-form__input--group col-span-full">
                <p>{{__("signup.subevent.helper")}}</p>
            </div>
            <div class="tpnw-getactive-form__input--group col-span-full">
                <label for="subevent">{{__("signup.subevent")}}</label>
                <select name="subevent" id="subevent" required>
                    <option value="">{{__("signup.subevent.placeholder")}}</option>
                    @foreach ($events->first()->subevents as $event)
                        <option value="{{$event->id}}">{{$event->getTranslatable("name", app()->getLocale())}}</option>
                    @endforeach
                </select>
                @if ($errors->has("subevent"))
                    <span class="text-red-500">{{ $errors->first("subevent") }}</span>
                @endif
            </div>
        @endif
        <div class="tpnw-getactive-form__input--group col-span-full">
            <button type="submit" class="tpnw-getactive-form__input__submit">{{__("signup.submit")}}</button>
        </div>
        <input type="hidden" name="events" value="{{$events->pluck("id")}}">
    </form>
</div>
