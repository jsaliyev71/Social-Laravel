<x-layout title="Settings">

    @include('layouts.aside')

    @php
        $settings = auth()->user()->userSettings;
    @endphp

    <main class="settingsPage">
        @include('pages.settings.partials.nav')

        <section class="settingsContent">

            <div class="settingsSection">
                <h3 class="sectionTitle">Theme</h3>

                <form method="POST" action="{{ route('settings.preferences.update') }}" class="autoSubmitForm">
                    @csrf
                    @method('PATCH')

                    <label>
                        <input type="radio" name="theme" value="light" {{ $settings->theme === 'light' ? 'checked' : '' }}> Light
                    </label>

                    <label>
                        <input type="radio" name="theme" value="dark" {{ $settings->theme === 'dark' ? 'checked' : '' }}> Dark
                    </label>

                    <button  class="optionBtn" hidden>Save</button>
                </form>
            </div>

            <div class="settingsSection">
                <h3 class="sectionTitle">Language</h3>

                <form method="POST" action="{{ route('settings.preferences.update') }}" class="autoSubmitForm">
                    @csrf
                    @method('PATCH')

                    <select name="language" class="selectField">
                        <option value="en" {{ $settings->language === 'en' ? 'selected' : '' }}>English</option>
                        <option value="az" {{ $settings->language === 'az' ? 'selected' : '' }}>Azerbaijani</option>
                        <option value="ru" {{ $settings->language === 'ru' ? 'selected' : '' }}>Russian</option>
                    </select>

                    <button class="primaryBtn" hidden>Save</button>
                </form>
            </div>
            
            <div class="settingsSection">
                <h3 class="sectionTitle">Notifications</h3>

                <form method="POST" action="{{ route('settings.preferences.update') }}" class="autoSubmitForm">
                    @csrf
                    @method('PATCH')

                    <label>
                        <input type="radio" name="is_notifications_muted" value="0" {{ (string)$settings->is_notifications_muted === '0' ? 'checked' : '' }}> Enabled
                    </label>

                    <label>
                        <input type="radio" name="is_notifications_muted" value="1" {{ (string)$settings->is_notifications_muted === '1' ? 'checked' : '' }}> Muted
                    </label>

                    <button class="primaryBtn" hidden>Save</button>
                </form>
            </div>

        </section>
    </main>
</x-layout>
