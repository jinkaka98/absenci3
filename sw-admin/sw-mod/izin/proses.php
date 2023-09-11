<?php
session_start();
if(empty($_SESSION['SESSION_USER']) && empty($_SESSION['SESSION_ID'])){
    header('location:../../login/');
 exit;}
else {
require_once'../../../sw-library/sw-config.php';
require_once'../../login/login_session.php';
include('../../../sw-library/sw-function.php');
include_once'../../../sw-library/vendor/autoload.php';

switch (@$_GET['action']){
case 'delete':
  $id           = mysqli_real_escape_string($connection,epm_decode($_POST['id']));
  $employees_id = mysqli_real_escape_string($connection,epm_decode($_POST['employees_id']));
  $query_delete  ="SELECT files,permission_date,permission_date_finish from permission WHERE employees_id='$employees_id' AND permission_id='$id'";
  $result_delete = $connection->query($query_delete);
  if($result_delete->num_rows > 0){
     $row = $result_delete->fetch_assoc();

    $start = date('Y-m-d',strtotime('-1 days',strtotime($row['permission_date'])));
    $finish = date('Y-m-d',strtotime('-1 days',strtotime($row['permission_date_finish'])));
    
    $images_delete = strip_tags($row['files']);
      $directory='../../../sw-content/izin/'.$images_delete.'';
      if(file_exists("../../../sw-content/izin/$images_delete")){
          unlink ($directory);
      }

    while ($start <= $finish) {
          $start = date('Y-m-d',strtotime('+1 days',strtotime($start)));
          $deleted_absent  = "DELETE FROM presence WHERE employees_id='$employees_id' AND presence_date='$start'";
          $connection->query($deleted_absent);
    }
    $deleted  = "DELETE FROM permission WHERE  permission_id='$id'";
    if($connection->query($deleted) === true) {
      echo'success';
    } else { 
      //tidak berhasil
      echo'Data tidak berhasil dihapus.!';
      die($connection->error.__LINE__);
    }

  }

// ---------------- PRINT ----------------*/
break;
case 'print':
  if(!empty($_GET['id'])){
        $id     =  mysqli_real_escape_string($connection,epm_decode($_GET['id'])); 
        $query ="SELECT permission.*,employees.employees_name FROM permission,employees WHERE permission.employees_id=employees.id AND permission.permission_id='$id'";
          $result= $connection->query($query);
          if($result->num_rows > 0){
            $row  = $result->fetch_assoc();
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
            ob_start();
            echo'<!DOCTYPE html>
                <html>
                <head>
                    <title>Cetak Data Surat Sakit</title>
                    <style>
                    body{font-family:Arial,Helvetica,sans-serif}.container_box{position:relative}.container_box .row h3{line-height:25px;font-size:20px;margin:0px 0 10px;text-transform:uppercase}.container_box .text-center{text-align:center}.container_box .content_box{position:relative}.container_box .content_box .des_info{margin:20px 0;text-align:right}.container_box h3{font-size:30px}table.customTable{width:100%;background-color:#fff;border-collapse:collapse;border-width:1px;border-color:#b3b3b3;border-style:solid;color:#000}table.customTable td,table.customTable th{border-width:1px;border-color:#b3b3b3;border-style:solid;padding:5px;text-align:left}table.customTable thead{background-color:#f6f3f8}.text-center{text-align:center}
                    .label {display: inline;padding: .2em .6em .3em;font-size: 75%;font-weight: 700;line-height: 1;color: #fff;text-align: center;white-space: nowrap; vertical-align: baseline;border-radius: .25em;}
                    .label-success{background-color: #00a65a !important;}.label-warning {background-color: #f0ad4e;}.label-info {background-color: #5bc0de;}.label-danger{background-color: #dd4b39 !important;}
                    p{line-height:20px;padding:0px;margin: 5px;}.pull-right{float:right}
                    </style>
                </head>
                <body>
              <section class="container_box">
                <div class="row">
                <p>Nama           : '.$row['employees_name'].'</p>
                <p>Mulai Sakit    : '.tgl_ind($row['permission_date']).'</p>
                <p>Selesai Sakit  : '.tgl_ind($row['permission_date_finish']).'</p><br>

                    <div class="content_box text-center">
                        <img src="../../../sw-content/izin/'.$row['files'].'"><br><br>
                    </div>
                </div>
              </section>
            </body>
            </html>';
              $html = ob_get_contents(); 
              ob_end_clean();
              $mpdf->WriteHTML(utf8_encode($html));
              $mpdf->Output("Bukti-Sakit-".$row['employees_name']."-$date.pdf" ,'I');
        }else{
          echo'DATA TIDAK DITEMUKAN';
        }}

break;

}

}
