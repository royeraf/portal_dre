<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informacion de Perfil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Actualiza tu informacion de cuenta y direccion email.") }}
        </p>
    </header>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')


        <div class="row mg-b-25">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-control-label" for="name">Nombre: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="name" id="name" value="{{old('name', $user->name)}}" placeholder="Name">
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
            </div><!-- col-4 -->
            <div class="col-lg-8">
              <div class="form-group">
                <label class="form-control-label" for="email">Email: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="email" id="email" value="{{old('email', $user->email)}}" placeholder="Enter email address">
              </div>
            </div><!-- col-4 -->
        </div>
        <div>
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
