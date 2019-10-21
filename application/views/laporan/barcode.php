<script type="text/javascript"> 
    
    $(document).ready(function() {
        $('.datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true 
        });
    });
    
    function save(){
        var email = document.getElementById('email').value;
        var oldpass = document.getElementById('oldpass').value;
        var newpass = document.getElementById('newpass').value;
        
        if(email === ""){
            alert("Email tidak boleh kosong");
        }else if(oldpass === ""){
            alert("Password lama tidak boleh kosong");
        }else if(newpass === ""){
            alert("Password baru tidak boleh kosong");
        }else{
            $('#btnSave').text('Saving...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable 

            // ajax adding data to database
            $.ajax({
                url : "<?php echo base_url(); ?>changepass/proses",
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data)
                {
                    alert(data.status);
                    
                    $('[name="oldpass"]').val("");
                    $('[name="newpass"]').val("");

                    $('#btnSave').html('<i class="ft-save"></i> Save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
                },
                error: function (jqXHR, textStatus, errorThrown){
                    alert("Error json " + errorThrown);

                    $('#btnSave').text('Save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
                }
            });
        }
    }
    
    function showbarang(){
        $('#modal_barang').modal('show'); // show bootstrap modal
        tbbarang = $('#tbbarang').DataTable( {
            ajax: "<?php echo base_url(); ?>barangmasuk/ajax_barang",
            retrieve:true
        });
        tbbarang.destroy();
        tbbarang = $('#tbbarang').DataTable( {
            ajax: "<?php echo base_url(); ?>barangmasuk/ajax_barang",
            retrieve:true
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
                            <h4 class="card-title">Barcode</h4>
                            <div class="float-right">
                                
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <form id="form" class="form-horizontal">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" style="text-align: right;">Barang</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="hidden" name="kode_barang" id="kode_barang">
                                                    <input type="text" class="form-control" placeholder="Nama Barang" name="nama_barang" readonly="">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button" onclick="showbarang()">...</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" style="text-align: right;">Ukuran</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="ukuran" name="ukuran" placeholder="Ukuran" readonly="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" style="text-align: right;">Jumlah Cetak</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah Cetak">
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

<!-- Modal list barang -->
<div class="modal fade" id="modal_barang" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="table-responsive">
                        <table id="tbbarang" class="table table-hover mb-0 ps-container ps-theme-default" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Aksi</th>
                                    <th>Nama</th>
                                    <th>Ukuran</th>
                                    <th>Kategori</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal -->