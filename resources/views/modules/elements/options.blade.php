@foreach($options as $option)
  <option value="{{ $option['value'] }}">{{ $option['name'] }}</option>
@endforeach
