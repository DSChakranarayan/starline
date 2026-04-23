<?php $pageTitle = "Customers List"; ?>
<?php include("header.php"); ?>
<?php include("sidebar.php"); ?>
<?php include("navbar.php"); ?>

<?php
$search = $_GET['search'] ?? '';

$sql = "
    SELECT 
        c.*, 
        cat.category_name, 
        g.group_name
    FROM customers c
    LEFT JOIN customer_categories cat ON c.category_id = cat.id
    LEFT JOIN customer_groups g ON c.group_id = g.id
";

if (!empty($search)) {
    $sql .= " WHERE 
        c.full_name LIKE ? OR 
        c.mobile LIKE ? OR 
        c.mobile2 LIKE ? OR 
        c.village LIKE ? OR 
        c.taluka LIKE ? OR 
        c.district LIKE ? OR
        c.pincode LIKE ?
    ";
}

$stmt = $conn->prepare($sql);

if (!empty($search)) {
    $search_param = "%" . $search . "%";
    $stmt->bind_param(
        "sssssss",
        $search_param,
        $search_param,
        $search_param,
        $search_param,
        $search_param,
        $search_param,
        $search_param
    );
}

$stmt->execute();
$result = $stmt->get_result();




if (isset($_POST['delete_id'])) {

    $delete_id = (int)$_POST['delete_id'];

    $stmt = $conn->prepare("DELETE FROM customers WHERE id = ?");
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        $msg = "deleted";
        header("Refresh:0");
    } else {
        $msg = "error";
        header("Refresh:0");
    }
}
?>

<!-- SEARCH BOX -->
<form method="GET" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control"
                placeholder="Search name, mobile, village, taluka..."
                value="<?= htmlspecialchars($search) ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="customerlist.php" type="reset" class="btn btn-secondary">Reset</a>
        </div>
    </div>
</form>

<!-- TABLE -->
<table class="table table-bordered">
    <tr>
        <th>Sr.No.</th>
        <th>Customer Name</th>
        <th>Mobile No.</th>
        <th>Category</th>
        <th>Group</th>
        <th>Address</th>
        <th>Village</th>
        <th>DOB</th>
        <th>Age</th>
        <th>Action</th>
    </tr>

<?php
if ($result->num_rows > 0) {
    $i = 1;

    while ($row = $result->fetch_assoc()) {
?>

    <tr>
        <td><?= $i++; ?></td>
        <td><?= htmlspecialchars($row["full_name"]); ?></td>
        <td>
            <?= htmlspecialchars($row["mobile"]); ?>
            <?php if (!empty($row["mobile2"])) echo "<br><small>".$row["mobile2"]."</small>"; ?>
        </td>

        <td><?= $row["category_name"] ?? '-'; ?></td>
        <td><?= $row["group_name"] ?? '-'; ?></td>

        <td><?= htmlspecialchars($row["address"] ?? '-'); ?></td>
        <td><?= htmlspecialchars($row["village"] ?? '-'); ?></td>

        <td>
            <?= !empty($row['dob']) 
                ? date("d-m-Y", strtotime($row['dob'])) 
                : "N/A"; ?>
        </td>

        <td>
            <?= !empty($row['dob']) 
                ? date_diff(date_create($row['dob']), date_create('today'))->y 
                : "-"; ?>
        </td>

        <td>
            <a href="edit_customer.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>

            <form method="POST" style="display:inline;"
                onsubmit="return confirm('Are you sure you want to delete this customer?');">

                <input type="hidden" name="delete_id" value="<?= $row['id']; ?>">

                <button type="submit" class="btn btn-danger btn-sm">
                    Delete
                </button>
            </form>

        </td>
    </tr>

<?php
    }
} else {
    echo "<tr><td colspan='10' class='text-center'>No records found</td></tr>";
}
?>

</table>

<?php include("footer.php"); ?>