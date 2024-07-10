<x-app-layout>

    <div class="tpnw-getactive-cta -mt-8 md:-mt-12 lg:-mt-16">
        <div class="tpnw-getactive-cta__container px-2 md:px-4">
            <div class="tpnw-getactive__container__inner max-w-[793px] mx-auto bg-white p-4 md:p-6 lg:p-8 relative">
                <p class="text-3xl font-bold">{{__("signup.lead")}}</p>
                {{-- <p class="mt-4">
                    <a href="/event/create" class="tpnw-getactive-new-event text-sm underline text-highlight">{{__("signup.new_event")}}</a>
                </p> --}}
            </div>
        </div>
    </div>
    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <livewire:event-grid :events="$events" />
    </div>

</x-app-layout>
