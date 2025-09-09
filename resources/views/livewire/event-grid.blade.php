<div class="tpnw-getactive-eventgrid">
    <form action="{{route("signup.events", ["events" => "PLACEHOLDER"])}}" class="tpnw-getactive-eventgrid__form">
        <div class="tpnw-getactive-eventgrid__filterbar max-w-[793px] mx-auto">
            <h2 class="tpnw-title text-white text-xl md:text-2xl lg:text-4xl">{{__("signup.selectEvents")}}</h2>
        </div>
        <div class="tpnw-getactive-eventgrid__filterbar max-w-[793px] mx-auto flex gap-4 md:gap-6 lg:gap-8 mt-8">
            <div class="tpnw-getactive-eventgrid__filterbar__filter--container">
                <label for="cantonFilter">{{__("cantons.canton")}}</label>
                <select class="tpnw-getactive-eventgrid__filterbar__filter" id="cantonFilter" wire:change="changeFilter('canton', $event.target.value)">
                    <option value="all">{{__("cantons.all")}}</option>
                    @foreach($cantons as $canton)
                        <option value="{{$canton}}" @if (strtoupper(request()->get("canton")) == strtoupper($canton)) selected @endif>{{__("cantons.$canton")}}</option>
                    @endforeach
                </select>
            </div>
            <div class="tpnw-getactive-eventgrid__filterbar__filter--container">
                <label for="typeFilter">{{__("eventtypes.type")}}</label>
                <select class="tpnw-getactive-eventgrid__filterbar__filter" id="typeFilter" wire:change="changeFilter('type', $event.target.value)">
                    <option value="all">{{__("eventtypes.all")}}</option>
                    <option value="signaturecollection" @if(request()->get('eventtype') == "signaturecollection") selected @endif>{{__("eventtypes.signaturecollection")}}</option>
                    <option value="certification" @if(request()->get('eventtype') == "certification") selected @endif>{{__("eventtypes.certification")}}</option>
                </select>
            </div>
        </div>
        <div class="tpnw-getactive-eventgrid__submit max-w-[793px] mx-auto flex justify-center mt-10">
            <button type="submit" class="tpnw-getactive-eventgrid__submit__button">{{__("signup.gonext.1", ["count" => $eventCounter])}}</button>
        </div>
        <div class="tpnw-getactive-eventgrid__events max-w-[1080px] mx-auto mt-8 pb-20">
            @foreach($events as $event)
                <label for="event{{$event->id}}" class="tpnw-getactive-eventgrid__events__event bg-accent p-3">
                    <h2 class="text-2xl font-bold !leading-[1.15]">{{$event->getTranslatable("name", app()->getLocale())}}</h2>
                    <div class="tpnw-getactive-eventgrid__events__event__details">
                        <span class="tpnw-getactive-eventgrid__events__event__details__detail">{{date("d.m.Y", strtotime($event->date))}}</span>
                        <span class="tpnw-getactive-eventgrid__events__event__details__detail">{{$event->getTranslatable("time", app()->getLocale())}}</span>
                        <span class="tpnw-getactive-eventgrid__events__event__details__detail">{{__("eventtypes.$event->type")}}</span>
                        <span class="tpnw-getactive-eventgrid__events__event__details__detail">{{__("cantons.$event->canton")}}</span>
                    </div>
                    {!!
                        $event->getTranslatable("description", app()->getLocale())
                    !!}
                    <p class="text-sm"><b>{{__("label.location")}}</b> {{$event->getTranslatable("location", app()->getLocale())}}</p>
                    <p class="text-sm"><b>{{__("label.time")}}</b> {{$event->getTranslatable("time", app()->getLocale())}}</p>
                    <p class="text-sm"><b>{{__("label.contact")}}</b> {{$event->contact->firstname}} {{$event->contact->lastname}}</p>
                    <p class="text-sm"><b>{{__("label.numberOfSignups")}}</b> {{$event->signups()->where("status", "confirmed")->count()}}</p>
                    @if(!$event->definitive)
                        <p class="text-xs">{{ __("label.not_definitive") }}</p>
                    @endif
                    <div class="tpnw-getactive-eventgrid__events__event__selectionboxes mt-4">
                        <input
                            type="checkbox"
                            name="events[]"
                            value="{{$event->id}}"
                            id="event{{$event->id}}"
                            class="tpnw-getactive-eventgrid__events__event__selectionboxes__checkbox"
                            wire:change="changeCounter($event.target.checked)"
                            wire:model="selectedEvents"
                            wire:load="changeCounter($event.target.checked)"
                            @if (in_array($event->id, $selectedEvents))
                                checked
                            @endif
                        >
                        <div class="tpnw-getactive-eventgrid__events__event__selectionboxes__selectionbox tpnw-getactive-eventgrid__events__event__selectionboxes__selectionbox--select">{{__("label.select")}}</div>
                        <div class="tpnw-getactive-eventgrid__events__event__selectionboxes__selectionbox tpnw-getactive-eventgrid__events__event__selectionboxes__selectionbox--selected hidden">{{__("label.selected")}}</div>
                    </div>
                </label>
            @endforeach
        </div>
    </form>
</div>
