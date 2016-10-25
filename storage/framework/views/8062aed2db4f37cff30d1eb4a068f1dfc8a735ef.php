<!-- Mainly scripts -->
<script src="<?php echo e(asset('js/jquery-2.1.1.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/plugins/metisMenu/jquery.metisMenu.js')); ?>"></script>
<script src="<?php echo e(asset('js/plugins/slimscroll/jquery.slimscroll.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/plugins/dataTables/datatables.min.js')); ?>"></script>
<!-- Custom and plugin javascript -->
<!-- <script src="<?php echo e(asset('js/inspinia.js')); ?>"></script> -->
<script src="<?php echo e(asset('js/plugins/pace/pace.min.js')); ?>"></script> 
<!-- Sweet alert -->
<script src="<?php echo e(asset('js/plugins/sweetalert/sweetalert.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/plugins/iCheck/icheck.min.js')); ?>"></script>
<!-- Page-Level Scripts -->
<script>
$(document).ready(function(){ 
    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'ExampleFile'},
            {extend: 'pdf', title: 'ExampleFile'},

            {extend: 'print',
             customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
            }
            }
        ] 
    }); 
});
$('.prodel').click(function () {  
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function () {
        swal("Deleted!", "Your imaginary file has been deleted.", "success");
    });
});
</script>
<!-- iCheck -->
<script>
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>