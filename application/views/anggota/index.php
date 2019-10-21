<script type="text/javascript"> 
    
    var save_method; //for save method string
    var table;
    
    $(document).ready(function() {
        table = $('#tb').DataTable( {
            ajax: "<?php echo base_url(); ?>anggota/ajax_list"
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
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Anggota'); // Set Title to Bootstrap modal title
    }
    
    function save(){
        $('#btnSave').text('Saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        
        var url;
        if(save_method === 'add') {
            url = "<?php echo base_url(); ?>anggota/ajax_add";
        } else {
            url = "<?php echo base_url(); ?>anggota/ajax_edit";
        }
        
        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                alert(data.status);
                $('#modal_form').modal('hide');
                reload();
                    
                $('#btnSave').text('Save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert("Error json " + errorThrown);
                
                $('#btnSave').text('Save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            }
        });
    }
    
    function hapus(id, nrp){
        if(confirm("Apakah anda yakin menghapus anggota dengan NRP " + nrp + " ?")){
            // ajax delete data to database
            $.ajax({
                url : "<?php echo base_url(); ?>anggota/hapus/" + id,
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
        $('#form')[0].reset(); // reset form on modals
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Ganti Anggota'); // Set title to Bootstrap modal title
        
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo base_url(); ?>anggota/ganti/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                $('[name="id"]').val(data.idanggota);
                $('[name="nrp"]').val(data.NRP);
                $('[name="nama"]').val(data.nama);
                $('[name="pangkat"]').val(data.idpangkat);
                $('[name="keterangan"]').val(data.keterangan);
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Error get data');
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
                            <h4 class="card-title">Master Anggota</h4>
                            <div class="float-right">
                                
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <button class="btn btn-md btn-primary" onclick="add();"><i class="ft-plus"></i> Anggota</button>
                                    <button class="btn btn-md btn-default" onclick="reload();"><i class="ft-repeat"></i> Reload</button>
                                </div>
                                <div class="clearfix"></div><br>
                                <div class="table-responsive">
                                    <table id="tb" class="table table-hover mb-0 ps-container ps-theme-default">
                                        <thead>
                                            <tr>
                                                <th>NRP</th>
                                                <th>Nama</th>
                                                <th>Pangkat</th>
                                                <th>Keterangan</th>
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
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" name="id">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" style="text-align: right;">NRP</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nrp" placeholder="NRP">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" style="text-align: right;">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama" placeholder="Nama Anggota">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" style="text-align: right;">Pangkat</label>
                        <div class="col-sm-9">
                            <select name="pangkat" class="form-control">
                                <?php
                                foreach ($pangkat->result() as $row) {
                                    ?>
                                <option value="<?php echo $row->idpangkat; ?>"><?php echo $row->nama_pangkat; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" style="text-align: right;">Keterangan</label>
                        <div class="col-sm-9">
                            <textarea name="keterangan" class="form-control"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSave" type="button" class="btn btn-primary" onclick="save();">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- modal -->