<div class="col-md-6">

    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-primary"><?= $post['category'] ?></strong>
            <a href="<?= ROOT ?>/post-detail/<?= $post['slug'] ?>">
                <h3 class="mb-1"><?= esc($post['title']) ?></h3>
            </a>
            <div class="mb-1 text-muted"><?= date('jS M, Y', strtotime($post['date'])) ?></div>
            <a href="<?= ROOT ?>/post-detail/<?= $post['slug'] ?>" class="stretched-link">Continue reading</a>
        </div>
        <div class=" col-lg-5 col-12 d-lg-block">
            <a href="<?= ROOT ?>/post-detail/<?= $post['slug'] ?>">
                <img src="<?= get_image($post['image']) ?>" class=" w-100 " style="object-fit: cover;" height="250" alt="...">
            </a>
        </div>
    </div>
</div>