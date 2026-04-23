<?php $pageTitle = "Customers Group"; ?>
<?php include("header.php"); ?>
<?php include("sidebar.php"); ?>
<?php include("navbar.php"); ?>

<?php
    $message = "";
    $sn = 1;
/* =========================
   ADD group
========================= */
if (isset($_POST['add_group'])) {
    $name = trim($_POST['group_name']);

    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO customer_groups (group_name) VALUES (?)");
        $stmt->bind_param("s", $name);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Customer Group Added successfully";
            // header("Location: " . $_SERVER['PHP_SELF']);
            echo "<script>alert('" . $_SESSION['message'] . "');</script>";
            unset($_SESSION['message']);
            header("Refresh:0; url=customergroup.php");
            exit;
        } else {
            echo "Delete failed: " . $conn->error;
        }

        $stmt->close();

        exit;
    }
}

/* =========================
   UPDATE group
========================= */    
if (isset($_POST['update_group'])) {
    $id = $_POST['id'];
    $name = trim($_POST['group_name']);

    if (!empty($name)) {
        $stmt = $conn->prepare("UPDATE customer_groups SET group_name=? WHERE id=?");
        $stmt->bind_param("si", $name, $id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Customer Group Updated successfully";
            echo "<script>alert('" . $_SESSION['message'] . "');</script>";
            unset($_SESSION['message']);
            header("Refresh:0; url=customergroup.php");
            exit;
        } else {
            echo "Delete failed: " . $conn->error;
        }

        $stmt->close();
        exit;
    }
}

/* =========================
   Delete group
========================= */
if (isset($_GET['delete_id'])) {

    $id = intval($_GET['delete_id']);

    $stmt = $conn->prepare("DELETE FROM customer_groups WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Customer Group Deleted successfully";
        echo "<script>alert('" . $_SESSION['message'] . "');</script>";
        unset($_SESSION['message']);
        header("Refresh:0; url=customergroup.php");

        exit;
    } else {
        echo "Delete failed: " . $conn->error;
    }

    $stmt->close();
}
/* =========================
   FETCH DATA
========================= */
$result = $conn->query("SELECT * FROM customer_groups ORDER BY id DESC");
?>

<?php
if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-success text-center'>" . $_SESSION['message'] . "</div>";
    unset($_SESSION['message']);
}
?>

<div class="container mt-4">
    <div class="row">

        <!-- ================= LEFT: ADD FORM ================= -->
        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <h4>Add Group</h4>

                <form method="post">
                    <div class="mb-2">
                        <input type="text" name="group_name" class="form-control" placeholder="Enter group name" required>
                    </div>
                    <button type="submit" name="add_group" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>

        <!-- ================= RIGHT: LIST ================= -->
        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <h4>Group List</h4>

                <table class="table table-bordered mt-2">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>

                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <!-- <td><= $row['id']; ?></td> -->
                             <td><?= $sn++; ?></td>

                            <!-- Inline update form -->
                            <td>
                                <form method="post" class="d-flex">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">

                                    <input type="text"
                                        name="group_name"
                                        value="<?= htmlspecialchars($row['group_name']); ?>"
                                        class="form-control form-control-sm">
                            </td>

                            <td>
                                    <button type="submit"
                                            name="update_group"
                                            class="btn btn-sm btn-success ms-2">
                                        Update
                                    </button>
                                </form>

                                <a href="?delete_id=<?= $row['id']; ?>"
                                class="btn btn-sm btn-danger ms-2"
                                onclick="return confirm('Delete this group?');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php } ?>

                </table>
            </div>
        </div>

    </div>
</div>

<p><?php echo $message; ?></p>

<?php include("footer.php");  $conn->close(); ?>