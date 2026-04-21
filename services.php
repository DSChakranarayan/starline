<?php $pageTitle = "Services"; ?>
<?php include("header.php"); ?>
<?php include("sidebar.php"); ?>
<?php include("navbar.php"); ?>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    // Insert into database
    $sql = "INSERT INTO services (name, price, category_id) VALUES ('$name', '$amount', '$category')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data inserted successfully!');</script>";
        header("Refresh: 0");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>


<div class="row">
    <div class="col-md-6">
        <div class="card">

            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Add Services</h4>
            </div>
            <div class="card-body">
            <form method="POST" action="">
            <!-- Date -->
            <div class="mb-3">
                <label for="name" class="form-label">Service Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <!-- Amount -->
            <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <div class="input-group">
                <span class="input-group-text">₹</span>
                <input type="number" class="form-control" id="amount" placeholder="Enter amount" name="amount" required>
            </div>
            </div>

            <!-- Category -->
            <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category">
                <option selected disabled>Select category</option>
                <option value="1">Online</option>
                <option value="2">Offline</option>
                <option value="3">Print Based</option>
                <option value="4">Email Based</option>
                <option value="5">Other</option>
            </select>
            </div>

            

            <!-- Notes 
            <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control" id="notes" rows="3" placeholder="Optional details"></textarea>
            </div>-->

            <!-- Submit -->
            <div class="d-flex justify-content-end">
            <button type="reset" class="btn btn-secondary me-2">Reset</button>
            <button type="submit" class="btn btn-success" value="submit">Save Income</button>
            </div>

            </form>


            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">

            <?php
                $sql = "SELECT * FROM services";
                $result = $conn->query($sql);
            ?>

                <table class="table">
                    <tr>
                        <th>Service Name</th>
                        <th>Price</th>
                        <!-- <th>Action</th> -->
                    </tr>
                    <?php
                        if ($result && $result->num_rows > 0) {
                            // Output each row
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['name']}</td>
                                        <td>{$row['price']}</td>
                                    </tr>";
                        }
                    } else {
                        // No data case
                        echo "<tr><td colspan='2'>No data to show</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>