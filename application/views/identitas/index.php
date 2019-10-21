<script type="text/javascript"> 
    
    $(document).ready(function() {
        $('.datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "bottom auto",
            todayBtn: true 
        });
    });
    
    function save(){
        $('#btnSave').text('Saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        
        // ajax adding data to database
        $.ajax({
            url : "<?php echo base_url(); ?>profile/proses",
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                alert(data.status);
                    
                $('#btnSave').text('Save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
                
                window.location.href = "<?php echo base_url(); ?>profile";
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert("Error json " + errorThrown);
                
                $('#btnSave').text('Save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            }
        });
    }
    
</script>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body">
            <!-- Stats -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Identitas</h4>
                            <div class="float-right">
                                
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <form id="form" class="form-horizontal">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" style="text-align: right;">Nama Instansi</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="nama_instansi" placeholder="Nama Instansi" value="<?php echo $saya->nama_instansi; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" style="text-align: right;">Alamat</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="alamat" placeholder="Alamat" value="<?php echo $saya->alamat; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" style="text-align: right;">Kode POS</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="kode_pos" placeholder="Kode POS" value="<?php echo $saya->kode_pos; ?>" onkeypress="return hanyaAngka(event,false);">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" style="text-align: right;">No Telepon</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="no_telpon" placeholder="No Telepon" value="<?php echo $saya->no_telpon ?>" onkeypress="return hanyaAngka(event,false);">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" style="text-align: right;">Kelurahan</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="kelurahan" placeholder="Kelurahan" value="<?php echo $saya->kelurahan; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" style="text-align: right;">Kecamatan</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="kecamatan" placeholder="Kecamatan" value="<?php echo $saya->kecamatan; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" style="text-align: right;">Kota</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="kota" placeholder="Kota" value="<?php echo $saya->kota; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" style="text-align: right;">Provinsi</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="provinsi" placeholder="Provinsi" value="<?php echo $saya->provinsi; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" style="text-align: right;">Website</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="website" placeholder="Website" value="<?php echo $saya->website; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" style="text-align: right;">Email</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $saya->email; ?>">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button id="btnSave" class="btn btn-md btn-primary" onclick="save();"><i class="ft-save"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>