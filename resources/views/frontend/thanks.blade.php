<x-app-layout :header="false">
    <div class="tpnw-getactive-thanks h-screen flex justify-center items-center bg-accent">
        <div class="tpnw-getactive-thanks__container max-w-[793px] mx-auto px-4 text-center">
            <h1 class="tpnw-title text-4xl md:text-5xl lg:text-6xl !leading-[1.15]">@if (isset(request()->firstname)) {{__("thanks.titleWithFirstname", ["firstname" => request()->firstname])}} @else {{__("thanks.title")}} @endif</h1>
            <p class="text-xl mt-4">{!!__("thanks.content")!!}</p>
            <a href="/" class="tpnw-getactive-thanks__back mt-4 inline-block bg-highlight text-white font-extrabold uppercase py-2 px-4 text-xl">{{__("thanks.newSignup")}}</a>
        </div>
    </div>
</x-app-layout>
