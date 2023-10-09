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
            <h1 class="m-0">Dashboard</h1>
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
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $numCustomers ?></h3>

                <p>Total Nasabah</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $numYears ?></h3>

                <p>Total Tahun</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $numStafs ?></h3>

                <p>Total Staf</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $numBanks ?></h3>

                <p>Total Bank</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          <div class="col-md-8" >
            <!-- Bar Chart -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Daftar Staf Teratas Dengan Jumlah Nasabah Terbanyak</h3>
              </div>
              <div class="card-body">
                <div class="chart-container" style="position: relative;">
                  <canvas id="topStafsChart"></canvas>
                  <div class="chart-buttons">
                    <button onclick="changeChartType('bar')">
                      <i class="fas fa-chart-bar"></i>
                    </button>
                    <button onclick="changeChartType('line')">
                      <i class="fas fa-chart-line"></i>
                    </button>
                    <button onclick="downloadChart()">
                      <i class="fas fa-download"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4" >
            <!-- Button filter (if you want to add any filtering options) -->

            <!-- Bar Chart -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Persentase Nasabah Berdasarkan Status</h3>
              </div>
              <div class="card-body">
                <canvas id="statusPieChart"></canvas>
                
              </div>
            </div>
       
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-12" >
            <!-- Bar Chart -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Daftar Bank Dengan Jumlah Nasabah Terbanyak</h3>
              </div>
              <div class="card-body">
                <div class="chart-container" style="position: relative;">
                  <canvas id="topBanksChart"></canvas>
                  <div class="chart-buttons">
                    <button onclick="changeChartType('bar')">
                      <i class="fas fa-chart-bar"></i>
                    </button>
                    <button onclick="changeChartType('line')">
                      <i class="fas fa-chart-line"></i>
                    </button>
                    <button onclick="downloadChart()">
                      <i class="fas fa-download"></i>
                    </button>
                  </div>
                </div>
              </div>
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

<!-- Add your JavaScript code to create the bar chart using the data from the 'topStafs' variable -->
<script>
  var topStafsData = <?php echo json_encode($topStafs); ?>;
  var stafsLabels = topStafsData.map(function(item) {
    return item.staf;
  });
  var jumlahNasabahData = topStafsData.map(function(item) {
    return item.total_nasabah;
  });

  // Initialize the bar chart
  var topStafsChart = new Chart(document.getElementById('topStafsChart'), {
    type: 'bar',
    data: {
      labels: stafsLabels,
      datasets: [{
        label: 'Jumlah Nasabah',
        backgroundColor: ['rgba(60,141,188,0.9)',
                          'rgba(63,191,63,0.9)',
                          'rgba(219,62,29,0.9)',
                          'rgba(255,150,64,0.9)',
                          'rgba(128,0,128,0.9)',
                          'rgba(0,139,139,0.9)',
                          'rgba(255,99,71,0.9)',
                          'rgba(30,144,255,0.9)',
                          'rgba(255,215,0,0.9)',
                          'rgba(139,69,19,0.9)'],
        borderColor: 'rgba(60,141,188,0.8)',
        borderWidth: 1,
        data: jumlahNasabahData
      }]
    },
    options: {
      responsive: true,
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
    }
  });

  // Function to change the chart type
  function changeChartType(chartType) {
    topStafsChart.config.type = chartType;
    topStafsChart.update();
  }

  // Function to download the chart as an image
  function downloadChart() {
    var imageURI = topStafsChart.toBase64Image('image/png');
    var downloadLink = document.createElement('a');
    downloadLink.href = imageURI;
    downloadLink.download = 'chart.png';
    downloadLink.click();
  }
</script>

<!-- Add your JavaScript code to create the pie chart using the data from the 'statusData' variable -->
<script>
  $(function() {
    var statusData = <?php echo json_encode($statusData); ?>;

    var statusLabels = statusData.map(function(item) {
      return item.status;
    });

    var statusCount = statusData.map(function(item) {
      return item.count;
    });

    var statusPieChart = new Chart($('#statusPieChart'), {
      type: 'pie',
      data: {
        labels: statusLabels,
        datasets: [{
          data: statusCount,
          backgroundColor: [
            '#28a745', // Green
            '#dc3545', // Red
          ],
          borderWidth: 1,
        }]
      },
      options: {
        responsive: true,
        legend: {
          position: 'right'
        }
        
      }
    });
  });
</script>


<!-- Add your JavaScript code to create the bar chart using the data from the 'topBanks' variable -->
<script>
  var topBanksData = <?php echo json_encode($topBanks); ?>;
  var banksLabels = topBanksData.map(function(item) {
    return item.bank;
  });
  var jumlahNasabahData = topBanksData.map(function(item) {
    return item.total_nasabah;
  });
  
  // Initialize the bar chart
  var topBanksChart = new Chart(document.getElementById('topBanksChart'), {
    type: 'bar',
    data: {
      labels: banksLabels,
      datasets: [{
        label: 'Jumlah Nasabah',
        backgroundColor: ['rgba(60,141,188,0.9)',
                          'rgba(63,191,63,0.9)',
                          'rgba(219,62,29,0.9)',
                          'rgba(255,150,64,0.9)',
                          'rgba(128,0,128,0.9)',
                          'rgba(0,139,139,0.9)',
                          'rgba(255,99,71,0.9)',
                          'rgba(30,144,255,0.9)',
                          'rgba(255,215,0,0.9)',
                          'rgba(139,69,19,0.9)'],
        borderColor: 'rgba(60,141,188,0.8)',
        borderWidth: 1,
        data: jumlahNasabahData
      }]
    },
    options: {
      responsive: true,
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
            text: 'X : Nama Bank',
            font: {
              weight: 'bold'
            }
          }
        }
      }
    }
  });

  // Function to change the chart type
  function changeChartType(chartType) {
    topBanksChart.config.type = chartType;
    topBanksChart.update();
  }

  // Function to download the chart as an image
  function downloadChart() {
    var imageURI = topBanksChart.toBase64Image('image/png');
    var downloadLink = document.createElement('a');
    downloadLink.href = imageURI;
    downloadLink.download = 'chart.png';
    downloadLink.click();
  }
</script>

</body>
</html>
