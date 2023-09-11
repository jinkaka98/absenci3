<?php if(empty($connection)){
	header('location:./404');
} else {

$mod = "home";$mod = htmlentities(@$_GET['mod']);
// Get number
function get_numbers() {
  for ($i = 1; $i <= 500; $i++) {yield $i;}
}
$result = get_numbers();
function convert($size){
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}
echo'
  <footer class="main-footer" style="color:#fff;">
    <div class="pull-right hidden-xs">Theme LTE / 
      '.convert(memory_get_usage()).'
    </div>
     &copy; 2021 - '.DATE('Y').' '.$site_name.' | Design With <i class="fa fa-heart"></i> From <span id="credits"><a class="credits" style="color:#fff;" href="https://timkoding.com" target="_blank" id="credits">Tim Koding Indonesia</a> - All Rights Reserved</span>
  </footer>
</div>
<!-- wrapper -->
<script src="./sw-assets/js/jquery-2.2.3.min.js"></script>
<script src="./sw-assets/js/jquery-ui.min.js"></script>
<script src="./sw-assets/js/bootstrap.min.js"></script>
<script src="./sw-assets/js/jquery.slimscroll.min.js"></script>
<script src="./sw-assets/js/adminlte.js"></script>
<script src="./sw-assets/js/app.js"></script>
<script src="./sw-assets/js/demo.js"></script>
<script src="./sw-assets/js/sweetalert.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="./sw-assets/js/simple-lightbox.min.js"></script>
<script src="./sw-assets/js/validasi/jquery.validate.js"></script>
<script src="./sw-assets/js/validasi/messages_id.js"></script>
<script src="./sw-assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="./sw-assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>';
echo'

<script src="./sw-assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./sw-assets/plugins/datatables/dataTables.bootstrap.min.js"></script>';
if($mod=='absensi' OR $mod=='absensi-flexible'){
echo'
<script src="../sw-mod/sw-assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>';
}
if($mod=='lokasi'){
echo'
<script src="./sw-assets/plugins/leatfet/leaflet.js"></script>
<script src="./sw-assets/plugins/leatfet/L.Control.Locate.js" ></script>';
}
if(file_exists('sw-mod/'.$mod.'/scripts.js')){
echo'
  <script src="sw-mod/'.$mod.'/scripts.js"></script>';
}
echo'
  <script type="text/javascript">
  	$(document).ready(function() {
  		$(".validate").validate();
  	});
    
    $(document).ready(function() {
      $(".validate2").validate();
    });
    $(document).on("click", ".access-failed", function(){ 
      swal({title:"Error!", text: "Anda tidak memiliki hak akses!", icon:"error",timer:2000,});  
    });
  </script>';?>
  <!-- </body></html> -->
  </body>
</html>
<?PHP }?>

