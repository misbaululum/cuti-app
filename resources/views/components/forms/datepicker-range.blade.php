@props(['label' => null, 'date-name1' => '', 'date-name2' => '', 'date-value1' => '', 'date-value2' => '' ])
<div class="mb-2 form-wrapper">
    @if ($label)
        <label class="form-label">{{ $label }}</label>
    @endif
    <div class="input-group input-daterange datepicker date" data-date-format="dd-mm-yyyy">
        <input class="form-control" required="" type="text" id="{{ $dateName1 }}" name="{{ $dateName1 }}" value="{{ $dateValue1 }}" readonly="">
        <span class="bg-primary text-light px-3 justify-content-center align-items-center d-flex">sd</span>
        <input class="form-control" required="" type="text" id="{{ $dateName2 }}" name="{{ $dateName2 }}" value="{{ $dateValue2 }}" readonly="">
    </div>
</div>