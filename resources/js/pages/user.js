import $ from 'jquery'
import '../vendor/datatable'
import { AjaxAction, HandleFormSubmit, initDatepicker } from '../lib/utils'


$('.main-content').on('click', '.action', function(e) {

    if (!this.dataset.action) {
        throw new Error('data attribute action is required');
    }

    (new AjaxAction(this))
    .onSuccess(function(res) {
        initDatepicker();
        (new HandleFormSubmit())
        .onSuccess(res => {

        })
        .reloadDatatable('user-table')
        .init()
    })
    .execute()
})
