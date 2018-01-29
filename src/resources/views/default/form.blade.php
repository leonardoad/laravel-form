<form class="form {{$class}}" role="form"
      @if ($isAjax) data-toggle="ajax-form" @endif
      @if ($enctype) enctype="{{$enctype}}" @endif
      @if ($name) id="form-name-{{ $name }}" data-name="{{$name}}" @endif
      method="{{$method}}" action="{{ $action }}">
      <div class="form__container">
        @if ($html_elements)
            {!! $html_elements !!}
        @else
            @foreach($elements as $element)
                {{ $element->render() }}
            @endforeach
        @endif
        @if(!str_is('get', $method))
        {{ csrf_field() }}
        @endif
    </div>
</form>