{{--<div class="alert alert-danger alert-dismissable">--}}
{{--    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>--}}
{{--    Lorem ipsum dolor sit amet, consectetur adipisicing elit.--}}
{{--</div>--}}
@if(session()->has('success'))
    <div id="alerttopleft" class="myadmin-alert myadmin-alert-img alert-success myadmin-alert-top-left py-20 px-30" style="display: block;">
        <a href="#" class="closed">&times;</a>
        <p class="mb-0">{{ session()->get('success') }}</p>
    </div>
@endif
