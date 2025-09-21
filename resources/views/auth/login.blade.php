{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <ul class="nav nav-pills nav-fill mb-3" x-data="{ active: 'staff' }">
            <li class="nav-item">
                <a href="#" :class="active === 'staff' ? 'nav-link active' : 'nav-link'" 
                @click.prevent="active = 'staff'">
                Staff
                </a>
            </li>
            <li class="nav-item">
                <a href="#" 
                :class="active === 'admin' ? 'nav-link active' : 'nav-link'" 
                @click.prevent="active = 'admin'">
                Admin
                </a>
            </li>
        </ul>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 p-0" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

<x-guest-layout>
    <!-- Tabs -->
    <div x-data="{ role: '{{ old('role', 'Staff') }}' }">
        <ul class="flex border-b p-0">
            <li class="flex-1 text-center">
                <a href="#" 
                   @click.prevent="role = 'Staff'" 
                   :class="role === 'Staff' ? 'block py-2 border-b-2 border-indigo-600 font-semibold text-indigo-600' : 'block py-2 text-gray-600 hover:text-indigo-600'">
                    STAFF
                </a>
            </li>
            <li class="flex-1 text-center">
                <a href="#" 
                   @click.prevent="role = 'Admin'" 
                   :class="role === 'Admin' ? 'block py-2 border-b-2 border-indigo-600 font-semibold text-indigo-600' : 'block py-2 text-gray-600 hover:text-indigo-600'">
                    ADMIN
                </a>
            </li>
        </ul>

        <!-- Form -->
        <div>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <input type="hidden" name="role" x-model="role">
                <div class="input-group" >
                    <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-person-fill" x-show="role == 'Staff'"></i>
                        <i class="bi bi-person-fill-gear" x-show="role == 'Admin'"></i>
                    </span>
                    <input type="text" id="employee_id" name="employee_id" class="form-control" value="{{ old('employee_id') }}"
                        :placeholder="role == 'Staff' ? 'STAFF ID' : 'ADMIN ID'" required>
                </div>

                <div>
                    <x-input-error :messages="$errors->get('employee_id')" class="mt-2" style="padding: 0 !important; margin: 5px 0 !important; font-size: 12px !important" />
                </div>

                <div class="mt-4">
                    <button type="submit" class="w-100 btn btn-primary" style="font-weight: 500">
                        LOG IN
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

