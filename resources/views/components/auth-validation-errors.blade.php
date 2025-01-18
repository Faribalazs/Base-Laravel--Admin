@props(['errors'])

@if ($errors->any())

    <script>
        Swal.fire({
            title: "{{__('app.errors.warning')}}",
            icon: 'warning',
            html:
                '@foreach ($errors->all() as $error) <span class="text-black">{{ $error }}</span> @endforeach <br>',
            showCloseButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: "{{__('app.errors.exit')}}"
            })
    </script>

    @if(Route::current()->getName() == "password.request")
        <script>
            Swal.fire({
                title: "{{__('app.errors.warning')}}",
                icon: 'warning',
                html:
                    '@foreach ($errors->all() as $error) <span class="text-black">{{ $error }}</span> @endforeach <br>',
                showCloseButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: "{{__('app.errors.exit')}}"
                })
        </script>
    @endif

    @if(Route::current()->getName() == "worker.password.request")
        <script>
            Swal.fire({
                title: "{{__('app.errors.warning')}}",
                icon: 'warning',
                html:
                    '@foreach ($errors->all() as $error) <span class="text-black">{{ $error }}</span> @endforeach <br>',
                showCloseButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: "{{__('app.errors.exit')}}"
                })
        </script>
    @endif

    @if(Route::current()->getName() == "login")
        <script>
            Swal.fire({
                title: "{{__('app.errors.warning')}}",
                icon: 'warning',
                html:
                    '@foreach ($errors->all() as $error) <span class="text-black">{{ $error }}</span> @endforeach <br>' + 
                    '<a class="sing-up" href="{{ route('password.request') }}">{{__("app.auth.forgot-pass")}}</a>',
                showCloseButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: "{{__('app.errors.exit')}}"
                })
        </script>
    @endif

    @if(Route::current()->getName() == "admin.session.create")
        <script>
            Swal.fire({
                title: "{{__('app.errors.warning')}}",
                icon: 'warning',
                html:
                    '@foreach ($errors->all() as $error) <span class="text-black">{{ $error }}</span> @endforeach',
                showCloseButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: "{{__('app.errors.exit')}}"
                })
        </script>
    @endif

    @if(Route::current()->getName() == "worker.session.create")
        <script>
            Swal.fire({
                title: "{{__('app.errors.warning')}}",
                icon: 'warning',
                html:
                    '@foreach ($errors->all() as $error) <span class="text-black">{{ $error }}</span> @endforeach <br>' + 
                    '<a class="sing-up" href="{{ route('worker.password.request') }}">{{__("app.auth.forgot-pass")}}</a>',
                showCloseButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: "{{__('app.errors.exit')}}"
                })
        </script>
    @endif
@endif
