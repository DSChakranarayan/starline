<?php $pageTitle = "Income"; ?>
<?php include("header.php"); ?>
<?php include("sidebar.php"); ?>
<?php include("navbar.php"); ?>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Get form data
$customer_id = $_POST['customer_id'];
$grand_total = $_POST['grand_total'];
$payment     = $_POST['payment_method'];

$item_id = $_POST['item_id'];
$price   = $_POST['price'];
$qty     = $_POST['qty'];
$total   = $_POST['total'];

// 1. Insert main income
$sql = "INSERT INTO income (customer_id, total_amount, payment_method, date)
        VALUES ('$customer_id', '$grand_total', '$payment', NOW())";

mysqli_query($conn, $sql);

// Get last inserted ID
$income_id = mysqli_insert_id($conn);

// 2. Insert items
$count = count($item_id);

for ($i = 0; $i < $count; $i++) {

    if ($item_id[$i] == "") continue;

    $sql2 = "INSERT INTO income_details 
            (income_id, item_id, price, qty, total)
            VALUES 
            ('$income_id', '$item_id[$i]', '$price[$i]', '$qty[$i]', '$total[$i]')";

    mysqli_query($conn, $sql2);
}

echo "<script>alert('Data saved successfully!');</script>";
        header("Refresh: 0");
}
?>




<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
           
              <div class="container mt-5">
  <h3 class="mb-4">Income Entry</h3>

  <form method="POST" action="">

    <!-- Customer -->
    <div class="mb-3">
      <label class="form-label">Customer</label>
      <select name="customer_id" class="form-control" required>
        <option value="">Select Customer</option>

        <?php
          $result = $conn->query("SELECT * FROM customers");

          while($row = $result->fetch_assoc()){
              echo "<option value='".$row['id']."'>".$row['full_name']."</option>";
          }
        ?>
      </select>
    </div>

    <!-- Items Table -->
    <table class="table table-bordered" id="itemsTable">
      <thead class="table-light">
        <tr>
          <th>Product / Service</th>
          <th>Price</th>
          <th>Qty</th>
          <th>Total</th>
          <th width="50">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <select name="item_id[]" class="form-control item-select" required>
              <option value="">Select</option>

              <?php
                $result = $conn->query("SELECT * FROM services");

                while($row = $result->fetch_assoc()){
                    echo "<option value='".$row['id']."' data-price='".$row['price']."'>".$row['name']."</option>";
                }
              ?>
            </select>
          </td>

          <td>
            <input type="number" name="price[]" class="form-control price" readonly>
          </td>

          <td>
            <input type="number" name="qty[]" class="form-control qty" value="1">
          </td>

          <td>
            <input type="number" name="total[]" class="form-control total" readonly>
          </td>

          <td>
            <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
          </td>
        </tr>
      </tbody>
    </table>

    <button type="button" class="btn btn-primary mb-3" id="addRow">+ Add Item</button>

    <!-- Grand Total -->
    <div class="mb-3">
      <label class="form-label">Grand Total</label>
      <input type="number" name="grand_total" id="grandTotal" class="form-control" readonly>
    </div>

    <!-- Payment Method -->
            <div class="mb-3">
            <label for="payment" class="form-label">Payment Method</label>
            <select class="form-select" id="payment" name="payment_method">
                <option selected disabled>Select method</option>
                <option>Cash</option>
                <option>Bank Transfer</option>
                <option>UPI</option>
                <option>Cheque</option>
            </select>
            </div>

    <button type="submit" class="btn btn-success">Save</button>

  </form>
</div>

<script>
function calculateRow(row) {
  let price = row.querySelector(".price").value || 0;
  let qty = row.querySelector(".qty").value || 0;
  let total = price * qty;
  row.querySelector(".total").value = total;
  calculateGrandTotal();
}

function calculateGrandTotal() {
  let totals = document.querySelectorAll(".total");
  let grand = 0;
  totals.forEach(t => grand += parseFloat(t.value) || 0);
  document.getElementById("grandTotal").value = grand;
}

// Auto fill price
document.addEventListener("change", function(e){
  if(e.target.classList.contains("item-select")){
    let price = e.target.selectedOptions[0].dataset.price;
    let row = e.target.closest("tr");
    row.querySelector(".price").value = price;
    calculateRow(row);
  }
});

// Quantity change
document.addEventListener("input", function(e){
  if(e.target.classList.contains("qty")){
    calculateRow(e.target.closest("tr"));
  }
});

// Add row
document.getElementById("addRow").addEventListener("click", function(){
  let table = document.querySelector("#itemsTable tbody");
  let newRow = table.rows[0].cloneNode(true);

  newRow.querySelectorAll("input").forEach(i => i.value = "");
  newRow.querySelector(".qty").value = 1;

  table.appendChild(newRow);
});

// Remove row
document.addEventListener("click", function(e){
  if(e.target.classList.contains("removeRow")){
    let table = document.querySelector("#itemsTable tbody");
    if(table.rows.length > 1){
      e.target.closest("tr").remove();
      calculateGrandTotal();
    }
  }
});
</script>

            </div>
        </div>
    </div>

<?php
$sql = "
SELECT 
    i.id,
    c.full_name AS customer_name,
    i.total_amount,
    i.payment_method,
    i.date
FROM income i
INNER JOIN customers c ON i.customer_id = c.id
ORDER BY i.date DESC
";

$result = $conn->query($sql);
?>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Sr.</th>
                        <th>Customer Name</th>
                        <th>Price</th>
                        <th>Payment</th>
                        <th>Date</th>
                    </tr>

                   <?php
                      if ($result && $result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                              echo "<tr>
                                  <td>{$row['id']}</td>
                                  <td>{$row['customer_name']}</td>
                                  <td>{$row['total_amount']}</td>
                                  <td><b>{$row['payment_method']}</b></td>
                                  <td>{$row['date']}</td>
                              </tr>";
                          }
                      } else {
                          echo "<tr><td colspan='4'>No data to show</td></tr>";
                      }
                    ?>

                </table>
            </div>
        </div>
    </div>
</div>


<?php include("footer.php"); ?>