<x-worker-profile-layout>
    <x-slot name="pageTitle">
        {{ __('app.profile.my-account') }}
    </x-slot>

    <x-slot name="header">
    </x-slot>

    @php
        $minFill = 4;
        $censored_email = preg_replace_callback(
            '/^(.)(.*?)([^@]?)(?=@[^@]+$)/u',
            function ($m) use ($minFill) {
                return $m[1] . str_repeat('*', max($minFill, mb_strlen($m[2], 'UTF-8'))) . ($m[3] ?: $m[1]);
            },
            Auth::user()->email,
        );
    @endphp

    {{-- <div class="flex profile-title">
        <p class="text-3xl font-bold">{{ __('app.profile.my-account') }}</p>
    </div> --}}

    <!-- Profile image -->
    <div class="flex mt-5 items-center flex-col">

        @if (auth('worker')->user()->image != null)
            <img src="{{ route('show.avatar', ['filename' => auth('worker')->user()->image]) }}" class="profile-image">
        @else
            <img src="{{ asset('img/avatar_placeholder.svg') }}" class="profile-image">
        @endif

        <div class="flex mt-2 gap-1 text-2xl font-semibold">
            <span>
                {{ Auth::user()->first_name }}
            </span>
            <span>
                {{ Auth::user()->last_name }}
            </span>
        </div>
    </div>

    <div class="flex mt-10 md:flex-row flex-col">

        <!-- Left side -->
        <div class="flex w-1/2 justify-start flex-col">

            <!-- E-mail -->
            <div class="mt-3">
                <p class="text-xl"><b>{{ __('app.profile.email') }}</b>
                    <br>
                    {{ $censored_email }}
                </p>
            </div>

            <!-- Phone number -->
            <div class="mt-4">
                <p class="text-xl"><b>{{ __('app.profile.telefon') }}</b>
                    <br>
                    {{ Auth::user()->phone }}
                </p>
            </div>
        </div>

        <!-- Right side desktop -->
        <div class="w-1/2 justify-end md:flex hidden">
            <a class="update-profile-btn" href="{{ route('worker.personal.account.settings').'#profile_change' }}">
                {{ __('app.profile.update-profile') }}
            </a>
        </div>
    </div>

     <!-- CV -->
     <div class="mt-4">
        <p class="text-xl"><b>{{ __('app.auth.o-mojstoru') }}</b>
            <br>
            {{ Auth::user()->cv }}
        </p>
    </div>

     <!-- Right side mobile -->
     <div class="md:hidden flex mt-10 mb-20 text-center">
        <a class="update-profile-btn" href="{{ route('worker.personal.account.settings').'#profile_change' }}">
            {{ __('app.profile.update-profile') }}
        </a>
    </div>

</x-worker-profile-layout>
