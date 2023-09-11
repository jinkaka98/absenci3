$(document).ready(function() {

function loading(){
    $(".loading").show();
    $(".loading").delay(1500).fadeOut(500);
}

loadData();
function loadData() {
    $.ajax({
        url: 'sw-mod/laporan-harian/proses.php?action=laporan',
        type: 'POST',
        success: function(data) {
          $('.loaddata').html(data);
        }
    });
}

$('.btn-clear').click(function (e) {
    loadData();
    $('.name').val('');
    $('.month').val('');
    $('.year').val('');
});

$('.btn-sortir').click(function (e) {
        var month_d = new Array();
        month_d[0] = "Januari";
        month_d[1] = "Februari";
        month_d[2] = "Maret";
        month_d[3] = "April";
        month_d[4] = "Mei";
        month_d[5] = "Juni";
        month_d[6] = "Juli";
        month_d[7] = "Agustus";
        month_d[8] = "September";
        month_d[9] = "Oktober";
        month_d[10] = "November";
        month_d[11] = "Desember";

        var name = $('.name').val();

        var month = $('.month').val();
        var year  = $('.year').val();

        var d     = new Date(month);
        var n     = month_d[d.getMonth()];
        //document.getElementById("demo").innerHTML = n;
        $('.result-month').html(n);

       $.ajax({
          url: 'sw-mod/laporan-harian/proses.php?action=laporan',
          method:"POST",
          data:{name:name,month:month,year:year},
          dataType:"text",
          cache: false,
          async: false,
            beforeSend: function () { 
             //loading();
            },
            success: function (data) {
               $('.loaddata').html(data);
            },
        complete: function () {
            //$(".loading").hide();
        },
    });
});


    $('.btn-print').click(function (e) {
            var month = $('.month').val();
            var year  = $('.year').val();
            var type  = $(this).attr("data-id");
        

            if(type=='excel'){
                if(month==''){    
                    var url = "./laporan-harian/print?action=excel";
                }else{
                    var url = "./laporan-harian/print?action=excel&month="+month+"&year="+year+"";
                }
            }

            if(type=='print'){
                var url = "./laporan-harian/print?action=excel&month="+month+"&year="+year+"&print=print";
            }
            window.open(url, '_blank');
    });

    $('.btn-print-all').click(function (e) {
            var month = $('.month').val();
            var year  = $('.year').val();
            var type  = $('.type').val();
            if(type =='pdf'){
                // cek berdasarkan bulan
                var url = "./laporan-harian/print?action=allpdf&from="+month+"&to="+year+"";
            }
            if(type=='excel'){
                var url = "./laporan-harian/print?action=allexcel&from="+month+"&to="+year+""; 
            }
            if(type=='print'){
                var url = "./laporan-harian/print?action=allexcel&from="+month+"&to="+year+"&print=print"; 
            }

            window.open(url, '_blank');
    });

});

   



