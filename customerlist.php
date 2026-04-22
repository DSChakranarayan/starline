<?php $pageTitle = "Customers List"; ?>
<?php include("header.php"); ?>
<?php include("sidebar.php"); ?>
<?php include("navbar.php"); ?>


<table class="table">
    <tr>
        <th>Sr.No.</th>
        <th>Customer Name</th>
        <th>Mobile No.</th>
        <th>Category</th>
        <th>Group</th>
        <th>Address</th>
        <th>Date of Birth</th>
        <th>Age</th>
        <th>Action</th>
    </tr>

<?php
$stmt = $conn->prepare("
    SELECT 
        c.*, 
        cat.category_name, 
        g.group_name
    FROM customers c
    LEFT JOIN customer_categories cat ON c.category_id = cat.id
    LEFT JOIN Customer_groups g ON c.group_id = g.id
");

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $i = 1;
    while($row = $result->fetch_assoc()) {
?>

    <tr>
        <td><?= $i++; ?></td>
        <td><?= $row["name"]; ?></td>
        <td><?= $row["mobile"]; ?></td>
        <td><?= $row["category_name"] ?? '-'; ?></td>
        <td><?= $row["group_name"] ?? '-'; ?></td>
        <td><?= $row["address"]; ?></td>

        <td>
            <?= !empty($row['dob']) 
                ? date("d-m-Y", strtotime($row['dob'])) 
                : "N/A"; ?>
        </td>

        <td>
            <?= !empty($row['age']) 
                ? $row['age'] 
                : "-"; ?>
        </td>

        <td>
            <a href="edit_customer.php?id=<?= $row['id']; ?>" 
               class="btn btn-primary btn-sm">Edit</a>
        </td>
    </tr>

<?php
    }
} else {
    echo "<tr><td colspan='9'>No records found</td></tr>";
}
?>

</table>


<?php include("footer.php"); ?>