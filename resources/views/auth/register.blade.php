<style>
    :root {
        --primary: #664c25;
        --bg: #efe5d8;
        --bgc: #DEC493;
    }

    .active {
        font-weight: bold!important;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: var(--bgc)!important;
    }

    /* Validasi Password */
    .invalid {
        color: red;
    }
    .valid {
        color: green;
    }
</style>

<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div>
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus autocomplete="phone" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" oninput="validatePassword()" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />

            <!-- Password Protocol -->
            <div id="password-requirements" class="mt-2 text-sm text-gray-600">
                <p id="length" class="invalid">At least 8 Characters</p>
                <p id="lowercase" class="invalid">At least 1 lowercase letter</p>
                <p id="uppercase" class="invalid">At least 1 uppercase letter</p>
                <p id="number" class="invalid">At least 1 number</p>
                <p id="symbol" class="invalid">At least 1 symbol (@$!%*?&)</p>
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <button class="btn-primary ms-4 text-white focus:outline-none">
                {{ __('Register') }}
            </button>
        </div>
    </form>

    <!-- JavaScript Validasi Password -->
    <script>
        function validatePassword() {
            const password = document.getElementById('password').value;

            document.getElementById('length').classList.toggle('valid', password.length >= 8);
            document.getElementById('length').classList.toggle('invalid', password.length < 8);

            document.getElementById('lowercase').classList.toggle('valid', /[a-z]/.test(password));
            document.getElementById('lowercase').classList.toggle('invalid', !/[a-z]/.test(password));

            document.getElementById('uppercase').classList.toggle('valid', /[A-Z]/.test(password));
            document.getElementById('uppercase').classList.toggle('invalid', !/[A-Z]/.test(password));

            document.getElementById('number').classList.toggle('valid', /[0-9]/.test(password));
            document.getElementById('number').classList.toggle('invalid', !/[0-9]/.test(password));

            document.getElementById('symbol').classList.toggle('valid', /[@$!%*?&#]/.test(password));
            document.getElementById('symbol').classList.toggle('invalid', !/[@$!%*?&#]/.test(password));
        }
    </script>
</x-guest-layout>
