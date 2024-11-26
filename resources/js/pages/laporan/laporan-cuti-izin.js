import { initDatepicker } from "../../lib/utils";
import $ from 'jquery'
import '../../vendor/datatable'


$('.datatable').dataTable({
    responsive: {
        details: {
            display: $.fn.dataTable.Responsive.display.childRowImmediate
        }
    }       
})
initDatepicker()