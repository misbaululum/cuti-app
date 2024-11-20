import iziToast from 'izitoast'
import 'bootstrap-datepicker'
import 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'
import $ from 'jquery'
import 'izitoast/dist/css/iziToast.min.css'
import Swal from 'sweetalert2'
import select2 from 'select2'
import 'select2/dist/css/select2.min.css'
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css'
const modalEl = $('#modalAction')

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
    }
})

export function reloadDatatable(id) {
    window.LaravelDataTables[id]?.ajax.reload(null, false)
}

export function confirmation(cb, configs = {}) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        ...configs
      }).then((result) => {
        if (result.isConfirmed) {
          cb && cb(result)
        }
      });
}

export function initSelect2(selector = '.select2', options = {}) {
    select2($);
    const _select2 = $(selector)

    _select2.select2({
        placeholder: _select2.data('placeholder'),
        theme: 'bootstrap-5',
        dropdownParent: _select2.parents('.modal-content'),
    });
}

export function initDatepicker(selector = '.date', options = {}) {
   const date = $(selector).datepicker({
        autoclose: true,
        todayHighlight: true,
        ...options
    })

    return date
}


export function handleNotfication(cb) {
    const url = new URL(window.location)
    const params = url.searchParams
    if (params.get('id')) {
        (new AjaxAction(`${url.origin + url.pathname}/${params.get('priority') == '1' ? `approve/${params.get('id')}` : params.get('id')}`))
            .onSuccess(function (res) {
                cb && cb(res)
            })
        
        .execute()
    }
}

export function showToast(type = 'success', message = 'Berhasil Menyimpan Data') {
    iziToast[type]({
        title: 'Info',
        message: message,
        position: 'topRight'
    })
}
class AjaxOption{
    successCb = null
    runDefaultSuccessCb = true
    errorCb = null
    runDefaultErrorCb = true

    onSuccess(cb, runDefault = true) {
        this.successCb = cb
        this.runDefaultSuccessCb = runDefault
        return this
    } 

    onError(cb, runDefault = true) {
        this.errorCb = cb
        this.runDefaultErrorCb = runDefault
        return this
    }
}

export class AjaxAction extends AjaxOption {

    url = ''
    method = 'get'
    // option = {}

    constructor(el, options = {}) {
        super()

        this.options = options
        if (el instanceof HTMLElement) {
                this.el = $(el)
                this.label = this.el.html()
                this.url = this.el.data('action')
                this.method = this.el.data('method')
        } else {
            this.el = null
            this.url = el
        }
    }

    setOption(_option) {
        this.options = _option
        return this
    }

    onSuccess(cb, runDefault = true) {
        this.successCb = cb
        this.runDefaultSuccessCb = runDefault
        return this
    } 

    onError(cb, runDefault = true) {
        this.errorCb = cb
        this.runDefaultErrorCb = runDefault
        return this
    }

    execute() {
        $.ajax({
            url: this.url,
            method: this.method,
            ...this.options,
            beforeSend: () => {
                if (this.el) {
                    this.el.attr('disabled', true)
                    this.el.html('Loading...')
                }
            },
            success: res => {
                if (this.runDefaultSuccessCb){
                    modalEl.html(res)
                    modalEl.modal('show')
                }

                this.successCb && this.successCb(res)
            },
            error: err => {
                if (this.runDefaultErrorCb){
                    
                }
                this.errorCb && this.errorCb(err)
            },
            complete: () => {
                if (this.el) {
                    this.el.attr('disabled', false)
                    this.el.html(this.label)
                }
            }
        })
    }
}

export class HandleFormSubmit extends AjaxOption {
    datatableId = null
    constructor(formId = '#formAction') {
        super()
        this.formId = $(formId)
        this.button = this.formId.find('button[type="submit"]')
        this.buttonLabel = this.button.html()
    }

    reloadDatatable(id) {
        this.datatableId = id
        return this
    }

    init() {
        const _this = this
        this.formId.on('submit', function(e){
            e.preventDefault()

            $.ajax({
                url: _this.formId.attr('action'), 
                method: _this.formId.attr('method'),
                data: new FormData(this),
                processData: false,
                contentType: false,
                beforeSend: () => {
                    _this.button.attr('disabled', true).html('Loading...')
                },
                success: res => {
                    if (_this.runDefaultSuccessCb) {
                        // do default
                        modalEl.modal('hide')
                     }
                     showToast(res?.status);
                     _this.successCb && _this.successCb(res)
                     if (_this.datatableId) {
                        
                         window.LaravelDataTables[_this.datatableId].ajax.reload(null, false)
 
                     }
                },

                error: err => {
                    if (_this.runDefaultErrorCb) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        const message = err.responseJSON?.message
                        const errors = err.responseJSON?.errors

                        showToast('error', message)
                        if (errors) {
                            let focused = false;
                            for (let [key, value] of Object.entries(errors)) {
                                let input = $(`[name="${key}"]`);

                                if (!input.length) {
                                    if (key.includes('.')) {
                                        value = value[0].replace(key, key.split('.')[0]);
                                        key = key.split('.')[0];
                                    }
                                    input = $(`[name="${key}[]"]`);
                                }
                                
                                if (input.length) {
                                    if (!focused) {
                                        input.trigger('focus');
                                        focused = true;
                                    }
                                    input.addClass('is-invalid').parents('.form-wrapper')
                                        .append(`<div class="invalid-feedback">${value}</div>`);
                                }
                            }
                        }

                        
                    }
                    _this.errorCb && _this.errorCb(err)
                    _this.button.attr('disabled', false).html(_this.buttonLabel)
                },

                complete: () => {
                    _this.button.attr('disabled', false).html(_this.buttonLabel)
                }
            })
        })

    }
}