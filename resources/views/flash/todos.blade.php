@if ($errors->any() || session()->has('flash_notification'))
    <div>
        @include('flash.errors')
        @include('flash.normal')
    </div>
@endif