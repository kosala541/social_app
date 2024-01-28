<?php
session_start();
require "includes/connection.php";
if (isset($_GET['post_id'])) {

    $query2 = "SELECT * FROM `post` 
    INNER JOIN `user` ON `user`.`id`=`post`.`user_id` 
    WHERE `post_id`='" . $_GET['post_id'] . "' AND 
    `post_status_id`='2'";

    $result = mysqli_query($connection, $query2);
    $post_rows = mysqli_num_rows($result);

    if ($post_rows == 0) {
        header('Location:./');
    } else {
        $post_data = $result->fetch_assoc();
    }
} else {
    header('Location:./');
}
if (isset($_SESSION["user"])) {
    $query = "SELECT * FROM `user` WHERE `id`='" . $_SESSION["user"]["id"] . "' AND `user_status_id`='1'";
    $data = mysqli_query($connection, $query);
    $user_data = $data->fetch_assoc();
}

$error = "";
$post = "";
$post_img = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // print_r($_POST);

    if (isset($_POST['update'])) {

        $post = $_POST['post'];

        $folder = "assets/images/uploads/";
        $allowed = ["image/jpg", "image/jpeg", "image/png", "image/svg+xml"];
        if (!empty($_FILES['post_img']['name'])) {

            if ($_FILES['post_img']['error'] == 0) {
                if (in_array($_FILES['post_img']['type'], $allowed)) {

                    $destination = $folder . time() . $_FILES['post_img']['name'];
                    move_uploaded_file($_FILES['post_img']['tmp_name'], $destination);

                    $post_img = $destination;
                    if (file_exists($post_data["image_path"])) {
                        unlink($post_data["image_path"]);
                    }
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

            $query = "UPDATE post SET `post`='" . $post . "',
        `image_path`='" . $post_img . "',`post_status_id`='1'
         WHERE `post_id`='" . $_GET['post_id'] . "'";

            mysqli_query($connection, $query);

            header('Location:./');
        }
    }

    if (isset($_POST['delete'])) {
        $query = "DELETE FROM post WHERE `post_id`='" . $_GET['post_id'] . "'";

        mysqli_query($connection, $query);

        header('Location:./');
    }
}
?>
<?php
$title = "Edit-Post";
?>
<?php require "includes/header.php" ?>
<div class="col-md-6 offset-md-3 my-5">
    <?php
    if (isset($_SESSION["user"])) {
    ?>
        <div class="shadow shadow-sm bg-white rounded rounded-3 mb-4">
            <p class="fw-bold opacity-75 text-center fs-4 p-3 border-bottom">Edit Post</p>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="px-4 d-flex justify-content-between">
                    <a href="./"><i class="fa-solid fa-caret-left pe-1"></i>Back</a>
                    <button type="submit" name="delete" class="delete-btn">Delete this Post</button>
                </div>
                <div class="p-4 ">
                    <div class="d-flex col-12 border-bottom pb-4">
                        <img src="<?php if (isset($user_data["dp_path"])) {
                                        echo ROOT . $user_data["dp_path"];
                                    } else {
                                        echo ASSETS_ROOT . "images/user.png";
                                    } ?>" class="rounded rounded-circle" style="background-color: #B7A6D6; width: 50px; height: 50px; background-size: cover;">
                        <div class="text-center" style="width: calc(100% - 55px);">
                            <textarea class="ms-2 form-control" name="post" id="" cols="" rows="2" placeholder="What's on your mind, <?php echo $user_data["fname"] ?>?"><?php echo $post_data["post"] ?></textarea>
                        </div>
                    </div>
                    <div class="text-center">
                        <img src="<?php echo $post_data["image_path"] ?>" id="img_preview" class="img-fluid" alt="">
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
                            <img src="<?= ASSETS_ROOT ?>images/img.png" alt=""><span class="ps-2">Update post image</span>
                        </label>
                        <input type="file" name="post_img" style="display: none;" accept="image/*" id="select_img" onchange="load_image(this.files[0])">
                        <div>
                            <button type="submit" name="update" class="btn btn-primary" style="width: 150px;">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <?php
    } else {
        header('Location:signin.php');
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