import $ from 'jquery'
import '../vendor/datatable'
import { AjaxAction, confirmation, HandleFormSubmit, initDatepicker, reloadDatatable, showToast } from '../lib/utils'


$('.main-content').on('click', '[data-action]', function(e) {

    if (this.dataset.method == 'delete') {
        confirmation(res => {
            (new AjaxAction(this))
            .onSuccess(res => {
                showToast(res.status, res.message)
                reloadDatatable('user-table')
            }, false)
            .execute()
        })

        return
    };

    (new AjaxAction(this))
    .onSuccess(function(res) {
        initDatepicker();

        $('.add-atasan').on('click', function() {

            (new AjaxAction(this))
            .onSuccess(res => {
                const modalEl = $('#modalSearch')
                modalEl.html(res)
                modalEl.modal('show')

                $('#listatasan-table').on('click', 'tr', function() {
                    // Sembunyikan modal
                    modalEl.modal('hide');
                
                    // Ambil data dari atribut `data-*`
                    const atasan = `<tr>
                        <td>${this.dataset.nama}</td>
                        <td>${this.dataset.email}</td>
                        <td><input class="form-control" placeholder="Level atasan.." name="atasan[${this.dataset.id}]" /></td>
                    </tr>`;
                
                    // Tambahkan baris baru di awal tabel `#listAtasan`
                    $('#listAtasan').prepend(atasan);
                });                

            }, false)
            .execute();
        }); 

        $('.btn-delete').on('click', function() {
            confirmation(() => {
                $(this).parents('tr').remove()
                
            })
        })

        const handle = (new HandleFormSubmit())
        .onSuccess(res => {

        })
        .reloadDatatable('user-table')
        .init();
    })
    .execute()
})
