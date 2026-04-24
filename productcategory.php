<?php $pageTitle = "Product Category"; ?>
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
    $name = trim($_POST['product_category']);

    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO product_categories (product_category) VALUES (?)");
        $stmt->bind_param("s", $name);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Product category added successfully";
            echo "<script>alert('" . $_SESSION['message'] . "');</script>";
            unset($_SESSION['message']);
            header("Refresh:0; url=productcategory.php");
            exit;
        } else {
            echo "Insert failed: " . $conn->error;
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
    $name = trim($_POST['product_category']);

    if (!empty($name)) {
        $stmt = $conn->prepare("UPDATE product_categories SET product_category=? WHERE id=?");
        $stmt->bind_param("si", $name, $id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Product category updated successfully";
            echo "<script>alert('" . $_SESSION['message'] . "');</script>";
            unset($_SESSION['message']);
            header("Refresh:0; url=productcategory.php");
            exit;
        } else {
            echo "Update failed: " . $conn->error;
        }

        $stmt->close();
        exit;
    }
}

/* =========================
   DELETE category
========================= */
if (isset($_GET['delete_id'])) {

    $id = intval($_GET['delete_id']);

    $stmt = $conn->prepare("DELETE FROM product_categories WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Product category deleted successfully";
        echo "<script>alert('" . $_SESSION['message'] . "');</script>";
        unset($_SESSION['message']);
        header("Refresh:0; url=productcategory.php");
        exit;
    } else {
        echo "Delete failed: " . $conn->error;
    }

    $stmt->close();
}

/* =========================
   FETCH DATA
========================= */
$result = $conn->query("SELECT * FROM product_categories ORDER BY id DESC");
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
                <h4>Add Product Category</h4>

                <form method="post">
                    <div class="mb-2">
                        <input type="text" name="product_category" class="form-control"
                               placeholder="Enter category name" required>
                    </div>
                    <button type="submit" name="add_category" class="btn btn-primary">
                        Add
                    </button>
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
                            <td><?= $sn++; ?></td>

                            <!-- Inline update form -->
                            <td>
                                <form method="post" class="d-flex">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">

                                    <input type="text"
                                           name="product_category"
                                           value="<?= htmlspecialchars($row['product_category']); ?>"
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

<?php include("footer.php"); $conn->close(); ?>