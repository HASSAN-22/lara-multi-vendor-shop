@if($category->childes->count() > 0)
    <ul class="submenu dropdown-menu m-0">
        @foreach($category->childes as $item)
            <li>
                <a class="dropdown-item" href="{{route('front.category',['category'=>$item->id])}}">{{$item->title}}</a>
                <x-navbar-component :category="$item"></x-navbar-component>
            </li>
        @endforeach
    </ul>
@endif
