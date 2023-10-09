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
            <h1 class="m-0">Data Store</h1>
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
        <div class="row">
          <div class="col-4">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Upload File</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="<?php echo base_url('data/import'); ?>" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="excel_file">Excel File</label>
                    <input type="file" name="excel_file" class="form-control-file">
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">Upload</button>
                  </div>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Table -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Table Data</h3>
                <div class="float-right">
                    <button class="btn btn-danger" id="clearDataBtn">Clear Data</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Waktu</th>
                        <th>Staf</th>
                        <th>Produk</th>
                        <th>Sektor Usaha</th>
                        <th>Bank</th>
                        <th>Cabang</th>
                        <th>Unit</th>
                        <th>Nama Nasabah</th>
                        <th>Penyebab Klaim</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $nomor = 1; ?>
                      <?php foreach ($records as $key => $record) : 
                      ?>
                        <tr>
                          <td><?php echo $nomor++; ?></td>
                          <td><?php echo $record['waktu']; ?></td>
                          <td><?php echo $record['staf']; ?></td>
                          <td><?php echo $record['produk']; ?></td>
                          <td><?php echo $record['sektor_usaha']; ?></td>
                          <td><?php echo $record['bank']; ?></td>
                          <td><?php echo $record['cabang']; ?></td>
                          <td><?php echo $record['unit']; ?></td>
                          <td><?php echo $record['nama_nasabah']; ?></td>
                          <td><?php echo $record['penyebab_klaim']; ?></td>
                          <td><?php echo $record['status']; ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
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
