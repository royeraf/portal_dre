<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Actualizar Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Asegúrese de que su cuenta esté usando una contraseña larga y aleatoria para mantenerse seguro.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')
        <div class="row mg-b-25">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-control-label" for="current_password">Actual Clave: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="password" name="current_password" id="current_password" autocomplete="current-password">
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>
            </div><!-- col-4 -->
            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label" for="password">Nueva Clave: <span class="tx-danger">*</span></label>
                <input class="form-control" type="password" name="password" id="password" autocomplete="new-password">
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label" for="password_confirmation">Nueva Clave: <span class="tx-danger">*</span></label>
                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password">
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
              </div>
            </div><!-- col-4 -->            
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
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
