<?php
session_start();
require "../includes/connection.php";

$query2 = "SELECT * FROM `user` WHERE `ID` !='" . $_SESSION["user"]["id"] . "'
 ORDER BY `register_date` DESC";
$result = mysqli_query($connection, $query2);
$post_rows = mysqli_num_rows($result);
?>
<?php
$title = "Manage Users";
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
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Contact Number</th>
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
                    ?>
                            <tr>
                                <th scope="row"><?php echo $x ?></th>
                                <td><?php echo $row["fname"] . " " . $row["lname"] ?></td>
                                <td><?php echo $row["email"] ?></td>
                                <td><?php echo $row["mobile"] ?></td>
                                <td><a href="edit-user.php?user_id=<?php echo $row['id'] ?>"><i class="fa-solid fa-pen-to-square text-success"></i></a></td>
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