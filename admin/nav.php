<div class="col-3 vh-100 bg-white">
    <div class="p-3">
        <div class="d-flex justify-content-between align-items-center">
            <a href="<?= ROOT ?>" class="text-decoration-none text-dark fs-2 fw-bold opacity-75"><img src="<?= LOGO ?>" class="img-fluid me-2" style="width: 50px;" alt="">Home</a>
            <a href="#" onclick="log_out();"><i class="fs-4 fa-solid fa-right-from-bracket text-danger opacity-75"></i></a>
        </div>
        <div class="list-group mt-4">
            <a href="<?= ROOT ?>admin" class="list-group-item list-group-item-secondary list-group-item-action <?php if ($title == "Dashboard") {
                                                                                                                    echo "active";
                                                                                                                } ?>">Dashboard</a>
            <a href="<?= ROOT ?>admin/manage-posts.php" class="list-group-item list-group-item-secondary list-group-item-action <?php if ($title == "Manage Posts") {
                                                                                                                                    echo "active";
                                                                                                                                } ?>">Manage Posts</a>
            <a href="<?= ROOT ?>admin/manage-users.php" class="list-group-item list-group-item-secondary list-group-item-action <?php if ($title == "Manage Users") {
                                                                                                                                    echo "active";
                                                                                                                                } ?>">Mange Users</a>
            <a href="<?= ROOT ?>admin/profile.php" class="list-group-item list-group-item-secondary list-group-item-action <?php if ($title == "Profile") {
                                                                                                                                echo "active";
                                                                                                                            } ?>">Profile</a>
        </div>
    </div>
</div>