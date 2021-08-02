@if(count($errors->all()) > 0)
    <ul class="bg-danger p-10 mt-7 text-left">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
