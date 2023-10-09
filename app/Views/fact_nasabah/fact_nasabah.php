<!DOCTYPE html>
<html lang="en">

<?php echo view('layout/header.php'); ?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?= base_url('adminlte/dist/img/AdminLTELogo.png') ?>" alt="AdminLTELogo" height="60" width="60">
  </div> -->

  <?php echo view('layout/navbar.php'); ?>

  <?php echo view('layout/side_menu.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Fact Nasabah</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Table -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Table Fact Nasabah</h3>
              </div>
              <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Fact</th>
                            <th>ID Waktu</th>
                            <th>ID Staf</th>
                            <th>ID Produk</th>
                            <th>ID Sektor Usaha</th>
                            <th>ID Bank</th>
                            <th>ID Cabang</th>
                            <th>ID Penyebab Klaim</th>
                            <th>ID Status</th>
                            <th>Jumlah Nasabah</th>
                            <th>Persentase Nasabah (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fact_nasabah as $row) : ?>
                            <tr>
                                <td><?= $row['id_fact']; ?></td>
                                <td><?= $row['id_waktu']; ?></td>
                                <td><?= $row['id_staf']; ?></td>
                                <td><?= $row['id_produk']; ?></td>
                                <td><?= $row['id_sektor_usaha']; ?></td>
                                <td><?= $row['id_bank']; ?></td>
                                <td><?= $row['id_cabang']; ?></td>
                                <td><?= $row['id_penyebab_klaim']; ?></td>
                                <td><?= $row['id_status']; ?></td>
                                <td><?= $row['jumlah_nasabah']; ?></td>
                                <td><?= $row['persentase_nasabah']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php echo view('layout/footer.php'); ?>

 
</div>
<!-- ./wrapper -->

<?php echo view('layout/javascript.php'); ?>

<script>
  document.getElementById('clearDataBtn').addEventListener('click', function() {
    if (confirm('Apakah Anda yakin ingin menghapus semua data?')) {
      window.location.href = "<?php echo base_url('data/clear'); ?>";
    }
  });
</script>

</body>
</html>
