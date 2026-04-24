<?php $pageTitle = "Expense"; ?>
<?php include("header.php"); ?>
<?php include("sidebar.php"); ?>
<?php include("navbar.php"); ?>
<?php 
    $message = "";

if (isset($_POST['submit'])) {
    $expense_name = $_POST['expense_name'];
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $payment_type = $_POST['payment_type'];
    $currency = $_POST['currency'];
    $status = $_POST['status'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    $note = $_POST['note'];

    /* File Upload */
    $receiptName = "";
    if (!empty($_FILES['receipt']['name'])) {
        $receiptName = time() . "_" . $_FILES['receipt']['name'];
        move_uploaded_file($_FILES['receipt']['tmp_name'], "uploads/" . $receiptName);
    }

    $stmt = $conn->prepare("INSERT INTO expenses 
    (expense_name, description, amount, category, payment_type, currency, status, date, note, receipt) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssdsssssss",
        $expense_name,
        $description,
        $amount,
        $category,
        $payment_type,
        $currency,
        $status,
        $date,
        $note,
        $receiptName
    );

    // $stmt->execute();

    if ($stmt->execute()) {
    $message = "Saved successfully!";
    header("refresh:2");
    } else {
        echo "Failed to insert data.";
    }

}
?>

<?php echo "<h6><center>$message</center></h6>"; ?>

<div class="card">
        <div class="card-body">

        <h2 class="title">Expenses</h2>

        <form action="" method="POST" enctype="multipart/form-data">

        

        <div class="mb-3">
            <label class="form-label">Expense Name</label>
            <input type="text" name="expense_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Amount</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
            <label>Category</label>
            <select name="category" class="form-select">
                <option>Food</option>
                <option>Travel</option>
                <option>Bills</option>
                <option>Shopping</option>
            </select>
            </div>

            <div class="col-md-4 mb-3">
            <label>Payment Type</label>
            <select name="payment_type" class="form-select">
                <option>Cash</option>
                <option>UPI</option>
                <option>Card</option>
            </select>
            </div>

            <div class="col-md-4 mb-3">
            <label>Currency</label>
            <select name="currency" class="form-select">
                <option value="INR">INR</option>
                <option value="USD">USD</option>
            </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
            <label>Date</label>
            <input type="date" name="date" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="Completed">Completed</option>
                <option value="Pending">Pending</option>
            </select>
            </div>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Note</label>
            <textarea name="note" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Upload Receipt</label>
            <input type="file" name="receipt" class="form-control">
        </div>

        <button class="btn btn-primary w-100" type="submit" name="submit">Save Expense</button>

        </form>

    </div>
</div>


<?php include("footer.php"); ?>