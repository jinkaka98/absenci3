<?php session_start();
error_reporting(0);
if (empty($_SESSION['SESSION_USER']) && empty($_SESSION['SESSION_ID'])) {
    header('location:../../login/');
    exit;
} else {
    require_once '../../../sw-library/sw-config.php';
    require_once '../../login/login_session.php';
    include('../../../sw-library/sw-function.php');

    switch (@$_GET['action']) {
            /* -------  LOAD LAPORAN ----------*/
        case 'laporan':


            $limit = 100;
            $offset = 0;
            $page = 1;

            if(isset($_POST['page'])){
                $page = $_POST['page'];
                $offset = (($page - 1) * $limit);
            }

            $name     = strip_tags($_POST['name']);

            if ($name == '') {
                $filter_employees = '';
            } else {
                $filter_employees = "WHERE employees.id='$name'";
            }

            if (isset($_POST['month']) or isset($_POST['year'])) {
                $bulan   = date($_POST['month']);
                $month_en = bulan_indo2((int)$bulan);
            } else {
                $bulan  = date("m");
            }
            $hari       = date("d");
            $tahun      = date("Y");
            $jumlahhari = date("t", mktime(0, 0, 0, $bulan, $hari, $tahun));
            $s          = date("w", mktime(0, 0, 0, $bulan, 1, $tahun));


            echo '
        <div class="table-responsive" style="overflow-x: auto!important;">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
            <th rowspan="2" width="40" >No</th>
              <th rowspan="2" width="40" >NIP</th>
              <th rowspan="2" >Shift</th>
                <th rowspan="2">Posisi</th>
              <th colspan="2" rowspan="2" style="vertical-align: middle;">Nama Pegawai</th>
                
              <th class="text-center" colspan="' . $jumlahhari . '">' . $month_en . '</th>
              <th class="text-center" colspan="5">Keterangan</th>
            </tr>
            <tr>';
            $sum = 0;
            $libur = 0;
            for ($d = 1; $d <= $jumlahhari; $d++) {
                $warna      = '';
                $background = '';
                if (date("l", mktime(0, 0, 0, $bulan, $d, $tahun)) == "Saturday" or date("l", mktime(0, 0, 0, $bulan, $d, $tahun)) == "Sunday") {
                    $warna = 'color:white';
                    $background = 'background:#FF0000';
                    $sum++;
                    $status_hadir = 'Libur';
                } else {
                    $date_month_year = '' . $year . '-' . $bulan . '-' . $d . '';
                    $query_holiday = "SELECT holiday_id FROM holiday WHERE holiday_date='$date_month_year'";
                    $result_holiday = $connection->query($query_holiday);
                    if ($result_holiday->num_rows > 0) {
                        $warna = 'color:white';
                        $background = 'background:#FF0000';
                        $libur++;
                        $status_hadir = 'Lembur';
                    }
                }

                echo '
              <th width="50" class="text-center" style="' . $warna . '; ' . $background . '">' . $d . '</th>';
            }
            echo '
            <th width="50" class="text-center">H</th>
            <th width="50" class="text-center">T</th>
            <th width="50" class="text-center">I</th>
            <th width="50" class="text-center">A</th>
            <th width="50" class="text-center">S</th>
            </tr>
          </thead>
          <tbody>';


            $query = "SELECT employees.employees_code,employees.id,employees.employees_name,position.position_name,shift.shift_name FROM employees INNER JOIN position ON employees.position_id = position.position_id INNER JOIN shift ON employees.shift_id = shift.shift_id  $filter_employees ORDER BY employees.id ASC LIMIT ".$limit." OFFSET ".$offset;

            $result = $connection->query($query);
            $no = 0;

            while ($row = $result->fetch_assoc()) {
                $no++;
                echo '
            <tr>
              <td rowspan="2">' . $no . '</td>
               <td rowspan="2">' . $row['employees_code'] . '</td>
                <td rowspan="2">' . $row['shift_name'] . '</td>
                <td rowspan="2" class="text-center">' . $row['position_name'] . '</td>
              <td rowspan="2" width="150">' . $row['employees_name'] . '</td>
              
              <td width="60">Masuk</td>';
                for ($d = 1; $d <= $jumlahhari; $d++) {
                    $date_month_year = '' . $year . '-' . $bulan . '-' . $d . '';
                    if (isset($_POST['month']) or isset($_POST['year'])) {
                        $month = $_POST['month'];
                        $year  = $_POST['year'];
                        $filter = "presence_date='$date_month_year' AND MONTH(presence_date)='$month' AND year(presence_date)='$year'";
                    } else {
                        $filter = "presence_date='$date_month_year' AND MONTH(presence_date) ='$month'";
                    }

                    $query_absen = "SELECT time_in,time_out FROM presence WHERE $filter AND employees_id='$row[id]' ORDER BY presence_id DESC";
                    $result_absen = $connection->query($query_absen);
                    $row_absen = $result_absen->fetch_assoc();
                    if ($row_absen['time_in'] == NULL) {
                        $jam_masuk = '<span class="text-red"><i class="fa fa-times" aria-hidden="true"></i></span>';
                    } else {
                        $jam_masuk = $row_absen['time_in'];
                    }
                    echo '
                <td class="text-center">' . $jam_masuk . '</td>';
                }

                if (isset($_POST['month']) or isset($_POST['year'])) {
                    $month = $_POST['month'];
                    $year  = $_POST['year'];
                    $filter = "MONTH(presence_date)='$month' AND year(presence_date)='$year'";
                } else {
                    $filter = "MONTH(presence_date)='$month' AND year(presence_date)='$year'";
                }

                $query_alpha = "SELECT presence_id FROM presence WHERE $filter AND employees_id='$row[id]'";
                $alpha = $connection->query($query_alpha);
                $alpha = $jumlahhari - $alpha->num_rows - $sum - $libur;

                $query_hadir = "SELECT presence_id FROM presence WHERE $filter AND present_id='1' and employees_id='$row[id]' ORDER BY presence_id DESC";
                $hadir = $connection->query($query_hadir);

                $query_sakit = "SELECT presence_id FROM presence WHERE $filter AND employees_id='$row[id]' and present_id='2'";
                $sakit = $connection->query($query_sakit);

                $query_izin = "SELECT presence_id FROM presence WHERE $filter AND employees_id='$row[id]' and present_id='3'";
                $izin = $connection->query($query_izin);
                $query_telat = "SELECT presence_id FROM presence WHERE $filter AND employees_id='$row[id]' AND time_in>'$shift_time_in'";
                $telat = $connection->query($query_telat);

                echo '
             <th width="50" rowspan="2" class="text-center">' . $hadir->num_rows . '</th>
              <th width="50" rowspan="2" class="text-center">' . $telat->num_rows . '</th>
            <th width="50" rowspan="2" class="text-center">' . $izin->num_rows . '</th>
            <th width="50" rowspan="2" class="text-center">' . $alpha . '</th>
            <th width="50" rowspan="2" class="text-center">' . $sakit->num_rows . '</th>
            </tr>
            <tr>
              <td width="60">Pulang</td>';
                for ($d = 1; $d <= $jumlahhari; $d++) {
                    $date_month_year = '' . $year . '-' . $bulan . '-' . $d . '';
                    if (isset($_POST['month']) or isset($_POST['year'])) {
                        $month = $_POST['month'];
                        $year  = $_POST['year'];
                        $filter = "presence_date='$date_month_year' AND MONTH(presence_date)='$month' AND year(presence_date)='$year'";
                    } else {
                        $filter = "presence_date='$date_month_year' AND MONTH(presence_date) ='$month'";
                    }

                    $query_absen = "SELECT time_in,time_out FROM presence WHERE $filter AND employees_id='$row[id]' ORDER BY presence_id DESC";
                    $result_absen = $connection->query($query_absen);
                    $row_absen = $result_absen->fetch_assoc();
                    if ($row_absen['time_in'] == NULL) {
                        $jam_pulang = '<span class="text-red"><i class="fa fa-times" aria-hidden="true"></i></span>';
                    } else {
                        $jam_pulang = $row_absen['time_out'];
                    }
                    echo '
                <td class="text-center">' . $jam_pulang . '</td>';
                }
                echo '
            </tr>';
            }
            echo '
          </tbody>
          </table>


        <div>';

            $query = "SELECT employees.id FROM employees INNER JOIN position ON employees.position_id = position.position_id INNER JOIN shift ON employees.shift_id = shift.shift_id  $filter_employees ORDER BY employees.id ASC";

            $result = $connection->query($query);

            if($result->num_rows > 1){
                $pagination = '<nav aria-label="Page navigation">
            <ul class="pagination">
                <li '.($page == 1 ? 'class="disabled"':'').'>
                <a href="#" aria-label="Previous" '.($page == 1 ? '':'class="paging" data-page="'.($page-1)).'>
                    <span aria-hidden="true">&laquo;</span>
                </a>
                </li>';
    
                for ($i = 1; $i <= ceil($result->num_rows / 100); $i++) {
                    $pagination .= '<li class="'.($page == $i ? 'active':'').'"><a href="#" data-page="'.$i.'" class="paging">' . $i . '</a></li>';
                }
                $pagination .= '
                <li '.($page ==  ceil($result->num_rows / 100) ? 'class="disabled"':'').'>
                <a href="#" aria-label="Next" '.($page ==  ceil($result->num_rows / 100) ? '':'class="paging" data-page="'.($page+1)).'>
                    <span aria-hidden="true">&raquo;</span>
                </a>
                </li>
            </ul>
            </nav>';
    
    
                echo $pagination;

            }



            break;
    }
}
