<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
    </div>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Bulan/Tahun</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Hadir</th>
            <th>Sakit</th>
            <th>Izin</th>
        </tr>

        

        <?php foreach($absensi as $a) : ?>
        <tr>
            <td><?php echo $a->bulan ?></td>
            <td><?php echo $a->nama_pegawai ?></td>
            <td><?php echo $a->nama_jabatan ?></td>
            <td><?php echo number_format($a->hadir) ?></td>
            <td><?php echo number_format($a->sakit) ?></td>
            <td><?php echo number_format($a->alpha) ?></td>
        </tr>
        <?php endforeach; ?>

</div>


