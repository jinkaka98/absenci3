<?php if(empty($connection)){
	header('location:./404');
} else {

if(isset($_COOKIE['COOKIES_MEMBER'])){
echo'
<div class="appBottomMenu">
        <a href="./" class="item">
            <div class="col">
                <ion-icon name="home-outline"></ion-icon>
                <strong>Home</strong>
            </div>
        </a>

        <a href="absent" class="item">
            <div class="col">
                <ion-icon name="camera-outline"></ion-icon>
                <strong>Absen</strong>
            </div>
        </a>

        <a href="./cuty" class="item">
            <div class="col">
               <ion-icon name="calendar-outline"></ion-icon>
                <strong>Cuty</strong>
            </div>
        </a>

        <a href="./history" class="item">
            <div class="col">
                 <ion-icon name="document-text-outline"></ion-icon>
                <strong>History</strong>
            </div>
        </a>

        
        <a href="./profile" class="item">
            <div class="col">
                <ion-icon name="person-outline"></ion-icon>
                <strong>Profil</strong>
            </div>
        </a>
    </div>
<!-- * App Bottom Menu -->';
}
ob_end_flush();
echo'
<footer class="text-muted text-center">
   <p>© 2021 - '.$year.' '.$site_name.' - Design By: <span id="credits"><a class="credits_a" href="https://timkoding.com" target="_blank">timkoding.com</a></span></p>
</footer>
<!-- ///////////// Js Files ////////////////////  -->
<!-- Jquery -->
<script src="'.$base_url.'sw-mod/sw-assets/js/lib/jquery-3.4.1.min.js"></script>
<!-- Bootstrap-->
<script src="'.$base_url.'sw-mod/sw-assets/js/lib/popper.min.js"></script>
<script src="'.$base_url.'sw-mod/sw-assets/js/lib/bootstrap.min.js"></script>
<!-- Ionicons -->
<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
<script src="https://kit.fontawesome.com/0ccb04165b.js" crossorigin="anonymous"></script>
<!-- Base Js File -->
<script src="'.$base_url.'sw-mod/sw-assets/js/base.js"></script>
<script src="'.$base_url.'sw-mod/sw-assets/js/sweetalert.min.js"></script>
<script src="'.$base_url.'sw-mod/sw-assets/js/webcamjs/webcam.min.js"></script>';
if($mod =='history' OR $mod=='cuty' OR $mod=='izin'){
echo'
<script src="'.$base_url.'sw-mod/sw-assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="'.$base_url.'sw-mod/sw-assets/js/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="'.$base_url.'sw-mod/sw-assets/js/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="'.$base_url.'sw-mod/sw-assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<script>
    $(".datepicker").datepicker({
        format: "dd-mm-yyyy",
        "autoclose": true
    }); 
    
</script>';
}
echo'
<script src="'.$base_url.'/sw-mod/sw-assets/js/sw-script.js"></script>';
if ($mod =='absent' || $mod == 'absents'){?>
<script src="https://npmcdn.com/leaflet@0.7.7/dist/leaflet.js"></script>
<script type="text/javascript">
    var latitude_building =L.latLng(<?php echo $row_building['latitude_longtitude'];?>);
    navigator.geolocation.getCurrentPosition(function(location) {
    var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);
    var markerFrom = L.circleMarker(latitude_building, { color: "#F00", radius: 10 });
    var markerTo =  L.circleMarker(latlng);
    var from = markerFrom.getLatLng();
    var to = markerTo.getLatLng();
    var jarak = from.distanceTo(to).toFixed(1) / 10;
    var latitude =""+location.coords.latitude+","+location.coords.longitude+"";
    $("#latitude").text(latitude);
    $("#jarak").text(jarak);
    var radius ='<?php echo $row_building['radius'];?>';
     //alert(jarak);
    if (radius > jarak){
        // dalam radius
      swal({title: 'Didalam Radius!', text:'Posisi Anda saat ini didalam radius '+jarak+'M, Silahkan Absen!', icon: 'success', timer: 2000,});
    }else{
      swal({title: 'Oops!', text:'Posisi Anda saat ini di radius '+jarak+'M, tidak ditempat atau Jauh dari Radius!', icon: 'error', timer: 2000,});
    }


     /* ------------------------------------------
        Start Kamera Webcame
    ----------------------------------------------*/
    Webcam.set({
        width: 1080,height: 1350,
        image_format: 'jpeg',
        jpeg_quality:100,
    });

    var cameras = new Array(); //create empty array to later insert available devices
    navigator.mediaDevices.enumerateDevices() // get the available devices found in the machine
    .then(function(devices) {
        devices.forEach(function(device) {
        var i = 0;
            if(device.kind=== "videoinput"){ //filter video devices only
                cameras[i]= device.deviceId; // save the camera id's in the camera array
                i++;
            }
        });
    })

    /* ----------------------------
        Setting Camera Depan HP
    -------------------------------*/
    Webcam.set('constraints',{
        width: 590,
        facingMode: 'user',
        height: 460,
        image_format: 'jpeg',
        jpeg_quality:80,
        sourceId: cameras[0]
     })
        //  window.location.reload(true);
    
    
     
    //  function setmode(facing) {
    //      Webcam.set('constraints',{
    //     width: 590,
    //     facingMode: facing,
    //     height: 460,
    //     image_format: 'jpeg',
    //     jpeg_quality:80,
    //     sourceId: cameras[0]
    //  })
    //      window.location.reload(true);
    //  }

    Webcam.attach('.webcam-capture');
    // preload shutter audio clip
    var shutter = new Audio();
    //shutter.autoplay = true;
    shutter.src = navigator.userAgent.match(/Firefox/) ? './sw-mod/sw-assets/js/webcamjs/shutter.ogg' : './sw-mod/sw-assets/js/webcamjs/shutter.mp3';

    $(document).on('click', '.absent-capture', function(){ 
        //var latitude = $('.latitude').html();
        // play sound effect
        shutter.play();
        var latitude = $('.latitude').html();
        //var jarak = $('.jarak').html();
        // take snapshot and get image data
        Webcam.snap( function(data_uri) {
            // display results in page
            Webcam.upload(data_uri, './sw-proses?action=absent&latitude='+latitude+'&radius='+jarak+'',
                function(code,text) {
                    $data       =''+text+'';
                    var results = $data.split("/");
                    $results = results[0];
                    $results2 = results[1];
                    if($results =='success'){
                        swal({title: 'Berhasil!', text:$results2, icon: 'success', timer: 3500,});
                        setTimeout("location.href = './';",3600);
                    }else{
                        swal({title: 'Oops!', text:text, icon: 'error', timer: 3500,});
                    }
            });    
        });
    })
});
</script>
<?php }?>
  <!-- </body></html> -->
  </body>
</html><?php }?>

