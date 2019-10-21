<script type="text/javascript"> 
    
    var save_method; //for save method string
    var table;
    var tbbarang;
    
    $(document).ready(function() {
        table = $('#tb').DataTable( {
            ajax: "<?php echo base_url(); ?>barangkeluar/ajax_list_detil/<?php echo $kode; ?>"
        });

        $('.datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true 
        });
    });
    
    function reload(){
        table.ajax.reload(null,false); //reload datatable ajax
    }
    
    function add(){
        var idanggota = document.getElementById('idanggota').value;
        if(idanggota === ''){
            alert("Anggota tidak boleh kosong");
        }else{
            save_method = 'add';
            
            $('[name="nama_barang"]').val("");
            $('[name="ukuran"]').val("");
            $('[name="kategori"]').val("");
            $('[name="jumlah"]').val("");
            $('[name="stok"]').val("");

            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Tambah Barang Keluar'); // Set Title to Bootstrap modal title
        }
        
    }
    
    function save(){
        var jumlah = document.getElementById('jumlah').value;
        var stok = document.getElementById('stok').value;
        var kode_barang = document.getElementById('kode_barang').value;
        
        if(kode_barang === ''){
            alert("Kode barang tidak boleh kosong");
        }else if(jumlah === ''){
            alert("Jumlah tidak boleh kosong");
        }else{
            var a = parseInt(stok);
            var b = parseInt(jumlah);
            
            if(b > a){
                alert("Jumlah melebih stok");
            }else{
                $('#btnSave').text('Saving...'); //change button text
                $('#btnSave').attr('disabled',true); //set button disable 

                var url;
                if(save_method === 'add') {
                    url = "<?php echo base_url(); ?>barangkeluar/ajax_add";
                } else {
                    url = "<?php echo base_url(); ?>barangkeluar/ajax_edit";
                }

                // ajax adding data to database
                var kode_trans = document.getElementById('kode').value;
                var tanggal = document.getElementById('tanggal').value;
                var anggota = document.getElementById('idanggota').value;
                var kode_barang = document.getElementById('kode_barang').value;
                var jumlah = document.getElementById('jumlah').value;
                var kode_detil = document.getElementById('kode_detil').value;

                // ajax adding data to database
                var form_data = new FormData();
                form_data.append('idbk', kode_trans);
                form_data.append('tanggal', tanggal);
                form_data.append('idanggota', anggota);
                form_data.append('kode_barang', kode_barang);
                form_data.append('jumlah', jumlah);
                form_data.append('kode_detil', kode_detil);

                $.ajax({
                    url: url,
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'POST',
                    success: function (response) {
                        alert(response.status);
                        reload();

                        $('#btnSave').text('Save'); //change button text
                        $('#btnSave').attr('disabled',false); //set button enable 

                        $('#modal_form').modal('hide');

                    },error: function (response) {
                        alert(response.status);
                        $('#btnSave').text('Save'); //change button text
                        $('#btnSave').attr('disabled',false); //set button enable 
                    }
                });
            }
        }
    }
    
    function hapus(id, nama){
        if(confirm("Apakah anda yakin menghapus barang " + nama + " ?")){
            // ajax delete data to database
            $.ajax({
                url : "<?php echo base_url(); ?>barangkeluar/hapusdetil/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data){
                    alert(data.status);
                    reload();
                },error: function (jqXHR, textStatus, errorThrown){
                    alert('Error hapus data');
                }
            });
        }
    }
    
    function ganti(id){
        save_method = 'update';
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Ganti Barang Keluar'); // Set title to Bootstrap modal title
        
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo base_url(); ?>barangkeluar/ganti/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                $('[name="id"]').val(data.idbk_detil);
                $('[name="kode_barang"]').val(data.idbarang);
                $('[name="nama_barang"]').val(data.nama_barang);
                $('[name="ukuran"]').val(data.ukuran);
                $('[name="kategori"]').val(data.nama_kategori);
                $('[name="jumlah"]').val(data.jumlah);
                
                // get stok bahan baku
                $.ajax({
                    url : "<?php echo base_url(); ?>barangkeluar/getStok/" + data.idbarang,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data){
                        $('[name="stok"]').val(data.status);
                    },error: function (jqXHR, textStatus, errorThrown){
                        alert('Error get data stok');
                    }
                });
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Error get data');
            }
        });
    }
    
    function showbarang(){
        $('#modal_barang').modal('show'); // show bootstrap modal
        tbbarang = $('#tbbarang').DataTable( {
            ajax: "<?php echo base_url(); ?>barangkeluar/ajax_barang",
            retrieve:true
        });
        tbbarang.destroy();
        tbbarang = $('#tbbarang').DataTable( {
            ajax: "<?php echo base_url(); ?>barangkeluar/ajax_barang",
            retrieve:true
        });
    }

    function showanggota(){
        $('#modal_anggota').modal('show'); // show bootstrap modal
        tbbarang = $('#tbanggota').DataTable( {
            ajax: "<?php echo base_url(); ?>barangkeluar/ajax_anggota",
            retrieve:true
        });
        tbbarang.destroy();
        tbbarang = $('#tbanggota').DataTable( {
            ajax: "<?php echo base_url(); ?>barangkeluar/ajax_anggota",
            retrieve:true
        });
    }
    
    function pilih(kode, nama, ukuran, nama_kategori){
        $('[name="kode_barang"]').val(kode);
        $('[name="nama_barang"]').val(nama);
        $('[name="ukuran"]').val(ukuran);
        $('[name="kategori"]').val(nama_kategori);
        // get stok bahan baku
        $.ajax({
            url : "<?php echo base_url(); ?>barangkeluar/getStok/" + kode,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                $('[name="stok"]').val(data.status);
            },error: function (jqXHR, textStatus, errorThrown){
                alert('Error get data stok');
            }
        });
        
        $('#modal_barang').modal('hide');
    }

    function pilih_anggota(kode, nrp, nama){
        $('[name="idanggota"]').val(kode);
        $('[name="anggota"]').val(nama);
        
        $('#modal_anggota').modal('hide');
    }
    
