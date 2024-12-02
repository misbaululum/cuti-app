@props(['action' => []])
<div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button"
        class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown"
        aria-expanded="false">
        Action 
    </button>
    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
        @foreach ($actions as $label => $value)
            @if ($label === 'Download PDF')
                <li><a class="dropdown-item" href="{{ $value['action'] }}" target="_blank">{{ $label }}</a></li>
            @else
                <li><button class="dropdown-item" data-action="{{ $value['action'] }}" data-method="{{ $value['method'] ?? 'get' }}">{{ $label }}</button></li>
            @endif
        @endforeach
    </ul>
</div>
