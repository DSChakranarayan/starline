<?php $pageTitle = "Service List View"; ?>
<?php include("header.php"); ?>
<?php include("sidebar.php"); ?>
<?php include("navbar.php"); ?>

<?php
$sql = "SELECT 
    s.id,
    s.name AS service_name,
    s.price,
    c.service_category AS category_name
    FROM services s
    JOIN service_categories c
    ON s.category_id = c.id;";

$result = mysqli_query($conn, $sql);
?>

<div class="card">
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
            </tr>
            <?php
                while($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?php echo $row['service_name']; ?></td>
                <td><?php echo $row['price'] ?></td>
                <td><?php echo $row['category_name']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>


<?php include("footer.php"); ?>