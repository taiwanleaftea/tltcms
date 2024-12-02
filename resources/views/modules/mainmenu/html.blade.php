@foreach($menu as $item)
  @if(empty($item['submenu']))
    <li class="nav-item">
      <a
        @class(['nav-link', 'active' => $item['active'],'ps-0' => $loop->first]) href="{{ $item['link'] }}">{!! $item['name'] !!}</a>
    </li>
  @else
    <li class="nav-item dropdown">
      <a
        @class(['nav-link', 'dropdown-toggle', 'active' => $item['active'],'ps-0' => $loop->first]) class="nav-link dropdown-toggle"
        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        {!! $item['name'] !!}
      </a>
      <ul class="dropdown-menu">
        @foreach($item['submenu'] as $element)
          <li><a class="dropdown-item" href="{{ $element['link'] }}">{!! $element['name'] !!}</a></li>
        @endforeach
      </ul>
    </li>
  @endif
@endforeach
