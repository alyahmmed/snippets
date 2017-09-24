@php
$xml_tag = '<?xml version="1.0" encoding="UTF-8" ?>'
@endphp
{!!$xml_tag!!}
<request>
    @if(isset($arr))
    <array>
      @foreach($arr as $item)
        <item>{{$item}}</item>
      @endforeach
    </array>
    @endif
  @if(isset($text))
    <string>{{$text}}</string>
  @endif
  @if(isset($num))
    <string>{{$num}}</string>
  @endif
</request>
