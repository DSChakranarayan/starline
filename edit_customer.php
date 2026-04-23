<?php
include("config.php"); // your DB connection file

$id = $_GET['id'] ?? 0;
$id = (int)$id;

if ($id <= 0) {
    die("Invalid Customer ID");
}

/* ---------------------------
   FETCH CUSTOMER DATA
---------------------------- */
$stmt = $conn->prepare("
    SELECT * FROM customers WHERE id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Customer not found");
}

$customer = $result->fetch_assoc();

/* ---------------------------
   UPDATE CUSTOMER
---------------------------- */
if (isset($_POST['update'])) {

    $full_name = $_POST['full_name'];
    $mobile    = $_POST['mobile'];
    $mobile2   = $_POST['mobile2'];
    $category_id = $_POST['category_id'];
    $group_id  = $_POST['group_id'];
    $address   = $_POST['address'];
    $village   = $_POST['village'];
    $taluka    = $_POST['taluka'];
    $district  = $_POST['district'];
    $pincode   = $_POST['pincode'];
    $dob       = $_POST['dob'];

    $update = $conn->prepare("
        UPDATE customers SET
            full_name = ?,
            mobile = ?,
            mobile2 = ?,
            category_id = ?,
            group_id = ?,
            address = ?,
            village = ?,
            taluka = ?,
            district = ?,
            pincode = ?,
            dob = ?
        WHERE id = ?
    ");

    $update->bind_param(
        "sssiissssssi",
        $full_name,
        $mobile,
        $mobile2,
        $category_id,
        $group_id,
        $address,
        $village,
        $taluka,
        $district,
        $pincode,
        $dob,
        $id
    );

    if ($update->execute()) {
        header("Location: customerlist.php?msg=updated");
        exit;
    } else {
        echo "Update failed!";
    }
}
?>

<?php $pageTitle = "Edit Customer"; ?>
<?php include("header.php"); ?>
<?php include("sidebar.php"); ?>
<?php include("navbar.php"); ?>

<div class="container mt-3">

<h3>Edit Customer</h3>

<form method="POST">

    <div class="row">

        <div class="col-md-6">
            <label>Full Name</label>
            <input type="text" name="full_name" class="form-control"
                value="<?= htmlspecialchars($customer['full_name']); ?>" required>
        </div>

        <div class="col-md-6">
            <label>Mobile</label>
            <input type="text" name="mobile" class="form-control"
                value="<?= $customer['mobile']; ?>" required>
        </div>

        <div class="col-md-6 mt-2">
            <label>Mobile 2</label>
            <input type="text" name="mobile2" class="form-control"
                value="<?= $customer['mobile2']; ?>">
        </div>

        <div class="col-md-6 mt-2">
            <label>Category ID</label>
            <input type="number" name="category_id" class="form-control"
                value="<?= $customer['category_id']; ?>">
        </div>

        <div class="col-md-6 mt-2">
            <label>Group ID</label>
            <input type="number" name="group_id" class="form-control"
                value="<?= $customer['group_id']; ?>">
        </div>

        <div class="col-md-6 mt-2">
            <label>DOB</label>
            <input type="date" name="dob" class="form-control"
                value="<?= $customer['dob']; ?>">
        </div>

        <div class="col-md-12 mt-2">
            <label>Address</label>
            <textarea name="address" class="form-control"><?= $customer['address']; ?></textarea>
        </div>

        <div class="col-md-4 mt-2">
            <label>Village</label>
            <input type="text" name="village" class="form-control"
                value="<?= $customer['village']; ?>">
        </div>

        <div class="col-md-4 mt-2">
            <label>Taluka</label>
            <input type="text" name="taluka" class="form-control"
                value="<?= $customer['taluka']; ?>">
        </div>

        <div class="col-md-4 mt-2">
            <label>District</label>
            <input type="text" name="district" class="form-control"
                value="<?= $customer['district']; ?>">
        </div>

        <div class="col-md-4 mt-2">
            <label>Pincode</label>
            <input type="text" name="pincode" class="form-control"
                value="<?= $customer['pincode']; ?>">
        </div>

    </div>

    <br>

    <button type="submit" name="update" class="btn btn-success">
        Update Customer
    </button>

    <a href="customerlist.php" class="btn btn-secondary">Back</a>

</form>

</div>

<?php include("footer.php"); ?>