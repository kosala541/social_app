<?php
require "includes/connection.php";

$error = "";
$email = "";
$password = "";

session_start();

if (isset($_SESSION["user"])) {
    header("Location:./");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // print_r($_POST);

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        $error = "Please enter your email address";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a validate email address";
    } else if (empty($password)) {
        $error = "Please enter your password";
    } else {
        $query = "SELECT * FROM `user` WHERE `email`='" . $email . "' 
        AND `password`='" . $password . "' AND `user_status_id`='1'";

        $data = mysqli_query($connection, $query);

        $data_number = $data->num_rows;

        if ($data_number == 1) {

            $user_data = $data->fetch_assoc();
            $_SESSION['user'] = $user_data;

            setcookie("email", $email, time() + (60 * 60 * 24 * 365), "/", "", true, true);
            setcookie("password", $password, time() + (60 * 60 * 24 * 365), "/", "", true, true);

            if ($user_data["user_type_id"] == 1) {
                header('Location:admin');
            } else if ($user_data["user_type_id"] == 3) {
                header('Location:./');
            }
        } else {
            $error = "Invalid email or password";
        }
    }
}
?>

<?php
$title = "Signin";

$c_email = "";
$c_password = "";
if (isset($_COOKIE['email'])) {
    $c_email = $_COOKIE['email'];
}

if (isset($_COOKIE['password'])) {
    $c_password = $_COOKIE['password'];
}

?>
<?php require "includes/header.php" ?>
<div class="col-md-6 offset-md-3 my-5">
    <div class="shadow shadow-sm bg-white rounded rounded-3 mb-4 p-5">
        <form action="" method="POST">
            <div class="row px-5">
                <a href="<?= ROOT ?>" class="text-center"><img src="<?= LOGO ?>" class="img-fluid" style="width: 80px;" alt=""></a>
                <h2 class="text-center">Signin Now</h2>

                <label class="form-label mt-2" for="email">Email</label>
                <input type="email" name="email" value="<?php if ($email == "") {
                                                            echo $c_email;
                                                        } else {
                                                            echo $email;
                                                        } ?>" id="email" class="form-control">

                <label class="form-label mt-4" for="password">Password</label>
                <input type="password" name="password" value="<?php if ($password == "") {
                                                                    echo $c_password;
                                                                } else {
                                                                    echo $password;
                                                                } ?>" id="password" class="form-control">
                <?php
                if ($error != "") {
                ?>
                    <div class="alert alert-danger mt-4" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                }
                ?>

                <div class="my-4 text-center">
                    <button type="submit" class="btn btn-success col-6">Signin</button>
                </div>
                <p class="text-center">Don't have an account?<a href="<?= ROOT ?>signup.php"> register now</a></p>
            </div>
        </form>
    </div>
</div>
<?php require "includes/footer.php" ?>