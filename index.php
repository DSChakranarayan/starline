<?php $pageTitle = "Dashboard"; ?>
<?php include("header.php"); ?>
<?php include("sidebar.php"); ?>
<?php include("navbar.php"); ?>

<?php

$sql1 = "SELECT SUM(total_amount) AS total_income FROM income";
$result = $conn->query($sql1);

$total = 0;

if ($result && $row = $result->fetch_assoc()) {
    $total = $row['total_income'];
}


$sql2 = "SELECT COUNT(*) AS total_customers FROM customers";
$result = $conn->query($sql2);

$totalCustomers = 0;

if ($result && $row = $result->fetch_assoc()) {
    $totalCustomers = $row['total_customers'];
}

// get services count
$sql3 = "SELECT COUNT(*) AS total FROM services";
$res1 = $conn->query($sql3);
$services = $res1->fetch_assoc()['total'] ?? 0;

// get products count
$sql4 = "SELECT COUNT(*) AS total FROM products";
$res2 = $conn->query($sql4);
$products = $res2->fetch_assoc()['total'] ?? 0;

// combined total
$combinedTotal = $services + $products;

?>


  <div class="row g-3">
    <div class="col-md-3">
      <div class="small-box bg-info">
        <h3><?php echo $totalCustomers; ?></h3>
        <p>Customers</p>
        <div class="icon"><i class="bi bi-people"></i></div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="small-box bg-success">
        <h3>₹ <?php echo number_format($total, 2); ?></h3>
        <p>Income</p>
        <div class="icon"><i class="bi bi-currency-rupee"></i></div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="small-box bg-warning">
        <h3><?php echo $combinedTotal; ?></h3>
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

          <?php
            // Get services count
            $services = $conn->query("SELECT COUNT(*) AS total FROM services");
            $services = $services->fetch_assoc()['total'] ?? 0;

            // Get products count
            $products = $conn->query("SELECT COUNT(*) AS total FROM products");
            $products = $products->fetch_assoc()['total'] ?? 0;

            $total = $services + $products;
          ?>

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