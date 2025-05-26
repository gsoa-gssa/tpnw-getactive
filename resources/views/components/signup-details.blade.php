<div class="tpnw-getactive-signup-details mt-2 mb-4 md:mb-6 lg:mb-8">
    <p class="text-xl font-bold">{{__("signup.eventDetails")}}</p>
    <div class="grid md:grid-cols-2">
        <p>
            <span class="font-bold">{{__("signup.eventDetails.location")}}:</span>
            <span>
                {{$event->getTranslatable("location", app()->getLocale())}}
            </span>
        </p>
        <p>
            <span class="font-bold">{{__("signup.eventDetails.time")}}:</span>
            <span>
                {{$event->getTranslatable("time", app()->getLocale())}}
            </span>
        </p>
        <p>
            <span class="font-bold">{{__("signup.eventDetails.responsible")}}:</span>
            <span>
                {{$event->contact->firstname}} {{$event->contact->lastname}} ({{$event->contact->email}})
            </span>
        </p>
        <p>
            <span class="font-bold">{{__("signup.eventDetails.numberOfSignups")}}:</span>
            <span>
                {{$event->signups->where("status", "confirmed")->count()}}
            </span>
        </p>
    </div>
</div>
