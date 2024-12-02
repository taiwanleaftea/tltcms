<div class="container-lg d-print-none">
  <div class="breadcrumb-container">
    <ul class="breadcrumb">
      @foreach($breadcrumb as $item)
        @if($loop->last)
          <li class="breadcrumb-item">{!! $item['name'] !!}</li>
        @else
          <li class="breadcrumb-item">
            <a href="{{ $item['link'] }}" {{ $item['title'] ? 'title="' . $item['title'] . '"' : '' }}>{!! $item['name'] !!}</a>
          </li>
        @endif
      @endforeach
    </ul>
  </div>
</div>