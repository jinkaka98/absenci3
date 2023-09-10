<?php
session_start();
if(empty($_SESSION['SESSION_USER']) && empty($_SESSION['SESSION_ID'])){
    header('location:../../login/');
 exit;}
else {
require_once'../../../sw-library/sw-config.php';
require_once'../../login/login_session.php';
include('../../../sw-library/sw-function.php');

switch (@$_GET['action']){
case 'loaddata':
echo'
<div class="table-responsive">
  <table id="swdatatable" class="table table-bordered">
    <thead>
    <tr>
      <th style="width:20px" class="text-center">No</th>
      <th>Hari/Tanggal</th>
      <th style="width:100px">Aksi</th>
    </tr>
    </thead>
    <tbody>';
    $query="SELECT * FROM holiday order by holiday_id DESC";
    $result = $connection->query($query);
    if($result->num_rows > 0){
    $no=0;
   while ($row= $result->fetch_assoc()) {$no++;
      echo'
      <tr>
        <td class="text-center">'.$no.'</td>
        <td>'.format_hari_tanggal($row['holiday_date']).'</td>
        <td>
          <div class="btn-group">';
          if($level_user==1){
            echo'
            <button class="btn btn-warning btn-xs enable-tooltip btn-update" title="Edit" data-id="'.strip_tags($row['holiday_id']).'" data-date="'.tanggal_ind($row['holiday_date']).'"><i class="fa fa-pencil-square-o"></i> Ubah</button>
            <buton data-id="'.epm_encode($row['holiday_id']).'" class="btn btn-xs btn-danger delete" title="Hapus"><i class="fa fa-trash-o"></i> Hapus</button>';}
        else {
          echo'
            <button type="button" class="btn btn-warning btn-xs access-failed enable-tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> Ubah</button>
            <buton type="button" class="btn btn-xs btn-danger access-failed" title="Hapus"><i class="fa fa-trash-o"></i> Hapus</button>';
        }echo'
          </div>
        </td>
      </tr>';}}
    echo'
    </tbody>
  </table>
</div>';
echo'
<script>
  $("#swdatatable").dataTable({
      "iDisplayLength":35,
      "aLengthMenu": [[35, 40, 50, -1], [35, 40, 50, "All"]]
  });
</script>';


break;
case 'add-update':
  $error = array();
  $id = anti_injection($_POST['id']);

  if (empty($_POST['holiday_date'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $holiday_date = date('Y-m-d',strtotime($_POST['holiday_date']));
  }

  if (empty($error)) { 
    $query ="SELECT holiday_id FROM holiday WHERE holiday_id='$id'";
    $result = $connection->query($query);
      if(!$result->num_rows > 0){
        // Add ---------------------
        $query_check ="SELECT holiday_id FROM holiday WHERE holiday_date='$holiday_date'";
        $result_check = $connection->query($query_check);
        if(!$result_check->num_rows > 0){
            $add ="INSERT INTO holiday (holiday_date) values('$holiday_date')"; 
            if($connection->query($add) === false) { 
                die($connection->error.__LINE__); 
                echo'Data tidak berhasil disimpan!';
            } else{
                echo'success';
            }
        }else{
          echo'Sebelumnya data dengan tanggal '.$holiday_date.' sudah ada.!';
        }
      }
      else{
        // Update -----------------
          $update="UPDATE holiday SET holiday_date='$holiday_date' WHERE holiday_id='$id'"; 
            if($connection->query($update) === false) { 
                die($connection->error.__LINE__); 
                echo'Data tidak berhasil disimpan!';
            } else{
                echo'success';
            }
      }
  }
  else{           
     echo'Bidang inputan tidak boleh ada yang kosong..!';
}

break;
/* --------------- Delete ------------*/
case 'delete':
  $id       = mysqli_real_escape_string($connection,epm_decode($_POST['id']));
    $deleted  = "DELETE FROM holiday  WHERE holiday_id='$id'";
      if($connection->query($deleted) === true) {
          echo'success';
        } else { 
          //tidak berhasil
          echo'Data tidak berhasil dihapus.!';
          die($connection->error.__LINE__);
      }
  

break;

}

}
