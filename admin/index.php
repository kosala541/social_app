<?php
session_start();
require "../includes/connection.php";

$query1 = "SELECT * FROM `post`";
$result1 = mysqli_query($connection, $query1);
$all_post = mysqli_num_rows($result1);

$query2 = "SELECT * FROM `post` WHERE `post_status_id`='1'";
$result2 = mysqli_query($connection, $query2);
$pending_post = mysqli_num_rows($result2);

$query3 = "SELECT * FROM `user`";
$result3 = mysqli_query($connection, $query3);
$all_users = mysqli_num_rows($result3);


$title = "Dashboard";
?>
<?php require "../includes/header.php" ?>

<div class="row g-0">
    <?php require "nav.php" ?>
    <div class="col-9 p-4">
        <div class="shadow shadow-sm bg-white rounded rounded-3 mb-4 p-5">
            <div class="row">
                <div class="col-4">
                    <div class="d-flex justify-content-between align-items-center p-2 border border-1 rounded rounded-2">
                        <div class="d-flex align-items-center opacity-75">
                            <i class="fa-solid fa-list-check fs-3"></i>
                            <span class="fw-bold fs-5 ms-2">All Post</span>
                        </div>
                        <span class="fw-bold fs-3"><?php echo $all_post ?></span>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex justify-content-between align-items-center p-2 border border-1 rounded rounded-2">
                        <div class="d-flex align-items-center opacity-75">
                            <i class="fa-solid fa-hourglass-half fs-3"></i>
                            <span class="fw-bold fs-5 ms-2">Pending Post</span>
                        </div>
                        <span class="fw-bold fs-3"><?php echo $pending_post ?></span>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex justify-content-between align-items-center p-2 border border-1 rounded rounded-2">
                        <div class="d-flex align-items-center opacity-75">
                            <i class="fa-solid fa-users fs-3"></i>
                            <span class="fw-bold fs-5 ms-2">All Users</span>
                        </div>
                        <span class="fw-bold fs-3"><?php echo $all_users ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "../includes/footer.php" ?>