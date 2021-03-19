@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('/dist/css/myStyle.css') }}">
<link rel="stylesheet" href="{{ asset('/plugins/toastr/toastr.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('/plugins/clock/css/picker.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<style>
.select2-selection--single {
    width: 100% !important;
    height: calc(2.25rem + 2px) !important;
}

.select2-selection__placeholder {
    color: #403c3c !important;
    font-size: 1rem !important;
}
.select2-selection__rendered{
    color: #403c3c !important; 
    font-size: 1rem !important;
    margin-top: -0.2rem !important;
}
.select2-selection__choice {
    background-color: #007bff !important;
}
</style>
    @yield('page_css')
@endsection

@section('content')
    @include("exam::layouts.header")
    @yield("page_content")
@stop

@section('js')
<script src="{{ asset('/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('/plugins/clock/js/picker.js') }}"></script> 
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<script>
//Comman Scripts 
var loadSpin = $.dialog({
    lazyOpen: true,
    closeIcon: false,
    title: '<span class="fa fa-spinner fa-spin fa-w-16 fa-2x"></span>',
    titleClass: 'btn',
    content: 'Processing',
    theme: 'light',
    backgroundDismissAnimation: 'glow',
    columnClass: 'center',
    boxWidth: '',
});
$(document).ready(function(){
      'use strict';
      window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
      }, false);
    
    var selection = $("#selection").val();
    if(selection == undefined){
      jQuery.ajaxSetup({
        beforeSend: function() {
          $('#loadStudents').hide();
          loadSpin.toggle();
        },
        complete: function(){
          loadSpin.toggle();
          $('#loadStudents').show();
        },
      });
    }

    $('#table').DataTable({
            dom: 'lBfrtip',
            buttons: [
                { extend: 'copy', className: 'btn btn-info btn-sm mb-2' },
                { extend: 'csv', className: 'btn btn-info btn-sm mb-2' },
                { extend: 'excel', className: 'btn btn-info btn-sm mb-2' },
                { extend: 'pdf', className: 'btn btn-info btn-sm mb-2' },
                { extend: 'print', className: 'btn btn-info btn-sm mb-2' },
                { extend: 'colvis', className: 'btn btn-info btn-sm mb-2' }
            ],
            
            "pagingType": "full_numbers",
            "responsive": true,
            "paging": true,
            "searching": true,
            "ordering": true,

            "columnDefs": [{
                "targets": 2,
                "orderTable": false
            }],
        });
        
        $('input[type=text]').on('focusout', function(){
        var word = $(this).val();
        var txt = toTitleCase(word);
        $(this).val(txt);
        });

        $(".time-picker").clockpicker({
            placement: 'top',
            twelvehour: true,
            autoclose: true
        });

        $(".date-picker").datepicker({
        format	: "yyyy-mm-dd",
            autoclose: true,
        });
        $(".select2").select2({
            placeholder: false,
            
        });
        checkOnline();
});
function toTitleCase(str) {
    return str.replace(/\w\S*/g, function (txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
}
function checkOnline() {
  var x = 0;
    setInterval(function () {
        if(navigator.onLine) {
          if(x == 1){
            x = 0;
            toastr.success('You are online!!!');
          }
        }else{
          if(x == 0){
            x = 1;
            toastr.error('Oops! You are offline. Please check your network connection...');
          }
        }   
    }, 1000);
}
function sendPostAjax(url,form_data,callback){
  $.ajax({
      type:'POST',
      url:url,
      data : form_data,
      contentType: false, 
      cache: false,
      processData:false,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success:function(data){
        if(data.res == 1){
          masterAlert(1,'','');
        }else if(data.res == 2){
          masterAlert(2,'','');
        }
        if(callback != undefined){
          successAjaxFunction(data);
        }
      }
  });
}
function trashFunction(url,id,action){

  $.confirm({
    title: 'Are you sure?',
    content: "You won't be able to "+action+" this?",
    backgroundDismissAnimation: 'glow',
    type: 'orange',
    typeAnimated: true,
    autoClose: 'cancel|10000',
    buttons: {
    confirm: {
        text: 'Yes, '+action+' it!',
        btnClass: 'btn-success',
        keys: ['enter', 'shift'],
        action: function(){
          $.ajax({
            type:'GET',
            url:url,
            data:{id:id},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(data){
              if(data.msg == 'Error'){
                masterAlert(2,'',data.msg);
              }else{
                masterAlert(1,'',data.msg);
                location.reload();
              }
            }
          });
        }
      },
      cancel: {
          text: 'Cancel',
          btnClass: 'btn-danger',
          keys: ['esc'],
          action: function(){
              
          }
      }
    }
  });
}
function masterAlert(type,content,msg){
  if(type == 1){ 
    if(msg !=undefined && msg !=''){
      var content = msg;
    }else{
      var content = 'everything went well';
    }
    var title = 'Successfully!';
    
    var type = 'green';
    var btnClass = 'btn-green';
    var icon = 'glyphicon glyphicon-ok';
  }else if(type == 2){ 
    if(msg !=undefined && msg !=''){
      var content = msg;
    }else{
      var content = 'Something went wrong';
    }
    var title = 'Encountered an error!';
    
    var type = 'red';
    var btnClass = 'btn-red';
    var icon = 'glyphicon glyphicon-remove';
  }
  
  $.alert({
      closeIcon: false,
      title: title,
      content: content,
      type: type,
      typeAnimated: true,
      autoClose: 'ok|5000',
      icon: icon,
      backgroundDismiss: true,
      buttons: {
        ok : {
        //isHidden: true,
        text: 'Ok..',
        btnClass: btnClass,
        close: function () {
          
        }
        }
      }
  }); 
}
</script>
    @yield('page_js')
@endsection