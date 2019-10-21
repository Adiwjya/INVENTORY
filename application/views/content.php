<script type="text/javascript"> 
    
    var table;
    $(document).ready(function() {
        table = $('#tb').DataTable( {
            ajax: "<?php echo base_url(); ?>home/ajax_list"
        });
    });
    
</script>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body">
            <!-- Stats -->
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="media align-items-stretch">
                                <div class="p-2 text-center bg-primary bg-darken-2">
                                    <i class="icon-grid font-large-2 white"></i>
                                </div>
                                <div class="p-2 bg-gradient-x-primary white media-body">
                                    <h5>Barang</h5>
                                    <h5 class="text-bold-400 mb-0"><i class="ft-check"></i> <?php echo $jmlbarang; ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="media align-items-stretch">
                                <div class="p-2 text-center bg-danger bg-darken-2">
                                    <i class="icon-user font-large-2 white"></i>
                                </div>
                                <div class="p-2 bg-gradient-x-danger white media-body">
                                    <h5>Anggota</h5>
                                    <h5 class="text-bold-400 mb-0"><i class="ft-check"></i> <?php echo $jmlanggota; ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Stats -->
            <!--Recent Orders & Monthly Salse -->
            <div class="row match-height">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <?php
                            date_default_timezone_set("Asia/Jakarta");
                            ?>
                            <h4 class="card-title">Rekam jejak barang keluar hari ini [ <?php echo date('d M Y'); ?> ]</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tb" class="table table-hover mb-0 ps-container ps-theme-default">
                                        <thead>
                                            <tr>
                                                <th>NRP</th>
                                                <th>Anggota</th>
                                                <th>Kategori</th>
                                                <th>Nama Barang</th>
                                                <th>Ukuran</th>
                                                <th>Jumlah Keluar</th>
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
  