<?php
session_start();
require "../includes/connection.php";

$query2 = "SELECT * FROM `post` 
INNER JOIN `user` ON `user`.`id`=`post`.`user_id`
 ORDER BY `date_time` DESC";
$result = mysqli_query($connection, $query2);
$post_rows = mysqli_num_rows($result);
?>

<?php
$title = "Manage Posts";
?>
<?php require "../includes/header.php" ?>

<div class="row g-0">
    <?php require "nav.php" ?>
    <div class="col-9 p-4">
        <div class="shadow shadow-sm bg-white rounded rounded-3 mb-4 p-5">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Posted user</th>
                        <th scope="col">Status</th>
                        <th scope="col">Posted Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result) {
                        $x = 0;
                        for ($i = 0; $i < $post_rows; $i++) {
                            $x = $x + 1;
                            $row = $result->fetch_assoc();

                            $status_query = "SELECT * FROM `post_status` WHERE `id`='" . $row["post_status_id"] . "'";
                            $status_result = mysqli_query($connection, $status_query);
                            $status_row = $status_result->fetch_assoc();
                    ?>
                            <tr>
                                <th scope="row"><?php echo $x ?></th>
                                <td><?php echo $row["fname"] . " " . $row["lname"] ?></td>
                                <td><?php echo $status_row["name"] ?></td>
                                <td><?php echo $row["date_time"] ?></td>
                                <td><a href="edit-post.php?post_id=<?php echo $row['post_id'] ?>"><i class="fa-solid fa-pen-to-square text-success"></i></a></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require "../includes/footer.php" ?>