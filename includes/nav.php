<div class="text-center bg-white shadow shadow-sm d-flex justify-content-center top-bar sticky-top">
    <div class="p-3 px-5 pb-2"><a href="<?= ROOT ?>"><img src="<?= ASSETS_ROOT ?>images/favicon.png" class="img-fluid" width="35" alt=""></a></div>
    <div class="p-3 px-5 pb-2 <?php if ($title == "Home") {
                                    echo "active";
                                } ?>"><a href="<?= ROOT ?>"><i class="fs-4 fa-solid fa-house fa-fw"></i></a></div>
    <?php
    if (isset($_SESSION["user"])) {
    ?>
        <div class="p-3 px-5 pb-2 <?php if ($title == "Profile") {
                                        echo "active";
                                    } ?>"><a href="<?php if ($_SESSION["user"]["user_type_id"] == 1) {
                                                        echo ROOT . "admin";
                                                    } else {
                                                        echo ROOT . "user";
                                                    }
                                                    ?>"><i class="fs-4 fa-solid fa-user fa-fw"></i></a></div>
    <?php
    } else {
    ?>
        <div class="p-3 px-5 pb-2"><a href="<?= ROOT ?>signin.php" class="btn btn-success text-white" style="width: 100px;">Signin</a></div>
    <?php
    }
    ?>

</div>