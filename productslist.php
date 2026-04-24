<?php $pageTitle = "Product List View"; ?>
<?php include("header.php"); ?>
<?php include("sidebar.php"); ?>
<?php include("navbar.php"); ?>

<?php
$sql = "SELECT 
    p.id,
    p.productname,
    p.price,
    p.stock,
    c.product_category AS category_name
FROM Products p
JOIN product_categories c
ON p.category_id = c.id";

$result = mysqli_query($conn, $sql);
?>

<div class="card">
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Stock</th>
            </tr>

            <?php
            while($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?php echo $row['productname']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['category_name']; ?></td>
                <td><?php echo $row['stock']; ?></td>
            </tr>
            <?php } ?>

        </table>
    </div>
</div>

<?php include("footer.php"); ?>