</script>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body">
            
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Transaksi Barang Keluar</h4>
                            <div class="float-right">
                                
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="form-horizontal">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="text-align: right;">Kode</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" placeholder="Kode Barang Keluar" readonly="" name="kode" id="kode" value="<?php echo $kode; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-horizontal">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="text-align: right;">Tanggal</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" placeholder="Tanggal" readonly="" name="tanggal" id="tanggal" value="<?php echo $tanggal; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-horizontal">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="text-align: right;">Anggota</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <input type="hidden" name="idanggota" id="idanggota" value="<?php echo $idanggota; ?>">
                                                    <input type="text" class="form-control" placeholder="Anggota" name="anggota" id="anggota" value="<?php echo $namaanggota; ?>" readonly="">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button" onclick="showanggota()">...</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <button class="btn btn-md btn-primary" onclick="add();"><i class="ft-plus"></i> Barang</button>
                                    <button class="btn btn-md btn-default" onclick="reload();"><i class="ft-repeat"></i> Reload</button>
                                </div>
                                <div class="clearfix"></div><br>
                                <div class="table-responsive">
                                    <table id="tb" class="table table-hover mb-0 ps-container ps-theme-default" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Ukuran</th>
                                                <th>Kategori</th>
                                                <th>Jumlah</th>
                                                <th style="text-align: center;">Aksi</th>
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
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Anggota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <input type="hidden" name="id" id="kode_detil">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" style="text-align: right;">Nama Barang</label>
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
                            <input type="text" class="form-control" name="ukuran" placeholder="Ukuran" readonly="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" style="text-align: right;">Kategori</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="kategori" placeholder="kategori" readonly="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" style="text-align: right;">Stok</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="stok" id="stok" placeholder="Stok" readonly="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" style="text-align: right;">Jumlah</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" onkeypress="return hanyaAngka(event,false);" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnSave" type="button" class="btn btn-primary" onclick="save();">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- modal -->

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

<!-- Modal list barang -->
<div class="modal fade" id="modal_anggota" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Anggota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="table-responsive">
                        <table id="tbanggota" class="table table-hover mb-0 ps-container ps-theme-default" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Aksi</th>
                                    <th>NRP</th>
                                    <th>Nama</th>
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