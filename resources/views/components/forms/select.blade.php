@props(['id' => 'id-select', rand(), 'label' => null])

<div class="mb-2 form-wrapper">
    @if ($label)
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif  

    <select {{ $attributes->merge(['class' => 'form-select']) }} id="{{ $id }}">
        {{ $slot }}
    </select>
</div>