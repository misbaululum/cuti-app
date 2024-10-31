@props(['id' => 'id-datepicker'. rand(), 'format' => 'dd-mm-yyyy', 'label' => null])

<div class="mb-2" form-wrapper>
    @if ($label)
            <label for="{{ $id }}" class="form-label">{{ $label }}</label>
        @endif
        <div class="input-group input-append date"
             data-date-format="{{ $format }}">
             <input id="{{ $id }}" {{ $attributes->merge(['class' => 'form-control']) }} type="text" readonly="" autocomplete="off">
             <button class="btn btn-outline-secondary" type="button">
            <i class="far fa-calendar-alt"></i>
        </button>
    </div>
</div>
