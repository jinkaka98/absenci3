$(document).ready(function() {
    $('#swdatatable').dataTable({
        "iDisplayLength": 20,
        "aLengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]]
    });

    function loading(){
        $(".loading").show();
        $(".loading").delay(1500).fadeOut(500);
    }

    /*------------ Delete -------------*/
     $(document).on('click', '.delete', function(){ 
            var id = $(this).attr("data-id");
            var employees_id = $(this).attr("data-employees");
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
                         url:"sw-mod/izin/proses.php?action=delete",
                         type:'POST',    
                         data:{id:id,employees_id:employees_id},  
                        success:function(data){ 
                            if (data == 'success') {
                                swal({title: 'Berhasil!', text: 'Data berhasil dihapus.!', icon: 'success', timer: 3500,});
                                setTimeout(function(){ location.reload(); }, 2500);
                            } else {
                                swal({title: 'Gagal!', text: data, icon: 'error', timer: 2500,});
                                
                            }
                         }  
                    });  
               } else{  
                return false;
            }  
        });
    }); 

});