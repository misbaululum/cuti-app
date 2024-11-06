@props(['action' => []])
<div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button"
        class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown"
        aria-expanded="false">
        Action 
    </button>
    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
        @foreach ($actions as $label => $value)
        <li><button class="dropdown-item" data-action="{{ $value['action'] }}" data-method="{{ $value['method'] ?? 'get' }}">{{ $label }}</button></li>
            
        @endforeach
    </ul>
</div>