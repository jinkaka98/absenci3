<?php 
if(empty($connection)){
  header('location:../../');
} else {
  include_once 'sw-mod/sw-panel.php';
echo'
  <div class="content-wrapper">';
switch(@$_GET['op']){ 
    default:
echo'
<section class="content-header">
  <h1>Data<small> Permohonan Sakit</small></h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li class="active">Data Permohonan Sakit</li>
    </ol>
</section>';
echo'
<section class="content">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Data Permohonan Sakit</b></h3>
        </div>
    <div class="box-body">
    <div class="table-responsive">
          <table id="swdatatable" class="table table-bordered">
            <thead>
            <tr>
              <th style="width: 10px">No</th>
              <th>Tgl Pengajuan</th>
              <th>Nama</th>
              <th>Mulait</th>
              <th>Selesai</th>
              <th>Keterangan</th>
              <th style="width:150px" class="text-center">Aksi</th>
            </tr>
            </thead>
            <tbody>';
            $query="SELECT * FROM permission order by permission_id DESC";
            $result = $connection->query($query);
            if($result->num_rows > 0){
            $no=0;
           while ($row= $result->fetch_assoc()) {
              $no++;
              echo'
              <tr>
                <td class="text-center">'.$no.'</td>
                <td>'.tgl_ind($row['date']).'</td>
                <td>'.strip_tags($row['permission_name']).'</td>
                <td>'.tgl_ind($row['permission_date']).'</td>
                <td>'.tgl_ind($row['permission_date_finish']).'</td>
                <td>'.strip_tags($row['permission_description']).'</td>
                <td class="text-center">
                  <div class="btn-group">';
                  if($level_user==1){
                    echo'
                    <a href="./sw-mod/izin/proses.php?action=print&id='.epm_encode($row['permission_id']).'" target="_blank" class="btn btn-md btn-primary" title="Print">Download</a>

                    <button class="btn btn-md btn-danger delete" title="Delete" data-id="'.epm_encode($row['permission_id']).'" data-employees="'.epm_encode($row['employees_id']).'"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
                  }
                  else{
                  echo'
                    <button type="button" class="btn btn-warning btn-xs access-failed enable-tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> Ubah</button>
                    <buton type="button" class="btn btn-xs btn-danger access-failed" title="Hapus"><i class="fa fa-trash-o"></i> Hapus</button>';
                  }
                  echo'
                  </div>

                </td>
              </tr>';}}
            echo'
            </tbody>
            </table>
        </div>
          </div>
        </div>
      </div> 
    </section>';
break;
}?>

</div>
<?php }?>