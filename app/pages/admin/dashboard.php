<h1>Statistics</h1>

<div class="row justify-content-center justify-items-center">
    <div class="col-md-4 m-1 bg-light rounded shadow border text-center">
        <h1><i class="bi bi-person-video3"></i></h1>
        <div>
            Admin
        </div>
        <?php
        $query = "select count(id) as count_admin from users where role = 'admin' ";
        $count_admin  = query_row($query);
        ?>
        <h1 class="text-primary"><?= $count_admin['count_admin'] ?? 0 ?></h1>
    </div>
    <div class="col-md-4 m-1 bg-light rounded shadow border text-center">
        <h1><i class="bi bi-person"></i></h1>
        <div>
            Users
        </div>
        <?php
        $query = "select count(id) as count_user from users ";
        $count_user  = query_row($query);
        ?>
        <h1 class="text-primary"><?= $count_user['count_user'] ?? 0 ?></h1>
    </div>
    <div class="col-md-4 m-1 bg-light rounded shadow border text-center">
        <h1><i class="bi bi-tag"></i></h1>
        <div>
            Categories
        </div>
        <?php
        $query = "select count(id) as count_category from categories ";
        $count_category  = query_row($query);
        ?>
        <h1 class="text-primary"><?= $count_category['count_category'] ?? 0 ?></h1>
    </div>
    <div class="col-md-4 m-1 bg-light rounded shadow border text-center">
        <h1><i class="bi bi-file-post"></i></h1>
        <div>
            Posts
        </div>
        <?php
        $query = "select count(id) as count_post from posts ";
        $count_post = query_row($query);
        ?>
        <h1 class="text-primary"><?= $count_post['count_post'] ?? 0 ?></h1>
    </div>
</div>