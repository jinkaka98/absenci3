$(document).ready(function() {

$(".datepicker").datepicker({
  format: 'dd-mm-yyyy',
  autoclose:true
});

function loading(){
    $(".loading").show();
    $(".loading").delay(1500).fadeOut(500);
}


loadData();
function loadData() {
    $.ajax({
        url: 'sw-mod/libur/proses.php?action=loaddata',
        type: 'POST',
        success: function(data) {
          $('.loaddata').html(data);
        }
    });
}


/* ----------- Add ------------*/
$('.add').submit(function (e) {
    if($('.holiday_date').val()==''){    
         swal({title:'Oops!', text: 'Harap bidang inputan tidak boleh ada yang kosong.!', icon: 'error', timer: 1500,});
        return false;
        loading();
    }
    else{
        loading();
        e.preventDefault();
        $.ajax({
            url:"sw-mod/libur/proses.php?action=add-update",
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            beforeSend: function () { 
              loading();
            },
            success: function (data) {
                if (data == 'success') {
                    swal({title: 'Berhasil!', text: 'Data Libur berhasil disimpan.!', icon: 'success', timer:2500,});
                   $('#modalAdd').modal('hide');
                   loadData();
                } else {
                    swal({title: 'Oops!', text: data, icon: 'error', timer: 2500,});
                }

            },
            complete: function () {
                $(".loading").hide();
            },
        });
    }
  });


    $(document).on('click', '.btn-update', function(){
        $('#modalAdd').modal('show');
        $('.modal-title').html('Update Libur');

        var id = $(this).attr("data-id"); 
        document.getElementById('id').value = id;

        var data_date = $(this).attr("data-date"); 
        document.getElementById('data-date').value = data_date;
    });


/*------------ Delete -------------*/
 $(document).on('click', '.delete', function(){ 
        var id = $(this).attr("data-id");
          swal({
            text: "Anda yakin menghapus data ini?",
            icon: "warning",
              buttons: {
                cancel: true,
                confirm: true,
              },
            value: "delete",
          })

          .then((value) => {
            if(value) {
                loading();
                $.ajax({  
                     url:"sw-mod/libur/proses.php?action=delete",
                     type:'POST',    
                     data:{id:id},  
                    success:function(data){ 
                        if (data == 'success') {
                            swal({title: 'Berhasil!', text: 'Data berhasil dihapus.!', icon: 'success', timer: 2500,});
                            loadData();
                        } else {
                            swal({title: 'Gagal!', text: data, icon: 'error', timer:2500,});
                            
                        }
                     }  
                });  
           } else{  
            return false;
        }  
    });
}); 

});