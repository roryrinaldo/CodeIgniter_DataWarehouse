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
            <h1 class="m-0">Management User</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="mb-3">
            <a href="<?php echo base_url('user/create_user'); ?>" class="btn btn-primary">Tambah User</a>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama User</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Level</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $key => $user) : ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $user['nama_user']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['password']; ?></td>
                            <td>
                            <?php
                                if ($user['level'] == 0) {
                                echo 'Admin';
                                } else {
                                echo 'User';
                                }
                            ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url('user/edit_user/'.$user['id_user']); ?>" class="btn btn-sm btn-success">Edit</a>
                                <a href="<?php echo base_url('user/delete_user/'.$user['id_user']); ?>" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          
        </div>
        <!-- /.row (main row) -->

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    
  </div>
  <!-- /.content-wrapper -->

  <?php echo view('layout/footer.php'); ?>

 
</div>
<!-- ./wrapper -->

<?php echo view('layout/javascript.php'); ?>

</body>
</html>
