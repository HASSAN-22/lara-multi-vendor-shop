@if($errors->any())
    <div class="text-center">
        <ul class="list-group">
            @foreach($errors->all() as $error)
                <li class="bg-danger text-white list-group-item">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
