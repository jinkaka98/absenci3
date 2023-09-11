<?php
if(empty($connection)){
  header('location:../../');
} else {
  include_once 'sw-mod/sw-panel.php';
  require_once'../sw-library/phpqrcode/qrlib.php'; 
echo'
  <div class="content-wrapper">';
    switch(@$_GET['op']){ 
    default:
echo'
<section class="content-header">
  <h1>Data<small> Lokasi</small></h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li class="active">Data Lokasi</li>
    </ol>
</section>';
echo'
<section class="content">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Data Lokasi</b></h3>
          <div class="box-tools pull-right">';
          if($level_user == 1){
            echo'
            <a href="'.$mod.'&op=add" class="btn btn-success btn-flat" data-target="#modalAdd"><i class="fa fa-plus"></i> Tambah Baru</a>';}
          else{
            echo'
            <button type="button" class="btn btn-success btn-flat access-failed"><i class="fa fa-plus"></i> Tambah Baru</button>';
            }
          echo'
          </div>
        </div>
            <div class="box-body">
            <div class="table-responsive">
            <table id="swdatatable" class="table table-bordered">
              <thead>
              <tr>
                <th style="width:20px" class="text-center">No</th>
                <th class="text-center">ID</th>
                <th>Nama Lokasi</th>
                <th>Alamat</th>
                <th class="text-center">Radius</th>
                <th class="text-center">Jumlah Karyawan</th>
                <th style="width:150px" class="text-center">Aksi</th>
              </tr>
              </thead>
              <tbody>';
              $query="SELECT building_id,name,address,radius FROM building order by building_id  DESC";
              $result = $connection->query($query);
              if($result->num_rows > 0){
              $no=0;
             while ($row= $result->fetch_assoc()) {
              $employees_count ="SELECT id FROM employees WHERE building_id='$row[building_id]'";
              $result_count = $connection->query($employees_count);
                $no++;
                echo'
                <tr>
                  <td class="text-center">'.$no.'</td>
                  <td class="text-center">'.$row['building_id'].'</td>
                  <td>'.$row['name'].'</td>
                  <td>'.$row['address'].'</td>
                  <td class="text-center">'.$row['radius'].'</td>
                  <td class="text-center"><span class="badge bg-yellow">'.$result_count->num_rows.'</span></td>
                  <td class="text-right">
                    <div class="btn-group">';
                      if($level_user == 1){
                      echo'
                     <a href="./'.$mod.'&op=edit&id='.epm_encode($row['building_id']).'" class="btn btn-warning btn-xs enable-tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> Ubah</a>
                 
                      <buton data-id="'.epm_encode($row['building_id']).'" class="btn btn-xs btn-danger delete" title="Hapus"><i class="fa fa-trash-o"></i> Hapus</button>';}
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


case 'add':
echo'
<section class="content-header">
  <h1>Tambah Data<small> Lokasi</small></h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li><a href="./karyawan"> Data Lokasi</a></li>
      <li class="active">Tambah Lokasi</li>
    </ol>
</section>';
echo'
<section class="content">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Tambah Data Lokasi</b></h3>
        </div>

        <div class="box-body">
            <form class="form-horizontal validate add-lokasi">
              <div class="box-body">

                <div class="form-group">
                  <label class="col-sm-2 control-label">Nama Lokasi</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" required>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Alamat Lokasi</label>
                  <div class="col-sm-6">
                    <textarea class="form-control address" name="address" rows="3" required></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Google Map</label>
                  <div class="col-sm-6">
                    <div id="MapLocation" style="height: 350px"></div>
                    <br>
                    <div class="row">
                      <div class="col-lg-6">
                        <input class="form-control" id="Latitude" placeholder="Latitude" name="latitude"  required>
                      </div>

                      <div class="col-lg-6">
                        <input class="form-control" id="Longitude" placeholder="Longitude" name="longitude" required>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Radius</label>
                  <div class="col-sm-6">
                    <div class="input-group">
                      <input type="number" class="form-control" name="radius" required>
                      <span class="input-group-addon">M</span>
                    </div>
                  </div>
                </div>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-sm-2"></div>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                <a class="btn btn-danger" href="./'.$mod.'"><i class="fa fa-remove"></i> Batal</a>
              </div>
              <!-- /.box-footer -->
            </form>
        
      </div>
    </div>
  </div> 
</section>';?>

<script type="text/javascript">
  navigator.geolocation.getCurrentPosition(function(location) {
  var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);

  $("#Latitude").val(location.coords.latitude);
  $("#Longitude").val(location.coords.longitude).keyup();

  var curLocation = [0, 0];
  if (curLocation[0] == 0 && curLocation[1] == 0) {
    curLocation = latlng;
  }
  var map = L.map('MapLocation').setView(curLocation, 20);
  L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);
  map.attributionControl.setPrefix(false);
  var marker = new L.marker(curLocation, {
    draggable: 'true'
  });

    lc = L.control.locate({
      strings: {
          title: "Tunjukkan di mana saya berada!"
      }
    }).addTo(map);

  marker.on('dragend', function(event) {
    var position = marker.getLatLng();
    marker.setLatLng(position, {
      draggable: 'true'
    }).bindPopup(position).update();
    $("#Latitude").val(position.lat);
    $("#Longitude").val(position.lng).keyup();
  });

  $("#Latitude, #Longitude").change(function() {
    var position = [parseInt($("#Latitude").val()), parseInt($("#Longitude").val())];
    marker.setLatLng(position, {
      draggable: 'true'
    }).bindPopup(position).update();
    map.panTo(position);
  });
  map.addLayer(marker);
});
</script>

<?PHP
break;


case 'edit':
echo'
<section class="content-header">
  <h1>Edit Data<small> Lokasi</small></h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li><a href="./karyawan"> Data Lokasi</a></li>
      <li class="active">Edit Lokasi</li>
    </ol>
</section>';
echo'
<section class="content">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Edit Data Lokasi</b></h3>
        </div>

        <div class="box-body">';
          if(!empty($_GET['id'])){
            $id     =  mysqli_real_escape_string($connection,epm_decode($_GET['id'])); 
            $query  ="SELECT * from building WHERE building_id='$id'";
            $result = $connection->query($query);
            if($result->num_rows > 0){
            $row  = $result->fetch_assoc();

            $location = explode(",", $row['latitude_longtitude']);
            echo'
            <form class="form-horizontal validate update-lokasi">
              <input type="hidden"  name="id" value="'.$row['building_id'].'" readonly required>
              <div class="box-body">

                <div class="form-group">
                  <label class="col-sm-2 control-label">Nama Lokasi</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="'.$row['name'].'" required>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Alamat Lokasi</label>
                  <div class="col-sm-6">
                    <textarea class="form-control address" name="address" rows="3" required>'.$row['address'].'</textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Google Map</label>
                  <div class="col-sm-6">
                    <div id="MapLocation" style="height: 350px"></div>
                    <br>
                    <div class="row">
                      <div class="col-lg-6">
                        <input class="form-control" id="Latitude" placeholder="Latitude" name="latitude" value="'.$location[0].'"  required>
                      </div>

                      <div class="col-lg-6">
                        <input class="form-control" id="Longitude" placeholder="Longitude" name="longitude" value="'.$location[1].'" required>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Radius</label>
                  <div class="col-sm-6">
                    <div class="input-group">
                      <input type="number" class="form-control" name="radius" value="'.$row['radius'].'" required>
                      <span class="input-group-addon">M</span>
                    </div>
                  </div>
                </div>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-sm-2"></div>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                <a class="btn btn-danger" href="./'.$mod.'"><i class="fa fa-remove"></i> Batal</a>
              </div>
              <!-- /.box-footer -->
            </form>';?>

            <script type="text/javascript">
                navigator.geolocation.getCurrentPosition(function(location) {
            var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);
              <?php
              if($row['latitude_longtitude']==''){
                echo'
                var curLocation = [0,0];';
              }else{
                echo'
                var curLocation = ['.$row['latitude_longtitude'].'];';
              }?>
              if (curLocation[0] == 0 && curLocation[1] == 0) {
                curLocation = latlng;
              }
              var map = L.map('MapLocation').setView(curLocation, 18);
              L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
              }).addTo(map);
              map.attributionControl.setPrefix(false);
              var marker = new L.marker(curLocation, {
                draggable: 'true'
              });

              lc = L.control.locate({
                strings: {
                    title: "Tunjukkan di mana saya berada!"
                }
              }).addTo(map);

              marker.on('dragend', function(event) {
              var position = marker.getLatLng();
              $("#Latitude").val(location.coords.latitude);
              $("#Longitude").val(location.coords.longitude).keyup();

              marker.setLatLng(position, {
                  draggable: 'true'
              }).bindPopup(position).update();
                $("#Latitude").val(position.lat);
                $("#Longitude").val(position.lng).keyup();
              });

              $("#Latitude, #Longitude").change(function() {
                var position = [parseInt($("#Latitude").val()), parseInt($("#Longitude").val())];
                marker.setLatLng(position, {
                  draggable: 'true',
                  showCompass: true,
                showPopup: false,
                }).bindPopup(position).update();
                map.panTo(position);
              });
              map.addLayer(marker);
            });
            </script>
<?php }
          else{
            echo'Data tidak ditemukan';
          }}
      echo'
      </div>
    </div>
  </div> 
</section>';

break;
}
echo'
</div>';}?>