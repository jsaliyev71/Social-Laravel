<x-layout title="Register Page">
    <main class="formPage centerPage">
        <section class="formSection authSection">
            <h1 class="sectionTitle">Register</h1>

            <form class="formContent" action="{{ route('auth.register.store') }}" method="POST">
                @csrf

                <div class="formGroup">
                    <label class="formLabel" for="username">Username</label>
                    <input class="inputField" type="text" name="username" id="username" value="{{ old('username') }}" required>
                </div>

                <div class="formGroup">
                    <label class="formLabel" for="email">Email</label>
                    <input class="inputField" type="email" name="email" id="email" value="{{ old('email') }}" required>
                </div>

                <div class="formGroup">
                    <label class="formLabel" for="birth">Birth Date</label>
                    <input class="inputField" type="date" name="birth_date" id="birth" value="{{ old('birth_date') }}" required>
                </div>

                <div class="formGroup">
                    <label class="formLabel" for="password">Password</label>
                    <input class="inputField" type="password" name="password" id="password" autocomplete="on" required>
                </div>

                <div class="formGroup">
                    <label class="formLabel" for="password_confirmation">Confirm Password</label>
                    <input class="inputField" type="password" name="password_confirmation" id="password_confirmation" autocomplete="on" required>
                </div>

                <div class="formActions">
                    <button class="primaryBtn" type="submit">Register</button>
                </div>
            </form>

            <p class="authSwitch">
                Already have an account?
                <a href="{{ route('auth.login.index') }}">Login</a>
            </p>
        </section>
    </main>
</x-layout>