<x-app-worker-layout>
    <x-slot name="pageTitle">
        {{ __('app.about-us.about-us-title') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.about-us.about-us-title') }}
    </x-slot>
    @php
        if (auth('worker')->check()) {
            \App\Models\Tracker::hit();
        }
    @endphp

    <div class="flex flex-col">
        <p class="text-left mt-20">
            {{ __('app.about-us.text-one') }}
        </p>
        <p class="text-left mt-5">
            {{ __('app.about-us.text-two') }}
        </p>
        <p class="text-left mt-5">
            {{ __('app.about-us.text-three') }}
        </p>
        <p class="text-left mt-5">
            {{ __('app.about-us.text-four') }}
        </p>
        <p class="text-left mt-5">
            {{ __('app.about-us.text-five') }}
        </p>
        <p class="text-left mt-5">
            {{ __('app.about-us.text-six') }}
        </p>
        <p class="text-left mt-5">
            {{ __('app.about-us.text-seven') }}
        </p>
    </div>
</x-app-worker-layout>
