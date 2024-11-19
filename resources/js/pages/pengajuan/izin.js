import $ from 'jquery'
import '../../vendor/datatable'
import { AjaxAction, confirmation, HandleFormSubmit, handleNotfication, initDatepicker, reloadDatatable, showToast } from '../../lib/utils'

$(function() {
    handleNotfication(res => {
        (new HandleFormSubmit())
        .onSuccess(res =>{
            window.location.href = window.location.origin + `/pengajuan/izin`
        })
        .onError(err => {
  
        })
        .init()
    }) 
});


$('.main-content').on('click', '[data-action]', function(e) {
    if (this.dataset.method == 'delete') {
        confirmation(res => {
            (new AjaxAction(this))
            .onSuccess(res => {
                showToast(res.status, res.message)
                reloadDatatable('izin-table')
            }, false)
            .execute()
        })

        return
    };


    (new AjaxAction(this))
    .onSuccess(function(res) {
        const startDate = $('[data-hmin]').data('hmin')
        initDatepicker('.date', {
            startDate
        }).on('changeDate', function(e) {
            let tanggal_akhir = $('#tanggal_akhir').val();
            let tanggal_awal = $('#tanggal_awal').val();

                (new AjaxAction(window.location.origin + `/pengajuan/izin/hitung-izin`, {
                    data: {
                        tanggal_awal,
                        tanggal_akhir,
                    }
                }))
                
                .onSuccess(res => {
                    $('#total_izin').val(res)
                }, false)
                .onError(res => {
                    if (res.responseJSON) {
                        showToast(res.responseJSON?.status, res.responseJSON?.message)
                    }
                })
                .execute()
        });

        const handle = (new HandleFormSubmit())
        .onSuccess(res => {

        })
        .reloadDatatable('izin-table')
        .init();
    })
    .execute()
})
