@if (session()->has('flash_notification'))
    <?php $flash = session('flash_notification'); ?>
    <div class="alert alert-{{ $flash['level'] }} alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {!! $flash['message'] !!}
    </div>
    <?php session()->forget('flash_notification'); ?>
@endif