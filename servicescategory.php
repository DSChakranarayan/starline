<?php $pageTitle = "Customers category"; ?>
<?php include("header.php"); ?>
<?php include("sidebar.php"); ?>
<?php include("navbar.php"); ?>

<?php
    $message = "";
    $sn = 1;
/* =========================
   ADD category
========================= */
if (isset($_POST['add_category'])) {
    $name = trim($_POST['service_category']);

    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO service_categories (service_category) VALUES (?)");
        $stmt->bind_param("s", $name);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Customer category Added successfully";
            // header("Location: " . $_SERVER['PHP_SELF']);
            echo "<script>alert('" . $_SESSION['message'] . "');</script>";
            unset($_SESSION['message']);
            header("Refresh:0; url=servicescategory.php");
            exit;
        } else {
            echo "Delete failed: " . $conn->error;
        }

        $stmt->close();

        exit;
    }
}

/* =========================
   UPDATE category
========================= */    
if (isset($_POST['update_category'])) {
    $id = $_POST['id'];
    $name = trim($_POST['service_category']);

    if (!empty($name)) {
        $stmt = $conn->prepare("UPDATE service_categories SET service_category=? WHERE id=?");
        $stmt->bind_param("si", $name, $id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Customer category Updated successfully";
            echo "<script>alert('" . $_SESSION['message'] . "');</script>";
            unset($_SESSION['message']);
            header("Refresh:0; url=servicescategory.php");
            exit;
        } else {
            echo "Delete failed: " . $conn->error;
        }

        $stmt->close();
        exit;
    }
}

/* =========================
   Delete category
========================= */
if (isset($_GET['delete_id'])) {

    $id = intval($_GET['delete_id']);

    $stmt = $conn->prepare("DELETE FROM service_categories WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Customer category Deleted successfully";
        echo "<script>alert('" . $_SESSION['message'] . "');</script>";
        unset($_SESSION['message']);
        header("Refresh:0; url=servicescategory.php");

        exit;
    } else {
        echo "Delete failed: " . $conn->error;
    }

    $stmt->close();
}
/* =========================
   FETCH DATA
========================= */
$result = $conn->query("SELECT * FROM service_categories ORDER BY id DESC");
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
                <h4>Add Category</h4>

                <form method="post">
                    <div class="mb-2">
                        <input type="text" name="service_category" class="form-control" placeholder="Enter category name" required>
                    </div>
                    <button type="submit" name="add_category" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>

        <!-- ================= RIGHT: LIST ================= -->
        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <h4>Category List</h4>

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
                                        name="service_category"
                                        value="<?= htmlspecialchars($row['service_category']); ?>"
                                        class="form-control form-control-sm">
                            </td>

                            <td>
                                    <button type="submit"
                                            name="update_category"
                                            class="btn btn-sm btn-success ms-2">
                                        Update
                                    </button>
                                </form>

                                <a href="?delete_id=<?= $row['id']; ?>"
                                class="btn btn-sm btn-danger ms-2"
                                onclick="return confirm('Delete this category?');">
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