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
                            <h4 class="card-title">Change Password</h4>
                            <div class="float-right">
                                
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <form id="form" class="form-horizontal">
                                        <input type="hidden" name="id">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" style="text-align: right;">Email</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>" readonly="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" style="text-align: right;">Password Lama</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="oldpass" name="oldpass" placeholder="Password Lama">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" style="text-align: right;">Password Baru</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="newpass" name="newpass" placeholder="Password Baru">
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