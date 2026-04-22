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

        $stmt = $conn->prepare("
            INSERT INTO customers 
            (name, mobile, email, category_id, group_id, address, dob, age, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        $stmt->bind_param(
            "sssiissi",
            $_POST['name'],
            $_POST['mobile'],
            $_POST['email'],
            $_POST['category_id'],
            $_POST['group_id'],
            $_POST['address'],
            $_POST['dob'],
            $_POST['age']
        );

        $stmt->execute();
        $stmt->close();

        echo "<script>alert('Customer added successfully');</script>";
    }
?>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            
        
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Add Customer</h4>
        </div>

        <div class="card-body">

            <form method="POST">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Mobile</label>
                        <input type="text" name="mobile" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Date of Birth</label>
                        <input type="date" name="dob" id="dob" class="form-control" onchange="calculateAge()" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Age</label>
                        <input type="number" name="age" id="age" class="form-control" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                    <label>Category</label>
                    <select class="form-control" name="category_id" required>
                        <option value="">Select Category</option>
                        <?php while($row = $categories->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id']; ?>">
                                <?php echo $row['name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    
                        <!-- <label>Category ID</label> -->
                        <!-- <input type="number" name="category_id" class="form-control"> -->
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Group</label>
                        <select class="form-control" name="group_id" required>
                            <option value="">Select Group</option>
                            <?php while($row = $groups->fetch_assoc()) { ?>
                                <option value="<?php echo $row['id']; ?>">
                                    <?php echo $row['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <!-- <label>Group ID</label> -->
                        <!-- <input type="number" name="group_id" class="form-control"> -->
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Address</label>
                        <textarea name="address" class="form-control" rows="3"></textarea>
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
</div>

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
</script>

<?php include("footer.php"); ?>