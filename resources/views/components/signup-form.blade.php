<div class="tpnw-getactive-form">
    <form action="{{route("signup.create")}}" method="POST">
        @csrf
        <div class="tpnw-getactive-form__input--group">
            <label for="firstname">{{__("signup.firstname")}}</label>
            <input type="text" id="firstname" name="firstname" value="{{old("firstname")}}" required>
            @if ($errors->has("firstname"))
                <span class="text-red-500">{{ $errors->first("firstname") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group">
            <label for="lastname">{{__("signup.lastname")}}</label>
            <input type="text" id="lastname" name="lastname" value="{{old("lastname")}}" required>
            @if ($errors->has("lastname"))
                <span class="text-red-500">{{ $errors->first("lastname") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group">
            <label for="email">{{__("signup.email")}}</label>
            <input type="email" id="email" name="email" value="{{old("email")}}" required>
            @if ($errors->has("email"))
                <span class="text-red-500">{{ $errors->first("email") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group">
            <label for="phone">{{__("signup.phone")}}</label>
            <input type="tel" id="phone" name="phone" value="{{old("phone")}}" required>
            @if ($errors->has("phone"))
                <span class="text-red-500">{{ $errors->first("phone") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group">
            <label for="zip">{{__("signup.zip")}}</label>
            <input type="text" id="zip" name="zip" value="{{old("zip")}}" required>
            @if ($errors->has("zip"))
                <span class="text-red-500">{{ $errors->first("zip") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group">
            <label for="canton">{{__("signup.canton")}}</label>
            <select name="canton" id="canton">
                <option disabled>{{__("cantons.select")}}</option>
                <option value="AG" @if (old("canton") == "AG") selected @endif>{{__("cantons.AG")}}</option>
                <option value="AI" @if (old("canton") == "AI") selected @endif>{{__("cantons.AI")}}</option>
                <option value="AR" @if (old("canton") == "AR") selected @endif>{{__("cantons.AR")}}</option>
                <option value="BE" @if (old("canton") == "BE") selected @endif>{{__("cantons.BE")}}</option>
                <option value="BL" @if (old("canton") == "BL") selected @endif>{{__("cantons.BL")}}</option>
                <option value="BS" @if (old("canton") == "BS") selected @endif>{{__("cantons.BS")}}</option>
                <option value="FR" @if (old("canton") == "FR") selected @endif>{{__("cantons.FR")}}</option>
                <option value="GE" @if (old("canton") == "GE") selected @endif>{{__("cantons.GE")}}</option>
                <option value="GL" @if (old("canton") == "GL") selected @endif>{{__("cantons.GL")}}</option>
                <option value="GR" @if (old("canton") == "GR") selected @endif>{{__("cantons.GR")}}</option>
                <option value="JU" @if (old("canton") == "JU") selected @endif>{{__("cantons.JU")}}</option>
                <option value="LU" @if (old("canton") == "LU") selected @endif>{{__("cantons.LU")}}</option>
                <option value="NE" @if (old("canton") == "NE") selected @endif>{{__("cantons.NE")}}</option>
                <option value="NW" @if (old("canton") == "NW") selected @endif>{{__("cantons.NW")}}</option>
                <option value="OW" @if (old("canton") == "OW") selected @endif>{{__("cantons.OW")}}</option>
                <option value="SG" @if (old("canton") == "SG") selected @endif>{{__("cantons.SG")}}</option>
                <option value="SH" @if (old("canton") == "SH") selected @endif>{{__("cantons.SH")}}</option>
                <option value="SO" @if (old("canton") == "SO") selected @endif>{{__("cantons.SO")}}</option>
                <option value="SZ" @if (old("canton") == "SZ") selected @endif>{{__("cantons.SZ")}}</option>
                <option value="TG" @if (old("canton") == "TG") selected @endif>{{__("cantons.TG")}}</option>
                <option value="TI" @if (old("canton") == "TI") selected @endif>{{__("cantons.TI")}}</option>
                <option value="UR" @if (old("canton") == "UR") selected @endif>{{__("cantons.UR")}}</option>
                <option value="VD" @if (old("canton") == "VD") selected @endif>{{__("cantons.VD")}}</option>
                <option value="VS" @if (old("canton") == "VS") selected @endif>{{__("cantons.VS")}}</option>
                <option value="ZG" @if (old("canton") == "ZG") selected @endif>{{__("cantons.ZG")}}</option>
                <option value="ZH" @if (old("canton") == "ZH") selected @endif>{{__("cantons.ZH")}}</option>
            </select>
            @if ($errors->has("canton"))
                <span class="text-red-500">{{ $errors->first("canton") }}</span>
            @endif
        </div>
        <div class="tpnw-getactive-form__input--group col-span-full">
            <button type="submit" class="tpnw-getactive-form__input__submit">{{__("signup.submit")}}</button>
        </div>
        <input type="hidden" name="events" value="{{$events->pluck("id")}}">
    </form>
</div>
