<?php error_reporting(0);
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
  <h1>Data<small> Absensi</small></h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li class="active">Data Absensi</li>
    </ol>
</section>';
echo'
<section class="content">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Laporan Harian</b></h3>
        </div>
        <div class="box-body">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <select class="form-control name" required>
                <option value="">Semua</option>';
               $query  ="SELECT id,employees_name from employees ORDER BY id ASC";
                $result = $connection->query($query);
                  while($row = $result->fetch_assoc()) { 
                    echo'<option value="'.$row['id'].'">'.$row['employees_name'].'</option>';}
              echo'
              </select>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <select class="form-control month" required>';
                if($month ==1){echo'<option value="01" selected>Januari</option>';}else{echo'<option value="01">Januari</option>';}
                if($month ==2){echo'<option value="02" selected>Februari</option>';}else{echo'<option value="02">Februari</option>';}
                if($month ==3){echo'<option value="03" selected>Maret</option>';}else{echo'<option value="03">Maret</option>';}
                if($month ==4){echo'<option value="04" selected>April</option>';}else{echo'<option value="04">April</option>';}
                if($month ==5){echo'<option value="05" selected>Mei</option>';}else{echo'<option value="05">Mei</option>';}
                if($month ==6){echo'<option value="06" selected>Juni</option>';}else{echo'<option value="06">Juni</option>';}
                if($month ==7){echo'<option value="07" selected>Juli</option>';}else{echo'<option value="07">Juli</option>';}
                if($month ==8){echo'<option value="08" selected>Agustus</option>';}else{echo'<option value="08">Agustus</option>';}
                if($month ==9){echo'<option value="09" selected>September</option>';}else{echo'<option value="09">September</option>';}
                if($month ==10){echo'<option value="10" selected>Oktober</option>';}else{echo'<option value="10">Oktober</option>';}
                if($month ==11){echo'<option value="11" selected>November</option>';}else{echo'<option value="11">November</option>';}
                if($month ==12){echo'<option value="12" selected>Desember</option>';}else{echo'<option value="12">Desember</option>';}
              echo'
              </select>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <select class="form-control year" required>';
                $mulai= date('Y') - 2;
                for($i = $mulai;$i<$mulai + 50;$i++){
                    $sel = $i == date('Y') ? ' selected="selected"' : '';
                    echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>';
                }
                echo'
              </select>
            </div>
          </div>

          <div class="col-md-3">
            <div class="btn-group pull-right">
            <button type="button" class="btn btn-primary btn-sortir">Tampilkan</button>
            <button type="button" class="btn btn-warning">Ekspor/Cetak</button>
            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#" class="btn-print" data-id="excel">EXCEL</a></li>
                    <li><a href="#" class="btn-print" data-id="print">PRINT</a></li>
                  </ul>
            </div>
          </div>
        </div>

        <div class="loaddata"></div>
      
        </div>
    </div>
  </div> 
</section>';
break;
case 'view-present':
echo'
<section class="content-header">
  <h1>Data Absensi<small> Karyawan</small></h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li><a href="#" onclick="history.back()">Data Lokasi</a></li>
      <li class="active">Data Absensi Karyawan</li>
    </ol>
</section>';
if(!empty($_GET['id'])){
      $id     =  mysqli_real_escape_string($connection,epm_decode($_GET['id'])); 
      $query  ="SELECT * from employees WHERE id='$id'";
      $result = $connection->query($query);
      if($result->num_rows > 0){
        $row  = $result->fetch_assoc();
    echo'
<section class="content"><input type="hidden" id="id" value="'.$row['id'].'" readonly>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Data Absensi Karyawan: '.$row['employees_name'].'</b></h3>
          <div class="box-tools pull-right">
            <button type="button" onclick="history.back()" class="btn btn-default btn-flat">Kembali</button>
          </div>
        </div>

        <div class="box-body">
            <div class="loaddata"></div>
        </div>
      </div>
    </div>
  </div>


</section>';
}}

break;
}?>

</div>
<?php }?>