<?php include "../app/pages/includes/header.php"; ?>


<div class="col-md-10 mx-auto mt-4">
    <h1>Blog</h1>
    <div class="row mb-2">
        <?php
        $slug = $url[1] ?? null;

        if ($slug) {
            $query = "select posts.*, categories.category from posts join categories on  posts.category_id = categories.id where posts.slug = :slug order by id desc ";
            $post = query_row($query, ['slug' => $slug]);
        }
        ?>
        <?php if (!empty($post)): ?>
            <div class="col-md- mx-auto">
                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
                    <div class=" col-12 d-lg-block">
                        <a href="<?= ROOT ?>/post-detail/<?= $post['slug'] ?>">
                            <img src="<?= get_image($post['image']) ?>" class=" w-100 " style="object-fit: cover;" alt="...">
                        </a>
                    </div>
                    <div class="col p-4 d-flex flex-column position-static">
                        <strong class="d-inline-block mb-2 text-primary"><?= $post['category'] ?></strong>
                        <a href="<?= ROOT ?>/post-detail/<?= $post['slug'] ?>">
                            <h3 class="mb-1"><?= esc($post['title']) ?></h3>
                        </a>
                        <div class="mb-1 text-muted"><?= date('jS M, Y', strtotime($post['date'])) ?></div>
                        <p class="card-text mb-auto"><?= (nl2br(add_root_to_images($post['content']))) ?></p>

                    </div>

                </div>

            </div>
        <?php else: ?>
            <center>No post found</center>
        <?php endif; ?>
    </div>

</div>

<?php include '../app/pages/includes/footer.php'; ?>