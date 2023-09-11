<?php session_start(); error_reporting(0);
    require_once'../../../sw-library/sw-config.php'; 
    require_once'../../../sw-library/sw-function.php';
if(empty($_SESSION['SESSION_USER']) && empty($_SESSION['SESSION_ID'])){
    //Kondisi tidak login
   header('location:../login/');
}

else{
  //kondisi login
switch (@$_GET['action']){
case 'excel':

if (empty($_GET['print'])) {
  header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=Data-Absensi-$date.xls");
}
else {
echo'<script>
     window.onafterprint = window.close;
      window.print();
    </script>';  
}
    
echo'<!DOCTYPE html>
<html>
<head>
    <title>Cetak Data Absensi Harian</title>
    <style>
    body{font-family:Arial,Helvetica,sans-serif}.container_box{position:relative}.container_box .row h3{line-height:25px;font-size:20px;margin:0px 0 10px;text-transform:uppercase}.container_box .text-center{text-align:center}.container_box .content_box{position:relative}.container_box .content_box .des_info{margin:20px 0;text-align:right}.container_box h3{font-size:30px}table.customTable{width:100%;background-color:#fff;border-collapse:collapse;border-width:1px;border-color:#b3b3b3;border-style:solid;color:#000}table.customTable td,table.customTable th{border-width:1px;border-color:#b3b3b3;border-style:solid;padding:5px;text-align:left}table.customTable thead{background-color:#f6f3f8}.text-center{text-align:center}
    .label {display: inline;padding: .2em .6em .3em;font-size: 75%;font-weight: 700;line-height: 1;color: #fff;text-align: center;white-space: nowrap; vertical-align: baseline;border-radius: .25em;}
    .label-success{background-color: #00a65a !important;}.label-warning {background-color: #f0ad4e;}.label-info {background-color: #5bc0de;}.label-danger{background-color: #dd4b39 !important;}
    p{line-height:20px;padding:0px;margin: 5px;}.pull-right{float:right}
    span.text-red{color:#dd4b39!important}
    </style>

</head>
<body>';
if(isset($_GET['month']) OR isset($_GET['year'])){
          $bulan   = date ($_GET['month']);
          $month_en = bulan_indo2((int)$bulan);
      } 

      else{
          $bulan  = date ("m");
      }
        $hari       = date("d");
        $tahun      = date("Y");
        $jumlahhari = date("t",mktime(0,0,0,$bulan,$hari,$tahun));
        $s          = date ("w", mktime (0,0,0,$bulan,1,$tahun));
      echo'
      <section class="container_box">
      <div class="row">';
      if(isset($_GET['month']) OR isset($_GET['year'])){
        echo'<h3 class="text-center">LAPORAN DETAIL HARIAN<br>PERIODE WAKTU '.$month_en.' - '.$_GET['year'].'</h3>';}
        else{
        echo'<h3 class="text-center">LAPORAN DETAIL BULAN<br>'.$month_en.' - '.$year.'</h3>';
        }
        echo'
        <div class="content_box">
        <table class="customTable"
          <thead>
            <tr>
              <th rowspan="2" width="40" class="text-center" style="vertical-align: middle;">No</th>
              <th colspan="2" rowspan="2" style="vertical-align: middle;">Nama Pegawai</th>
              <th class="text-center" colspan="'.$jumlahhari.'">'.$month_en.'</th>
              <th class="text-center" colspan="3">Keterangan</th>
            </tr>
            <tr>';
            $sum=0;$libur=0;
            for ($d=1;$d<=$jumlahhari;$d++) {
                    $warna      = '';
                    $background = '';
               if (date("l",mktime (0,0,0,$bulan,$d,$tahun)) == "Saturday" OR date("l",mktime (0,0,0,$bulan,$d,$tahun)) == "Sunday"){
                    $warna='color:white';
                    $background ='background:#FF0000';
                    $sum++;
                }else{
                    $date_month_year = ''.$year.'-'.$bulan.'-'.$d.'';
                    $query_holiday="SELECT holiday_date FROM holiday WHERE holiday_date='$date_month_year'";
                    $result_holiday = $connection->query($query_holiday);
                      if($result_holiday->num_rows > 0){
                        $warna='color:white';
                        $background ='background:#FF0000';
                        $libur++;
                      }
                }

              echo'
              <th width="50" class="text-center" style="'.$warna.'; '.$background.'">'.$d.'</th>';
            }
            echo'
            <th width="50" class="text-center">I</th>
            <th width="50" class="text-center">A</th>
            <th width="50" class="text-center">S</th>
            </tr>
          </thead>
          <tbody>';
           $query ="SELECT id,employees_name FROM employees  ORDER BY id ASC";
          $result = $connection->query($query);$no=0;
          while ($row = $result->fetch_assoc()){$no++;
            echo'
            <tr>
              <td rowspan="2" class="text-center">'.$no.'</td>
              <td rowspan="2" width="150">'.$row['employees_name'].'</td>
              <td width="60">Masuk</td>';
               for ($d=1;$d<=$jumlahhari;$d++) {
                $date_month_year = ''.$year.'-'.$bulan.'-'.$d.'';
                 if(isset($_GET['month']) OR isset($_GET['year'])){
                    $month = $_GET['month'];
                    $year  = $_GET['year'];
                    $filter ="presence_date='$date_month_year' AND MONTH(presence_date)='$month' AND year(presence_date)='$year'";
                  } 
                  else{
                    $filter ="presence_date='$date_month_year' AND MONTH(presence_date) ='$month'";
                  }

                $query_absen ="SELECT presence_id,presence_date,time_in,time_out FROM presence WHERE $filter AND employees_id='$row[id]' ORDER BY presence_id DESC";
                $result_absen = $connection->query($query_absen);
                $row_absen = $result_absen->fetch_assoc();
                if($row_absen['time_in']==NULL){
                  $jam_masuk ='<span class="text-red"><b>x</b></span>';
                }else{
                  $jam_masuk = $row_absen['time_in'];
                }
                echo'
                <td class="text-center">'.$jam_masuk.'</td>';
              }

             if(isset($_GET['month']) OR isset($_GET['year'])){
                $month = $_GET['month'];
                $year  = $_GET['year'];
                $filter ="MONTH(presence_date)='$month' AND year(presence_date)='$year'";
              } 
              else{
                $filter ="MONTH(presence_date)='$month' AND year(presence_date)='$year'";
              }

            $query_alpha="SELECT presence_id FROM presence WHERE $filter AND employees_id='$row[id]'";
            $alpha = $connection->query($query_alpha);
            $alpha = $jumlahhari - $alpha->num_rows - $sum - $libur;

            $query_sakit="SELECT presence_id FROM presence WHERE $filter AND employees_id='$row[id]' and present_id='2'";
            $sakit = $connection->query($query_sakit);

            $query_izin="SELECT presence_id FROM presence WHERE $filter AND employees_id='$row[id]' and present_id='3'";
            $izin = $connection->query($query_izin);

            echo'
            <th width="50" rowspan="2" class="text-center">'.$izin->num_rows.'</th>
            <th width="50" rowspan="2" class="text-center">'.$alpha.'</th>
            <th width="50" rowspan="2" class="text-center">'.$sakit->num_rows.'</th>
            </tr>
            <tr>
              <td width="60">Pulang</td>';
              for ($d=1;$d<=$jumlahhari;$d++) {
                $date_month_year = ''.$year.'-'.$bulan.'-'.$d.'';
                 if(isset($_GET['month']) OR isset($_GET['year'])){
                    $month = $_GET['month'];
                    $year  = $_GET['year'];
                    $filter ="presence_date='$date_month_year' AND MONTH(presence_date)='$month' AND year(presence_date)='$year'";
                  } 
                  else{
                    $filter ="presence_date='$date_month_year' AND MONTH(presence_date) ='$month'";
                  }

                $query_absen ="SELECT presence_id,presence_date,time_in,time_out FROM presence WHERE $filter AND employees_id='$row[id]' ORDER BY presence_id DESC";
                $result_absen = $connection->query($query_absen);
                $row_absen = $result_absen->fetch_assoc();
                if($row_absen['time_in']==NULL){
                  $jam_pulang ='<span class="text-red"><b>x</b></span>';
                }else{
                  $jam_pulang = $row_absen['time_out'];
                }
                echo'
                <td class="text-center">'.$jam_pulang.'</td>';
              }
              echo'
            </tr>';
          }
          echo'
          </tbody>
          </table>
       </div>
      </div>
    </section>
</body>
</html>';
break;
}
}?>