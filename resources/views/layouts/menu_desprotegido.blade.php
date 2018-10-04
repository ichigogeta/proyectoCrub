<ul class="nav navbar-nav navbar-right">
    <!-- Menu items-->

    @foreach($items as $menu_item)
        <li><a href="{{ url($menu_item->link()) }}">{{ $menu_item->title }}</a></li>
    @endforeach

</ul>
