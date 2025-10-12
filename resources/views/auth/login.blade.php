<x-guest-layout>
    <!-- Tabs -->
    <div x-data="{ role: '{{ old('role', 'Staff') }}' }">
        <ul class="nav nav-tabs justify-content-center mb-4 border-0">
            <li class="nav-item flex-fill text-center">
                <a href="#" class="nav-link p-2 border-0"
                    :class="role == 'Staff' ? 'fw-semibold text-secondary border-bottom-primary' : 'text-secondary'"
                    @click.prevent="role = 'Staff'">
                    STAFF
                </a>
            </li>
            <li class="nav-item flex-fill text-center">
                <a href="#" class="nav-link p-2 border-0"
                    :class="role == 'Admin' ? 'fw-semibold text-secondary border-bottom-primary' : 'text-secondary'"
                    @click.prevent="role = 'Admin'">
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

                <div class="text-danger">
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

