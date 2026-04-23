<?php $pageTitle = "Customers"; ?>
<?php include("header.php"); ?>
<?php include("sidebar.php"); ?>
<?php include("navbar.php"); ?>

<?php
// Fetch categories
$categories = $conn->query("SELECT * FROM customer_categories");

// Fetch groups
$groups = $conn->query("SELECT * FROM customer_groups");

// INSERT CUSTOMER
if (isset($_POST['submit'])) {

            $first  = $_POST['first_name'] ?? '';
            $middle = $_POST['middle_name'] ?? '';
            $last   = $_POST['last_name'] ?? '';

            $full_name = trim(implode(' ', array_filter([$first, $middle, $last])));
            if ($full_name === '') {
                $full_name = 'Unknown';
            }

            // Safe variables
            $mobile   = $_POST['mobile'];
            $mobile2  = $_POST['mobile2'] ?? '';
            $email    = $_POST['email'] ?? '';
            $aadhar   = $_POST['aadhar'] ?? '';
            $category = (int)($_POST['category_id'] ?? 0);
            $group    = (int)($_POST['group_id'] ?? 0);
            $address  = $_POST['address'] ?? '';
            $village  = $_POST['village'] ?? '';
            $taluka   = $_POST['taluka'] ?? '';
            $district = $_POST['district'] ?? '';
            $pincode  = $_POST['pincode'] ?? '';
            $dob      = $_POST['dob'];
            $age      = (int)($_POST['age'] ?? 0);

            $stmt = $conn->prepare("
                INSERT INTO customers 
                (first_name, middle_name, last_name, full_name, mobile, mobile2, email, aadhar,
                category_id, group_id, address, village, taluka, district, pincode, dob, age, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");

            $stmt->bind_param(
                "ssssssssiissssssi",
                $first,
                $middle,
                $last,
                $full_name,
                $mobile,
                $mobile2,
                $email,
                $aadhar,
                $category,   // ✅ now variable
                $group,      // ✅ now variable
                $address,
                $village,
                $taluka,
                $district,
                $pincode,
                $dob,
                $age
            );

            $stmt->execute();
            $stmt->close();

    echo "<script>alert('Customer added successfully');</script>";
}
?>

<div class="row">
<div class="col-md-12">
<div class="card shadow">

<div class="card-header bg-primary text-white">
    <h4>Add Customer</h4>
</div>

<div class="card-body">
<form method="POST">

<div class="row">

<!-- Name Fields -->
<div class="col-md-4 mb-3">
    <label>First Name</label>
    <input type="text" name="first_name" class="form-control" required>
</div>

<div class="col-md-4 mb-3">
    <label>Middle Name</label>
    <input type="text" name="middle_name" class="form-control">
</div>

<div class="col-md-4 mb-3">
    <label>Last Name</label>
    <input type="text" name="last_name" class="form-control" required>
</div>

<div class="col-md-12 mb-3">
    <label>Full Name</label>
    <input type="text" name="full_name" id="full_name" class="form-control" readonly>
</div>

<!-- Mobile -->
<div class="col-md-6 mb-3">
    <label>Mobile Number</label>
    <div class="input-group">
        <span class="input-group-text">+91</span>
        <input type="text" name="mobile" class="form-control" pattern="[0-9]{10}" required>
    </div>
</div>

<div class="col-md-6 mb-3">
    <label>Alternative Mobile</label>
    <div class="input-group">
        <span class="input-group-text">+91</span>
        <input type="text" name="mobile2" class="form-control" pattern="[0-9]{10}">
    </div>
</div>

<!-- DOB & Age -->
<div class="col-md-6 mb-3">
    <label>Date of Birth</label>
    <input type="date" name="dob" id="dob" class="form-control" onchange="calculateAge()" required>
</div>

<div class="col-md-6 mb-3">
    <label>Age</label>
    <input type="number" name="age" id="age" class="form-control" readonly>
</div>

<!-- Email -->
<div class="col-md-6 mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control">
</div>

<!-- Aadhar -->
<div class="col-md-6 mb-3">
    <label>Aadhar Number</label>
    <input type="text" name="aadhar" id="aadhar" class="form-control" placeholder="0000 0000 0000">
</div>

<!-- Category -->
<div class="col-md-6 mb-3">
    <label>Category</label>
    <select class="form-control" name="category_id" required>
        <option value="">Select Category</option>
        <?php while($row = $categories->fetch_assoc()) { ?>
            <option value="<?php echo $row['id']; ?>">
                <?php echo $row['category_name']; ?>
            </option>
        <?php } ?>
    </select>
</div>

<!-- Group -->
<div class="col-md-6 mb-3">
    <label>Group</label>
    <select class="form-control" name="group_id" required>
        <option value="">Select Group</option>
        <?php while($row = $groups->fetch_assoc()) { ?>
            <option value="<?php echo $row['id']; ?>">
                <?php echo $row['group_name']; ?>
            </option>
        <?php } ?>
    </select>
</div>

<!-- Address -->
<div class="col-md-12 mb-3">
    <label>Address</label>
    <textarea name="address" class="form-control" rows="3"></textarea>
</div>

<!-- Location -->
<div class="col-md-3 mb-3">
    <label>Village</label>
    <input type="text" name="village" class="form-control">
</div>

<div class="col-md-3 mb-3">
    <label>Taluka</label>
    <input type="text" name="taluka" class="form-control">
</div>

<div class="col-md-3 mb-3">
    <label>District</label>
    <input type="text" name="district" class="form-control">
</div>

<div class="col-md-3 mb-3">
    <label>Pin Code</label>
    <input type="text" name="pincode" class="form-control" pattern="[0-9]{6}">
</div>

</div>

<button type="submit" name="submit" class="btn btn-success">
    Save Customer
</button>

</form>
</div>

</div>
</div>
</div>

<!-- Scripts -->
<script>
function calculateAge() {
    var dob = document.getElementById('dob').value;
    if (dob) {
        var dobDate = new Date(dob);
        var today = new Date();

        var age = today.getFullYear() - dobDate.getFullYear();
        var m = today.getMonth() - dobDate.getMonth();

        if (m < 0 || (m === 0 && today.getDate() < dobDate.getDate())) {
            age--;
        }

        document.getElementById('age').value = age;
    }
}

// Aadhar formatting
document.getElementById('aadhar').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '').substring(0,12);
    let formatted = value.replace(/(\d{4})(?=\d)/g, '$1 ');
    e.target.value = formatted;
});



function updateFullName() {
    let first = document.querySelector('[name="first_name"]').value || '';
    let middle = document.querySelector('[name="middle_name"]').value || '';
    let last = document.querySelector('[name="last_name"]').value || '';

    let full = (first + " " + middle + " " + last).replace(/\s+/g, ' ').trim();
    document.getElementById('full_name').value = full;
}

// Trigger on typing
document.querySelector('[name="first_name"]').addEventListener('input', updateFullName);
document.querySelector('[name="middle_name"]').addEventListener('input', updateFullName);
document.querySelector('[name="last_name"]').addEventListener('input', updateFullName);

</script>

<?php include("footer.php"); ?>