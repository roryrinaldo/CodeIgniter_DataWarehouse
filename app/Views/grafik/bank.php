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
            <h1 class="m-0">Grafik Bank</h1>
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
        <!-- Small boxes (Stat box) -->
        <div class="row">

          <!-- Year selection -->
            <div class="col-md-3">
              <div class="form-group">
                <label for="year">Pilih Tahun:</label>
                <select id="year" class="form-control">
                  <?php foreach ($years as $year) : ?>
                    <option value="<?= $year->id_waktu ?>"><?= $year->waktu ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="bank">Pilih Bank:</label>
                <select id="bank" class="form-control">
                  <?php foreach ($banks as $bank) : ?>
                    <option value="<?= $bank->id_bank ?>"><?= $bank->bank ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="submit-btn">&nbsp;</label>
                <button id="submit-btn" class="btn btn-primary form-control">Tampilkan Grafik</button>
              </div>
            </div>
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          <div class="col-md-12">
          <!-- BAR CHART -->
          <div class="card card-light">
              <div class="card-header">
                <h3 class="card-title">Bar Chart</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 400px; height: 250px; max-height: 400px; max-width: 100%;"></canvas>
                
                </div>
              </div>
              <!-- /.card-body -->
          </div>
          </div>
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


<script>
  $(function () {
    // Fungsi untuk memperbarui grafik berdasarkan tahun dan bank yang dipilih
    function updateChart(year, bank) {
      // Ganti URL di bawah ini sesuai dengan URL untuk mengambil data grafik dari server
      var dataURL = '<?= base_url('grafik/getDataBank/') ?>' + year + '/' + bank;

      // Gunakan AJAX untuk mengambil data grafik dari server
      $.ajax({
        url: dataURL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
          // Perbarui data dan label pada grafik
          bankChartData.labels = data.bankLabels;
          bankChartData.datasets[0].data = data.bankData;

          // Jika grafik sudah diinisialisasi sebelumnya, hapus grafik sebelum membuat yang baru
          if (bankChart) {
            bankChart.destroy();
          }
          
          // Inisialisasi grafik baru
          bankChart = new Chart(bankChartCanvas, {
            type: 'bar',
            data: bankChartData,
            options: bankChartOptions
          });
          
          
          // Tampilkan pesan di konsol browser
          console.log('Grafik diperbarui dengan data tahun: ' + year + ', bank: ' + bank);
        },
        error: function (xhr, status, error) {
          console.error('Error retrieving data: ' + error);
        }
      });
    }

    
    // Handler untuk tombol "Tampilkan Grafik"
    $('#submit-btn').on('click', function () {
      var selectedYear = $('#year').val();
      var selectedBank = $('#bank').val();
      updateChart(selectedYear, selectedBank);
    });

    // Inisialisasi data untuk grafik
    var bankChartCanvas = $('#barChart').get(0).getContext('2d');
    var bankChartData = {
      labels  : [],
      datasets: [
        {
          label               : 'Jumlah Nasabah',
          backgroundColor     :  ['rgba(60,141,188,0.9)',
                                  'rgba(63,191,63,0.9)',
                                  'rgba(219,62,29,0.9)',
                                  'rgba(255,150,64,0.9)',
                                  'rgba(128,0,128,0.9)',
                                  'rgba(0,139,139,0.9)',
                                  'rgba(255,99,71,0.9)',
                                  'rgba(30,144,255,0.9)',
                                  'rgba(255,215,0,0.9)',
                                  'rgba(139,69,19,0.9)'],
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius         : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : []
        }
      ]
    };
    
    var bankChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false,
      scales: {
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Y = Jumlah Nasabah',
            font: {
              weight: 'bold'
            }
          }
        },
        x: {
          title: {
            display: true,
            text: 'X : Nama Staf',
            font: {
              weight: 'bold'
            }
          }
        }
      }
    };

    // Inisialisasi grafik
    var bankChart = new Chart(bankChartCanvas, {
      type: 'bar',
      data: bankChartData,
      options: bankChartOptions
    });

    
  });

  
</script>

</body>
</html>
