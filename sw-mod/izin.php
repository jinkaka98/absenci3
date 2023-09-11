<?php 
if ($mod ==''){
    header('location:../404');
    echo'kosong';
}else{
    include_once 'sw-mod/sw-header.php';
if(!isset($_COOKIE['COOKIES_MEMBER']) && !isset($_COOKIE['COOKIES_COOKIES'])){
        setcookie('COOKIES_MEMBER', '', 0, '/');
        setcookie('COOKIES_COOKIES', '', 0, '/');
        // Login tidak ditemukan
        setcookie("COOKIES_MEMBER", "", time()-$expired_cookie);
        setcookie("COOKIES_COOKIES", "", time()-$expired_cookie);
        session_destroy();
        header("location:./");
}else{
  echo'<!-- App Capsule -->
    <div id="appCapsule">
    <div class="section mt-2">
    <div class="card">
    <div class="card-body">
        <div class="row text-center">
        <div class="col-sm-4 col-md-4">
            <div class="form-group basic">
                <div class="input-wrapper">
                    <div class="input-group">
                        <input type="text" class="form-control datepicker start_date" name="start_date" placeholder="Tanggal Awal" required>
                        <div class="input-group-addon">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-4  col-md-4">
            <div class="form-group basic">
                <div class="input-wrapper">
                    <div class="input-group">
                        <input type="text" name="end_date" class="form-control datepicker end_date" value="'.tanggal_ind($date).'">
                        <div class="input-group-addon">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </div>
                    </div>

                </div>
            </div> 
        </div>
        <div class="col-sm-4 col-md-4 justify-content-between">
           <button type="button" class="btn btn-danger mt-1 btn-sortir-izin"><ion-icon name="checkmark-outline"></ion-icon>Tampilkan</button>
           <button type="button" class="btn btn-success mt-1 btn-clear-izin"><ion-icon name="repeat-outline"></ion-icon> Clear</button>
           <button type="button" class="btn btn-warning mt-1" data-toggle="modal" data-target="#modal-add"><ion-icon name="add-circle-outline"></ion-icon> Tambah</button>
        </div>

        </div>       
    </div>
    </div>
    </div>

        <div class="section mt-2">
            <div class="section-title">Data Pengajuan Izin</div>
            <div class="card">
                <div class="transactions">
                    <div class="loaddataIzin"></div>
                </div>
            </div>
        </div>
    
        <!-- MODAL ADD -->
        <div class="modal fade modalbox" id="modal-add" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pengajuan Izin Sakit</h5>
                        <a href="javascript:;" data-dismiss="modal">Close</a>
                    </div>
                    <div class="modal-body">
                        <form class="form-add-izin" autocomplete="off">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Nama</label>
                                    <input type="text" class="form-control" name="permission_name" value="'.$row_user['employees_name'].'" readonly required>
                                    <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Mulai</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" name="permission_date" placeholder="'.tanggal_ind($date).'" value="'.tanggal_ind($date).'" required>
                                            <div class="input-group-addon">
                                                <ion-icon name="calendar-outline"></ion-icon>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                             <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Selesai</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" name="permission_date_finish" placeholder="'.tanggal_ind($date).'" value="" required>
                                            <div class="input-group-addon">
                                                <ion-icon name="calendar-outline"></ion-icon>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group basic">
                               <div class="custom-control custom-radio mb-1">
                                    <input type="radio" id="customRadio1" name="type" value="Izin" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio1">Izin</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio2" name="type" value="Sakit" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio2">Sakit</label>
                                </div>
                            </div>

                            <div class="form-group basic upload-izin" style="display:none">
                                    <div class="input-wrapper">
                                        <label class="label">Upload <span class="title-files"></label>
                                        <br>
                                        <div class="upload-media">
                                            <img src="sw-mod/sw-assets/img/media.png" id="output" class="img-responsive" width="100">
                                             <input type="file" class="upload-hidden" name="files" onchange="loadFile(event)" accept=".jpg, .jpeg, ,gif, .png">
                                        </div>

   
                                    </div>
                                    <span class="small">Klik Foto untuk upload, Pasikan Surat yang di Upload dengan Format harus JPG, JPEG, atau biarkan saja jika tidak upload files</span>
                                </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Keterangan</label>
                                   <textarea rows="3" class="form-control permission_description"  name="permission_description" required></textarea>
                                    <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                </div>
                            </div>

                            <div class="form-group basic">
                                <button type="submit" class="btn btn-danger btn-block btn-lg mt-2">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>';

    echo'
    <!-- MODAL EDIT -->
        <div class="modal fade modalbox" id="modal-edit" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Permohonan Izin</h5>
                        <a href="javascript:;" data-dismiss="modal">Close</a>
                    </div>
                    <div class="modal-body">
                        <form class="form-edit-izin" autocomplete="off">
                            <input type="hidden" name="id" id="id" value="" required>
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Nama</label>
                                    <input type="text" class="form-control" id="name" name="permission_name" value="" required>
                                    <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                </div>
                            </div>


                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Tanggal</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker"  id="date" name="permission_date" required>
                                            <div class="input-group-addon">
                                                <ion-icon name="calendar-outline"></ion-icon>
                                            </div>
                                        </div>
                                    </div>
                            </div>


                            <br>
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Upload</label>
                                    <input type="file" class="form-control" name="files" accept=".jpg, .jpeg, .pdf, .docx, .docm">
                                </div>
                                <span class="small text-danger">Pasikan Surat yang di Upload dengan Format harus JPG, JPEG dan PDF</span>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Keterangan</label>
                                   <textarea rows="3" class="form-control permission_description" id="description" name="permission_description" required></textarea>
                                    <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                </div>
                            </div>

                            <div class="form-group basic">
                                <button type="submit" class="btn btn-danger btn-block btn-lg mt-2">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>';

  }
  include_once 'sw-mod/sw-footer.php';
} ?>