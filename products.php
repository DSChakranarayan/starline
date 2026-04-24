<?php $pageTitle = "Product"; ?>
<?php include("header.php"); ?>
<?php include("sidebar.php"); ?>
<?php include("navbar.php"); ?>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productname = $_POST['productname'];
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    // Insert into database
    $sql = "INSERT INTO products (productname, price, category_id, stock) VALUES ('$productname', '$amount', '$category', '$stock')";

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
                <h4 class="mb-0">Add Product</h4>
            </div>
            <div class="card-body">
            <form method="POST" action="">
            <!-- Date -->
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="productname" name="productname" required>
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
            <?php
                $sql = "SELECT id, product_category FROM product_categories";
                $result = $conn->query($sql);
            ?>

            <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category_id" name="category">
                <option selected disabled>Select category</option>
                <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>
                                    {$row['product_category']}
                                </option>";
                        }
                    }
                ?>
            </select>
            </div>

            

            <!-- Stock -->
            <div class="mb-3">
            <label for="notes" class="form-label">Stocks</label>
            <input type="number" class="form-control" id="stock" placeholder="Enter Stock" name="stock" required>
            </div>

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
                $sql = "
                        SELECT 
                        Products.productname,
                        Products.price,
                        Products.stock,
                        product_categories.product_category AS category_name
                        FROM Products
                        LEFT JOIN product_categories
                        ON Products.category_id = product_categories.id
                ";

                    $result = $conn->query($sql);
                ?>

                <table class="table">
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Stock</th>
                    </tr>

                    <?php
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                // fallback if category is missing
                                $category = $row['category_name'] ?? 'No Category';

                                echo "<tr>
                                        <td>{$row['productname']}</td>
                                        <td>{$row['price']}</td>
                                        <td>{$category}</td>
                                        <td>{$row['stock']}</td>
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