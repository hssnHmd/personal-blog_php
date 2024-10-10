<?php include "../app/pages/includes/header.php"; ?>


<div class="col-md-10 mx-auto mt-4">
    <h1>Search</h1>
    <div class="row mb-2">
        <?php
        $limit = 3;
        $offset = ($PAGE['page_number'] - 1) * $limit;
        $find = $_GET['find'];
        if ($find) {
            $find = "%$find%";
            $query = "select posts.*, categories.category from posts join categories on  posts.category_id = categories.id where posts.title like :find order by id desc limit $limit offset $offset";
            $posts = query($query, ['find' => $find]);
        }
        if (!empty($posts)) {
            foreach ($posts as $post) {
                include "../app/pages/includes/post-card.php";
            }
        } else {
            echo "No posts found";
        }
        ?>
    </div>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item ">
                <a class="page-link" href="<?= $PAGE['prev_link'] ?>" tabindex="-1">Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="<?= $PAGE['first_link'] ?>">First page</a></li>

            <li class="page-item">
                <a class="page-link" href="<?= $PAGE['next_link'] ?>">Next</a>
            </li>
        </ul>
    </nav>
</div>

<?php include '../app/pages/includes/footer.php'; ?>