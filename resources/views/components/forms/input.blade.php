@props(['id' => 'id-input'. rand(), 'type' => 'text', 'label' => null])
<div class="mb-2 form-wrapper">
    @if ($label)
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif
    <input type="{{ $type }}" id="{{ $id }}" {{ $attributes->merge(['class' => 'form-control']) }} />
</div>