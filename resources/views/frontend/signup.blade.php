<x-app-layout>

    <div class="tpnw-getactive-cta -mt-8 md:-mt-12 lg:-mt-16">
        <div class="tpnw-getactive-cta__container px-2 md:px-4">
            <div class="tpnw-getactive__container__inner max-w-[793px] mx-auto bg-white p-4 md:p-6 lg:p-8 relative">
                @if ($events->count() == 1)
                    <p class="text-3xl font-bold">{{__("signup.lead2WithEventname", ["eventname" => $events->first()->getTranslatable("name", app()->getLocale())])}}</p>
                @else
                    <p class="text-3xl font-bold">{{__("signup.lead2")}}</p>
                @endif
                <x-signup-form :events="$events"/>
            </div>
        </div>
    </div>

</x-app-layout>
