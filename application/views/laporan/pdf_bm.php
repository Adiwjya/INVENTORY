<html>
    <head>
        <meta charset="UTF-8">
        <title>INVENTORY</title>
        <style>
            .invoice-box {
                max-width: 900px;
                margin: auto;
                padding: 10px;
                border: 1px solid #eee;
                box-shadow: 0 0 10px rgba(0, 0, 0, .15);
                font-size: 16px;
                line-height: 24px;
                font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
                color: #555;
            }

            .invoice-box table {
                width: 100%;
                line-height: inherit;
                text-align: left;
            }

            .invoice-box table td {
                padding: 5px;
                vertical-align: top;
            }

            .invoice-box table tr td:nth-child(2) {
                text-align: right;
            }

            .invoice-box table tr.top table td {
                padding-bottom: 20px;
            }

            .invoice-box table tr.top table td.title {
                font-size: 45px;
                line-height: 45px;
                color: #333;
            }

            .invoice-box table tr.information table td {
                padding-bottom: 40px;
            }

            .invoice-box table tr.heading td {
                background: #eee;
                border-bottom: 1px solid #ddd;
                font-weight: bold;
            }

            .invoice-box table tr.details td {
                padding-bottom: 20px;
            }

            .invoice-box table tr.item td{
                border-bottom: 1px solid #eee;
            }

            .invoice-box table tr.item.last td {
                border-bottom: none;
            }

            .invoice-box table tr.total td:nth-child(2) {
                border-top: 2px solid #eee;
                font-weight: bold;
            }

            @media only screen and (max-width: 700px) {
                .invoice-box table tr.top table td {
                    width: 100%;
                    display: block;
                    text-align: center;
                }

                .invoice-box table tr.information table td {
                    width: 100%;
                    display: block;
                    text-align: center;
                }
            }

            /** RTL **/
            .rtl {
                direction: rtl;
                font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            }

            .rtl table {
                text-align: right;
            }

            .rtl table tr td:nth-child(2) {
                text-align: left;
            }
        </style>
    </head>
    <body>
        
        <div class="invoice-box">
            <center>
                <h2 style="text-align: center;">Laporan Barang Masuk</h2>
            </center>
            <br>
            <table cellpadding="0" cellspacing="0">
                <tr class="heading">
                    <td style="text-align: center;">Kode</td>
                    <td style="text-align: center;">Tanggal</td>
                    <td style="text-align: center;">Detil</td>
                </tr>
                <?php
                foreach ($list->result() as $row) {
                    ?>
                <tr>
                    <td style="text-align: center;"><?php echo $row->idbm; ?></td>
                    <td style="text-align: center;"><?php echo $row->tanggal; ?></td>
                    <td>
                        <table cellpadding="0" cellspacing="0">
                            <tr class="heading">
                                <td style="text-align: center;">Nama</td>
                                <td style="text-align: center;">Ukuran</td>
                                <td style="text-align: center;">Kategori</td>
                                <td style="text-align: center;">Jumlah</td>
                            </tr>
                            <?php
                            $list1 = $this->Mglobals->getAllQ("SELECT * FROM barang_masuk_detil where idbm = '".$row->idbm."';");
                            foreach ($list1->result() as $row1) {
                                $barang = $this->Mglobals->getAllQR("select nama_barang, ukuran, idkategori from barang where idbarang = '".$row1->idbarang."';");
                                $nama_kategori = $this->Mglobals->getAllQR("select nama_kategori from kategori where idkategori = '".$barang->idkategori."';")->nama_kategori;
                                ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $barang->nama_barang; ?></td>
                                <td style="text-align: center;"><?php echo $barang->ukuran; ?></td>
                                <td style="text-align: center;"><?php echo $nama_kategori; ?></td>
                                <td style="text-align: center;"><?php echo $row1->jumlah; ?></td>
                            </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </td>
                </tr>
                    <?php
                }
                ?>
            </table>
        </div>
        
    </body>
</html>