<!-- Mainly scripts -->
<script src="{{asset('js/jquery.min.js')}}"></script> 
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<!-- Custom and plugin javascript -->
<script src="{{asset('js/inspinia.js')}}"></script>
<script src="{{asset('js/plugins/pace/pace.min.js')}}"></script>
<script src="{{asset('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- Chosen -->
<script src="{{asset('js/plugins/chosen/chosen.jquery.js')}}"></script>
<script src="{{asset('js/plugins/dataTables/datatables.min.js')}}"></script>
<!-- Data picker -->
<script src="{{asset('js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
<!-- Sweet alert -->
<script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
<!-- slick carousel-->
<script src="{{asset('js/plugins/slick/slick.min.js')}}"></script>
<script src="{{asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>
<!-- Jasny -->
<script src="{{asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>
<!-- SUMMERNOTE -->
<script src="{{asset('js/plugins/summernote/summernote.min.js')}}"></script>
<!-- Jquery Validate -->
<script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>
<!-- Ladda -->
<script src="{{asset('js/plugins/ladda/spin.min.js')}}"></script>
<script src="{{asset('js/plugins/ladda/ladda.min.js')}}"></script>
<script src="{{asset('js/plugins/ladda/ladda.jquery.min.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>   
<!-- Page-Level Scripts -->
<script>
$(document).ready(function(){
  // Editor
  $('.summernote').summernote();
  
  // validate
    $("#form").validate({
        rules: {
            password: {
                required: true,
                minlength: 3
            },
            txtPname:{
              required: true
            },
            url: {
                required: true,
                url: true
            },
            txtPhone: {
                required: true,
                number: true
            },
            min: {
                required: true,
                minlength: 6
            },
            max: {
                required: true,
                maxlength: 4
            },
            txtSetPrice: {
                required: true,
                number: true
            }
        }
    });
    $('.chosen-select').chosen({width: "100%"});
    $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'yyyy-m-d',
    });
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
    // iCheck
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
    $('.product-images').slick({
        dots: true
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
    // Bind normal buttons
    $( '.ladda-button' ).ladda( 'bind', { timeout: 2000 } );

    // Bind progress buttons and simulate loading progress
    Ladda.bind( '.progress-demo .ladda-button',{
        callback: function( instance ){
            var progress = 0;
            var interval = setInterval( function(){
                progress = Math.min( progress + Math.random() * 0.1, 1 );
                instance.setProgress( progress );

                if( progress === 1 ){
                    instance.stop();
                    clearInterval( interval );
                }
            }, 200 );
        }
    });


    var l = $( '.ladda-button-demo' ).ladda();

    l.click(function(){
        // Start loading
        l.ladda( 'start' );

        // Timeout example
        // Do something in backend and then stop ladda
        setTimeout(function(){
            l.ladda('stop');
        },12000)


    });
});

</script>
