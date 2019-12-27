@if (session('alert-danger'))
<div class="alert alert-danger">
    {{ session('alert-danger') }}
</div>
@endif
                    
@if (session('alert-success'))
<div class="alert alert-success" role="alert">
    {{ session('alert-success') }}
</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif