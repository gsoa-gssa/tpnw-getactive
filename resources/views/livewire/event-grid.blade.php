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
                    <option value="AG" @if (strtoupper(request()->get("canton")) == "AG") selected @endif>{{__("cantons.AG")}}</option>
                    <option value="AI" @if (strtoupper(request()->get("canton")) == "AI") selected @endif>{{__("cantons.AI")}}</option>
                    <option value="AR" @if (strtoupper(request()->get("canton")) == "AR") selected @endif>{{__("cantons.AR")}}</option>
                    <option value="BE" @if (strtoupper(request()->get("canton")) == "BE") selected @endif>{{__("cantons.BE")}}</option>
                    <option value="BL" @if (strtoupper(request()->get("canton")) == "BL") selected @endif>{{__("cantons.BL")}}</option>
                    <option value="BS" @if (strtoupper(request()->get("canton")) == "BS") selected @endif>{{__("cantons.BS")}}</option>
                    <option value="FR" @if (strtoupper(request()->get("canton")) == "FR") selected @endif>{{__("cantons.FR")}}</option>
                    <option value="GE" @if (strtoupper(request()->get("canton")) == "GE") selected @endif>{{__("cantons.GE")}}</option>
                    <option value="GL" @if (strtoupper(request()->get("canton")) == "GL") selected @endif>{{__("cantons.GL")}}</option>
                    <option value="GR" @if (strtoupper(request()->get("canton")) == "GR") selected @endif>{{__("cantons.GR")}}</option>
                    <option value="JU" @if (strtoupper(request()->get("canton")) == "JU") selected @endif>{{__("cantons.JU")}}</option>
                    <option value="LU" @if (strtoupper(request()->get("canton")) == "LU") selected @endif>{{__("cantons.LU")}}</option>
                    <option value="NE" @if (strtoupper(request()->get("canton")) == "NE") selected @endif>{{__("cantons.NE")}}</option>
                    <option value="NW" @if (strtoupper(request()->get("canton")) == "NW") selected @endif>{{__("cantons.NW")}}</option>
                    <option value="OW" @if (strtoupper(request()->get("canton")) == "OW") selected @endif>{{__("cantons.OW")}}</option>
                    <option value="SG" @if (strtoupper(request()->get("canton")) == "SG") selected @endif>{{__("cantons.SG")}}</option>
                    <option value="SH" @if (strtoupper(request()->get("canton")) == "SH") selected @endif>{{__("cantons.SH")}}</option>
                    <option value="SO" @if (strtoupper(request()->get("canton")) == "SO") selected @endif>{{__("cantons.SO")}}</option>
                    <option value="SZ" @if (strtoupper(request()->get("canton")) == "SZ") selected @endif>{{__("cantons.SZ")}}</option>
                    <option value="TG" @if (strtoupper(request()->get("canton")) == "TG") selected @endif>{{__("cantons.TG")}}</option>
                    <option value="TI" @if (strtoupper(request()->get("canton")) == "TI") selected @endif>{{__("cantons.TI")}}</option>
                    <option value="UR" @if (strtoupper(request()->get("canton")) == "UR") selected @endif>{{__("cantons.UR")}}</option>
                    <option value="VD" @if (strtoupper(request()->get("canton")) == "VD") selected @endif>{{__("cantons.VD")}}</option>
                    <option value="VS" @if (strtoupper(request()->get("canton")) == "VS") selected @endif>{{__("cantons.VS")}}</option>
                    <option value="ZG" @if (strtoupper(request()->get("canton")) == "ZG") selected @endif>{{__("cantons.ZG")}}</option>
                    <option value="ZH" @if (strtoupper(request()->get("canton")) == "ZH") selected @endif>{{__("cantons.ZH")}}</option>
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
