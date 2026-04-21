<?php $pageTitle = "Customers"; ?>
<?php include("header.php"); ?>
<?php include("sidebar.php"); ?>
<?php include("navbar.php"); ?>

<?php
    // INSERT CUSTOMER
    if (isset($_POST['submit'])) {

        $stmt = $conn->prepare("
            INSERT INTO customers 
            (name, mobile, email, category_id, group_id, address, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");

        $stmt->bind_param(
            "sssiss",
            $_POST['name'],
            $_POST['mobile'],
            $_POST['email'],
            $_POST['category_id'],
            $_POST['group_id'],
            $_POST['address']
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
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Category ID</label>
                        <input type="number" name="category_id" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Group ID</label>
                        <input type="number" name="group_id" class="form-control">
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

<?php include("footer.php"); ?>