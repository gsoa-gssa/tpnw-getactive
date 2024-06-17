<x-app-layout>

    <div class="tpnw-getactive-header bg-accent">
            <div class="tpnw-getactive-header__inner px-4 pt-8 md:pt-12 lg:pt-20 pb-16 md:pb-20 lg:pb-28  w-fit mx-auto max-w-7xl sm:px-6 lg:px-8 py-6">
                <x-petition-icon class="max-w-[480px] w-full mb-2 mx-auto" />
                <h2 class="text-center text-xl md:text-2xl lg:text-3xl">{{__("visual.subtitle")}}</h2>
                <h1 class="tpnw-title text-center text-5xl md:text-6xl lg:text-7xl">{{__("visual.title")}}</h1>
            </div>
        </div>
    </div>

    <div class="tpnw-getactive-cta -mt-8 md:-mt-12 lg:-mt-16">
        <div class="tpnw-getactive-cta__container px-2 md:px-4">
            <div class="tpnw-getactive__container__inner max-w-[793px] mx-auto bg-white p-4 md:p-6 lg:p-8 relative">
                <p class="text-3xl font-bold">{{__("signup.lead")}}</p>
            </div>
        </div>
    </div>
    <div class="py-8 md:py-12 px-4 sm:px-6 lg:px-8">
        <livewire:event-grid :events="$events" />
    </div>

</x-app-layout>
