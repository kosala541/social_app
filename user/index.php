<?php
require "../includes/connection.php";

$error = "";
session_start();

if (!isset($_SESSION["user"])) {
    header("Location:../signin.php");
}
if ($_SESSION["user"]["user_type_id"] != 3) {
    header("Location:../signin.php");
}

$query = "SELECT * FROM `user` WHERE `id`='" . $_SESSION["user"]["id"] . "' AND `user_status_id`='1'";
$data = mysqli_query($connection, $query);
$user_data = $data->fetch_assoc();

$dateTime = new DateTime($user_data["register_date"]);
$formattedDateTime = $dateTime->format('Y-m-d');

$error = "";
$first_name = "";
$last_name = "";
$contact_number = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // print_r($_POST);

    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $contact_number = $_POST['mobile'];

    $regex = "/^[0]{1}[7]{1}[01245678]{1}[0-9]{7}$/";

    if (empty($first_name)) {
        $error = "Please enter your first name";
    } else if (empty($last_name)) {
        $error = "Please enter your last name";
    } else if (empty($contact_number)) {
        $error = "Please enter your contact number";
    } else if (!preg_match($regex, $contact_number)) {
        $error = "Please enter a validate contact number";
    } else {
        $error = "";

        $dp_path = $user_data["dp_path"];

        $folder = "assets/images/uploads/";
        $allowed = ["image/jpg", "image/jpeg", "image/png", "image/svg+xml"];
        if (!empty($_FILES['profile_img']['name'])) {

            if ($_FILES['profile_img']['error'] == 0) {
                if (in_array($_FILES['profile_img']['type'], $allowed)) {

                    $destination = "../" . $folder . time() . $_FILES['profile_img']['name'];
                    $dp_path = $folder . time() . $_FILES['profile_img']['name'];
                    move_uploaded_file($_FILES['profile_img']['tmp_name'], $destination);

                    if (file_exists($user_data["dp_path"])) {
                        unlink($user_data["dp_path"]);
                    }
                } else {
                    $error = "This file type is not allowed";
                }
            } else {
                $error = "Could not upload image";
            }
        }

        $query = "UPDATE user SET `fname`='" . $first_name . "',`lname`='" . $last_name . "',
        `mobile`='" . $contact_number . "',`dp_path`='" . $dp_path . "' 
        WHERE `id`='" . $_SESSION["user"]["id"] . "'";

        mysqli_query($connection, $query);

        header('Location:./');
    }
}

?>

<?php
$title = "Profile";
?>
<?php require "../includes/header.php" ?>
<?php require "../includes/nav.php" ?>
<div class="col-md-6 offset-md-3 my-5">
    <div class="shadow shadow-sm bg-white rounded rounded-3 mb-4 p-5">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-5 text-center">
                    <label for="select_dp" class="select_dp rounded rounded-circle" style="width: 130px; height: 130px; cursor: pointer;">
                        <input type="file" name="profile_img" style="display: none;" accept="image/*" id="select_dp" onchange="load_image(this.files[0])">
                        <img src="<?php if (isset($user_data["dp_path"])) {
                                        echo "../" . $user_data["dp_path"];
                                    } else {
                                        echo ASSETS_ROOT . "images/user.png";
                                    } ?>" id="dp_preview" class="rounded rounded-circle" style="background-color: #B7A6D6; width: 130px; height: 130px; background-size: cover;">
                    </label>

                    <p class="fw-bold mt-2 m-0"><?php echo $user_data["fname"] . " " . $user_data["lname"] ?></p>
                    <p class="m-0" style="font-size: 12px;"><?php echo $user_data["email"] ?></p>
                    <div class="mt-4">
                        <button class="btn btn-success" style="width: 150px;">Update</button>
                        <div class="btn btn-danger mt-2" style="width: 150px;" onclick="log_out();">Logout</div>
                    </div>
                </div>
                <div class="col-md-7 d-flex align-items-center">
                    <div class="col-12 mt-4">
                        <?php
                        if ($error != "") {
                        ?>
                            <div class="alert alert-danger mb-4" role="alert">
                                <?php echo $error ?>
                            </div>
                        <?php
                        }
                        ?>
                        <p class="opacity-75">Account Created Date : <?php echo $formattedDateTime ?></p>
                        <label class="form-label" for="fname">First Name</label>
                        <input type="text" id="fname" name="fname" value="<?php if ($first_name == "") {
                                                                                echo $user_data["fname"];
                                                                            } else {
                                                                                echo $first_name;
                                                                            } ?>" class="form-control">
                        <label class="form-label mt-2" for="lname">Last Name</label>
                        <input type="text" id="lname" name="lname" value="<?php if ($last_name == "") {
                                                                                echo $user_data["lname"];
                                                                            } else {
                                                                                echo $last_name;
                                                                            } ?>" class="form-control">
                        <label class="form-label mt-2" for="mobile">Contact Number</label>
                        <input type="text" id="mobile" name="mobile" value="<?php if ($contact_number == "") {
                                                                                echo $user_data["mobile"];
                                                                            } else {
                                                                                echo $contact_number;
                                                                            } ?>" class="form-control">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var imageInput = document.getElementById('select_dp');

    function load_image(file) {
        var file = imageInput.files[0];
        if (file) {
            var mylink = window.URL.createObjectURL(file);
            document.getElementById("dp_preview").src = mylink;
        }
    }
</script>
<?php require "../includes/footer.php" ?>