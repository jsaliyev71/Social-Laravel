@if ($errors->any())
    <div class="alert_animation alert_messages alert_error">
        {{ $errors->first() }}
    </div>
@elseif (session('message'))
    <div class="alert_animation alert_messages alert_{{ session('status') }}">
        {{ session('message') }}
    </div>
@endif

<div id="jsAlertContainer"></div>