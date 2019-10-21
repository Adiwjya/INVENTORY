<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" navigation-header">
                <span>General</span><i class=" ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="General"></i>
            </li>
            <?php
            $namaclass = $this->uri->segment(1);
            ?>
            <li class="nav-item">
                <a href="index.html"><i class="ft-home"></i><span class="menu-title" data-i18n="">Dashboard</span>
                    <!--<span class="badge badge badge-primary badge-pill float-right mr-2">3</span>-->
                </a>
                <ul class="menu-content">
                    <li <?php if($namaclass == "home"){ echo 'class="active"'; } ?>><a class="menu-item" href="<?php echo base_url(); ?>home">Home</a></li>
                    <li <?php if($namaclass == "changepass"){ echo 'class="active"'; } ?>><a class="menu-item" href="<?php echo base_url(); ?>changepass">Change Password</a></li>
                </ul>
            </li>
            <li class="nav-item"><a href="#"><i class="ft-edit"></i><span class="menu-title" data-i18n="">Master</span></a>
                <ul class="menu-content">
                    <li <?php if($namaclass == "pangkat"){ echo 'class="active"'; } ?>><a class="menu-item" href="<?php echo base_url(); ?>pangkat">Pangkat</a></li>
                    <li <?php if($namaclass == "anggota"){ echo 'class="active"'; } ?>><a class="menu-item" href="<?php echo base_url(); ?>anggota">Anggota</a></li>
                    <li <?php if($namaclass == "kategori"){ echo 'class="active"'; } ?>><a class="menu-item" href="<?php echo base_url(); ?>kategori">Kategori</a></li>
                    <li <?php if($namaclass == "barang"){ echo 'class="active"'; } ?>><a class="menu-item" href="<?php echo base_url(); ?>barang">Barang</a></li>
                </ul>
            </li>
            <li class="nav-item"><a href="#"><i class="ft-grid"></i><span class="menu-title" data-i18n="">Transaksi</span></a>
                <ul class="menu-content">
                    <li <?php if($namaclass == "barangmasuk"){ echo 'class="active"'; } ?>><a class="menu-item" href="<?php echo base_url(); ?>barangmasuk">Barang Masuk</a></li>
                    <li <?php if($namaclass == "barangkeluar"){ echo 'class="active"'; } ?>><a class="menu-item" href="<?php echo base_url(); ?>barangkeluar">Barang Keluar</a></li>
                </ul>
            </li>
            <li class="nav-item"><a href="#"><i class="ft-bar-chart-2"></i><span class="menu-title" data-i18n="">Laporan</span></a>
                <ul class="menu-content">
                    <li <?php if($namaclass == "lapbm"){ echo 'class="active"'; } ?>><a class="menu-item" href="<?php echo base_url(); ?>lapbm">Barang Masuk</a></li>
                    <li <?php if($namaclass == "lapbk"){ echo 'class="active"'; } ?>><a class="menu-item" href="<?php echo base_url(); ?>lapbk">Barang Keluar</a></li>
                    <li <?php if($namaclass == "lapstok"){ echo 'class="active"'; } ?>><a class="menu-item" href="<?php echo base_url(); ?>lapstok">Stok</a></li>
                    <li <?php if($namaclass == "lapbarcode"){ echo 'class="active"'; } ?>><a class="menu-item" href="<?php echo base_url(); ?>lapbarcode">Barcode</a></li>
                </ul>
            </li>
        </ul>
    </div>
  </div>