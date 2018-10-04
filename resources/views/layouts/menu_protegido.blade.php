<ul class="nav navbar-nav navbar-right">
    <li><a href="{{route('home')}}">Inicio</a></li>
    @if(isset($items))
        @foreach($items as $menu_item)
            <li><a href="{{ url($menu_item->link()) }}">{{ $menu_item->title }}</a></li>
        @endforeach
    @endif
    <li><a href="{{route('noticias')}}">Noticias</a></li>
    <li><a href="{{route('contacto')}}">Contacto</a></li>
</ul>
