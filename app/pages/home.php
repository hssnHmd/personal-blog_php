<?php include "../app/pages/includes/header.php"; ?>

<?php
if ($url[0] == 'home')
    include "../app/pages/includes/slider.php";
?>
<div class="container p-4">
    <h1>Featured</h1>
    <div class="row mb-2">
        <?php
        $query = 'select posts.*, categories.category from posts join categories on  posts.category_id = categories.id order by id desc';
        $posts = query($query);
        if (!empty($posts)) {
            foreach ($posts as $post) {
                include "../app/pages/includes/post-card.php";
            }
        } else {
            echo "No posts found";
        }
        ?>
    </div>
</div>

<?php include '../app/pages/includes/footer.php'; ?>