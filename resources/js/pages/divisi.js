import $ from 'jquery'
import '../vendor/datatable'
import { AjaxAction, confirmation, HandleFormSubmit, initDatepicker, reloadDatatable, showToast } from '../lib/utils'


$('.main-content').on('click', '[data-action]', function(e) {
    if (this.dataset.method == 'delete') {
        confirmation(res => {
            (new AjaxAction(this))
            .onSuccess(res => {
                showToast(res.status, res.message)
                reloadDatatable('divisi-table')
            }, false)
            .execute()
        })

        return
    };
    (new AjaxAction(this))
    .onSuccess(function(res) {


        $('.btn-delete').on('click', function() {
            confirmation(() => {
                $(this).parents('tr').remove()
                
            })
        })

        const handle = (new HandleFormSubmit())
        .onSuccess(res => {

        })
        .reloadDatatable('divisi-table')
        .init();
    })
    .execute()
})
