<?php
require "includes/connection.php";

session_start();

if (isset($_SESSION["user"])) {
    header("Location:./");
}

$error = "";
$first_name = "";
$last_name = "";
$contact_number = "";
$email = "";
$password = "";
$confirm_password = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // print_r($_POST);

    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $contact_number = $_POST['mobile'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['co-password'];

    $regex = "/^[0]{1}[7]{1}[01245678]{1}[0-9]{7}$/";

    $query2 = "SELECT * FROM `user` WHERE `email` ='" . $email . "'";
    $result = mysqli_query($connection, $query2);
    $post_rows = mysqli_num_rows($result);

    if (empty($first_name)) {
        $error = "Please enter your first name";
    } else if (empty($last_name)) {
        $error = "Please enter your last name";
    } else if (empty($contact_number)) {
        $error = "Please enter your contact number";
    } else if (!preg_match($regex, $contact_number)) {
        $error = "Please enter a validate contact number";
    } else if (empty($email)) {
        $error = "Please enter your email address";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a validate email address";
    } else if ($post_rows >= 1) {
        $error = "Email address already exists";
    } else if (empty($password)) {
        $error = "Please enter password";
    } else if ($password != $confirm_password) {
        $error = "Passwords do not match";
    } else {
        $error = "";

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        $query = "INSERT INTO user (`fname`,`lname`,`mobile`,`email`,`password`,`register_date`,`user_type_id`,`user_status_id`)
        VALUES ('" . $first_name . "','" . $last_name . "','" . $contact_number . "','" . $email . "','" . $password . "','" . $date . "','3','1')";

        mysqli_query($connection, $query);

        header('Location:signin.php');
    }
}
?>
<?php
$title = "Signup";
?>
<?php require "includes/header.php" ?>
<div class="col-md-6 offset-md-3 my-5">
    <div class="shadow shadow-sm bg-white rounded rounded-3 mb-4 p-5">
        <form action="" method="POST">
            <div class="row px-5">
                <a href="<?= ROOT ?>" class="text-center"><img src="<?= LOGO ?>" class="img-fluid" style="width: 80px;" alt=""></a>
                <h2 class="text-center">Register Now</h2>

                <label class="form-label" for="fname">First Name</label>
                <input type="text" value="<?php echo $first_name ?>" id="fname" name="fname" class="form-control">

                <label class="form-label mt-2" for="lname">Last Name</label>
                <input type="text" value="<?php echo $last_name ?>" id="lname" name="lname" class="form-control">

                <label class="form-label mt-2" for="mobile">Contact Number</label>
                <input type="text" value="<?php echo $contact_number ?>" id="mobile" name="mobile" class="form-control">

                <label class="form-label mt-2" for="email">Email</label>
                <input type="email" value="<?php echo $email ?>" id="email" name="email" class="form-control">

                <label class="form-label mt-2" for="password">Password</label>
                <input type="password" value="<?php echo $password ?>" id="password" name="password" class="form-control">

                <label class="form-label mt-2" for="co-password">Confirm Password</label>
                <input type="password" value="<?php echo $confirm_password ?>" id="co-password" name="co-password" class="form-control">

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
                    <button type="submit" class="btn btn-success col-6">Register</button>
                </div>
                <p class="text-center">Already have an account? <a href="<?= ROOT ?>signin.php">Signin now</a></p>
            </div>
        </form>
    </div>
</div>
<?php require "includes/footer.php" ?>