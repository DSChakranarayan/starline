<?php
session_start();
// if user already logged in, redirect away from login page
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
include("config.php");

$message = "";

if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {

        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            // verify hashed password
            if (password_verify($password, $user['password'])) {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                header("Location: index.php");
                exit;

            } else {
                $message = "Invalid password!";
            }

        } else {
            $message = "User not found!";
        }

        $stmt->close();

    } else {
        $message = "Please fill all fields!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
        }
        .login-card {
            width: 400px;
            margin: 100px auto;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            background: #fff;
        }
    </style>
</head>
<body>

<div class="login-card">

    <h3 class="text-center mb-4">Login</h3>

    <?php if (!empty($message)) { ?>
        <div class="alert alert-danger">
            <?php echo $message; ?>
        </div>
    <?php } ?>

    <form method="post" action="">

        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" name="login" class="btn btn-primary w-100">
            Login
        </button>

    </form>

</div>

<p style="color:red;">
    <?php echo $message; ?>
</p>

</body>
</html>