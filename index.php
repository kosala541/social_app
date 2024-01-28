<?php
session_start();
require "includes/connection.php";
if (isset($_SESSION["user"])) {
    $query = "SELECT * FROM `user` WHERE `id`='" . $_SESSION["user"]["id"] . "' AND `user_status_id`='1'";
    $data = mysqli_query($connection, $query);
    $user_data = $data->fetch_assoc();
}

$query2 = "SELECT * FROM `post` 
INNER JOIN `user` ON `user`.`id`=`post`.`user_id` 
WHERE `post_status_id`='2' ORDER BY `date_time` DESC";
$result = mysqli_query($connection, $query2);
$post_rows = mysqli_num_rows($result);

$error = "";
$post = "";
$post_img = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // print_r($_POST);

    $post = $_POST['post'];

    $folder = "assets/images/uploads/";
    $allowed = ["image/jpg", "image/jpeg", "image/png", "image/svg+xml"];
    if (!empty($_FILES['post_img']['name'])) {

        if ($_FILES['post_img']['error'] == 0) {
            if (in_array($_FILES['post_img']['type'], $allowed)) {

                $destination = $folder . time() . $_FILES['post_img']['name'];
                move_uploaded_file($_FILES['post_img']['tmp_name'], $destination);

                $post_img = $destination;
            } else {
                $error = "This file type is not allowed";
            }
        } else {
            $error = "Could not upload image";
        }
    }

    if (empty($post) && empty($post_img)) {
        $error = "Please enter your post details";
    } else {
        $error = "";

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        $query = "INSERT INTO post (`post`,`image_path`,`date_time`,`user_id`,`post_status_id`)
        VALUES ('" . $post . "','" . $post_img . "','" . $date . "','" . $_SESSION["user"]["id"] . "','1')";

        mysqli_query($connection, $query);

        header('Location:./');
    }
}
?>
<?php
$title = "Home";
?>
<?php require "includes/header.php" ?>
<?php require "includes/nav.php" ?>
<div class="col-md-6 offset-md-3 my-5">
    <?php
    if (isset($_SESSION["user"])) {
    ?>
        <div class="shadow shadow-sm bg-white rounded rounded-3 mb-4">
            <p class="fw-bold opacity-75 text-center fs-4 p-3 border-bottom">Create Post</p>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="p-4 ">
                    <div class="d-flex col-12 border-bottom pb-4">
                        <img src="<?php if (isset($user_data["dp_path"])) {
                                        echo ROOT . $user_data["dp_path"];
                                    } else {
                                        echo ASSETS_ROOT . "images/user.png";
                                    } ?>" class="rounded rounded-circle" style="background-color: #B7A6D6; width: 50px; height: 50px; background-size: cover;">
                        <div class="text-center" style="width: calc(100% - 55px);">
                            <textarea class="ms-2 form-control" name="post" id="" cols="" rows="2" placeholder="What's on your mind, <?php echo $user_data["fname"] ?>?"></textarea>
                        </div>
                    </div>
                    <div class="text-center">
                        <img src="" id="img_preview" class="img-fluid" alt="">
                    </div>
                    <?php
                    if ($error != "") {
                    ?>
                        <div class="alert alert-danger mb-4" role="alert">
                            <?php echo $error ?>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <label for="select_img" style="cursor: pointer;">
                            <img src="<?= ASSETS_ROOT ?>images/img.png" alt=""><span class="ps-2">Add an image to your post</span>
                        </label>
                        <input type="file" name="post_img" style="display: none;" accept="image/*" id="select_img" onchange="load_image(this.files[0])">
                        <div>
                            <button type="submit" class="btn btn-primary" style="width: 150px;">Post</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <?php
    }
    ?>
    <?php
    if ($result) {
        for ($i = 0; $i < $post_rows; $i++) {
            $row = $result->fetch_assoc();

            $dateTime = new DateTime($row["date_time"]);
            $formattedDateTime = $dateTime->format('Y-m-d');
    ?>
            <div class="shadow shadow-sm bg-white rounded rounded-3 mb-4 p-3">
                <div class="d-flex justify-content-between pb-2 border-bottom">
                    <div class="d-flex">
                        <img src="<?php if (isset($row["dp_path"])) {
                                        echo ROOT . $row["dp_path"];
                                    } else {
                                        echo ASSETS_ROOT . "images/user.png";
                                    } ?>" class="rounded rounded-circle" style="background-color: #B7A6D6; width: 40px; height: 40px; background-size: cover;">
                        <div class="ps-2">
                            <p class="m-0" style="font-weight: 500;"><?php echo $row["fname"] . " " . $row["lname"] ?></p>
                            <p class="m-0 opacity-75" style="font-size: 12px;"><?php echo $formattedDateTime ?></p>
                        </div>
                    </div>
                    <?php
                    if (isset($_SESSION["user"])) {
                        if ($row["id"] == $_SESSION["user"]["id"]) {
                    ?>
                            <div class="d-flex align-items-center">
                                <button class="edit-btn me-2" onclick="window.location='edit-post.php?post_id=<?php echo $row['post_id'] ?>'">Edit</button>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <div class="mt-2">
                    <?php echo $row["post"] ?>
                </div>
                <div class="mt-2 text-center">
                    <img src="<?php echo $row["image_path"] ?>" class="img-fluid" alt="">
                </div>
            </div>
    <?php
        }
    }
    ?>

</div>
<script>
    var imageInput = document.getElementById('select_img');

    function load_image(file) {
        var file = imageInput.files[0];
        if (file) {
            var mylink = window.URL.createObjectURL(file);
            document.getElementById("img_preview").src = mylink;
        }
    }
</script>
<?php require "includes/footer.php" ?>