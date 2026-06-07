<x-layout title="Login Page">
    <main class="formPage centerPage">
        <section class="formSection authSection">
            <h1 class="sectionTitle">Login</h1>

            <form class="formContent" action="{{ route('auth.login.store') }}" method="POST">
                @csrf

                <div class="formGroup">
                    <label class="formLabel">Username</label>
                    <input class="inputField"
                           type="text"
                           name="username"
                           value="{{ old('username') }}"
                           required>
                </div>

                <div class="formGroup">
                    <label class="formLabel">Password</label>
                    <input class="inputField"
                           type="password"
                           name="password"
                           autocomplete="on"
                           required>
                </div>

                <div class="formActions">
                    <button class="primaryBtn" type="submit">Login</button>
                </div>
            </form>

            <p class="authSwitch">
                <a href="{{ route('auth.register.create') }}">Go to register</a>
            </p>
        </section>
    </main>
</x-layout>