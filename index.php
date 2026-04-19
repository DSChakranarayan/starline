<?php $pageTitle = "Dashboard"; ?>
<?php include("header.php"); ?>
<?php include("sidebar.php"); ?>
<?php include("navbar.php"); ?>

  <div class="row g-3">
    <div class="col-md-3">
      <div class="small-box bg-info">
        <h3>150</h3>
        <p>Customers</p>
        <div class="icon"><i class="bi bi-people"></i></div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="small-box bg-success">
        <h3>₹53K</h3>
        <p>Income</p>
        <div class="icon"><i class="bi bi-currency-rupee"></i></div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="small-box bg-warning">
        <h3>44</h3>
        <p>Products</p>
        <div class="icon"><i class="bi bi-box"></i></div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="small-box bg-danger">
        <h3>65</h3>
        <p>Expenses</p>
        <div class="icon"><i class="bi bi-wallet"></i></div>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-md-8">
      <div class="card p-3">
        <h5>Sales Analytics</h5>
        <canvas id="chart"></canvas>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card p-3">
        <h5>Quick Info</h5>
        <p>Total Orders: 320</p>
        <p>Active Users: 150</p>
        <p>Pending Tasks: 12</p>
      </div>
    </div>
  </div>



<?php include("footer.php"); ?>