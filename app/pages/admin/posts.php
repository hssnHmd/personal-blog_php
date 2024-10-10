<?php if ($action == "add"): ?>

    <link rel="stylesheet" href="<?= ROOT ?>/assets/summernote/summernote-lite.min.css">
    <main class="col-md-6 mx-auto">
        <form method="post" enctype="multipart/form-data">
            <h2 class="fw-normal mb-3 h3 text-center">Create post</h2>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">Please fix the errors belows</div>
            <?php endif; ?>
            <div class="mb-3 d-flex gap-2 align-items-center justify-content-center">
                <label for="formFile" class="form-label ">
                    <img class="edit_image" src="<?= get_image('') ?>" style=" cursor: pointer; width: 150px; height: 150px;border-radius: 50%; object-fit:cover; " />
                </label>
                <input onchange="display_image(this.files[0])" type="file" name="image" id="formFile" style="display: none;">

                <script>
                    function display_image(file) {
                        document.querySelector('.edit_image').src = URL.createObjectURL(file)
                    }
                </script>
            </div>

            <div class="form-floating mb-2">
                <input value="<?= old_value('title') ?>" name="title" type="text" class="form-control" id="title" placeholder="title">
                <label for="title">title</label>
            </div>
            <?php if (!empty($errors['title'])): ?>
                <div class="text-danger mb-2"><?= $errors['title'] ?></div>
            <?php endif; ?>
            <div class="form-floating mb-2">
                <textarea name="content" class="form-control" rows="10" id="summernote" placeholder="Content"><?= old_value('content') ?></textarea>
                <label for="content">Content</label>
            </div>
            <?php if (!empty($errors['content'])): ?>
                <div class="text-danger mb-2"><?= $errors['content'] ?></div>
            <?php endif; ?>
            <div class="form-floating mb-2">
                <?php
                $query = 'select * from categories order by id desc';
                $categories = query($query);
                ?>
                <select name="category_id" class="form-select">
                    <option>Select a catgory</option>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= $cat['category'] ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <label for="username">Ctegories</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Create</button>
        </form>
    </main>
    <script src="<?= ROOT ?>/assets/js/jquery.js"></script>
    <script src="<?= ROOT ?>/assets/summernote/summernote-lite.min.js"></script>
    <script>
        $('#summernote').summernote({
            placeholder: 'Post content',
            tabsize: 2,
            height: 200
        });
    </script>

<?php elseif ($action == "edit"): ?>

    <link rel="stylesheet" href="<?= ROOT ?>/assets/summernote/summernote-lite.min.css">
    <main class="col-md-12 mx-auto">
        <?php if ($row): ?>
            <form method="post" enctype="multipart/form-data">
                <h2 class="fw-normal mb-3 h3 text-center">Edit post</h2>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">Please fix the errors belows</div>
                <?php endif; ?>

                <div class="mb-3 d-flex gap-2 align-items-center justify-content-center">
                    <label for="formFile" class="form-label ">
                        <img class="edit_image" src="<?= get_image($row['image']) ?>" style=" cursor: pointer; width: 150px; height: 150px;border-radius: 50%; object-fit:cover; " />
                    </label>
                    <input onchange="display_image(this.files[0])" type="file" name="image" id="formFile" style="display: none;">

                    <script>
                        function display_image(file) {
                            document.querySelector('.edit_image').src = URL.createObjectURL(file)
                        }
                    </script>
                </div>
                <div class="form-floating mb-2">
                    <input value="<?= old_value('title', $row['title']) ?>" name="title" type="text" class="form-control" id="title" placeholder="title">
                    <label for="title">Title</label>
                </div>
                <?php if (!empty($errors['title'])): ?>
                    <div class="text-danger mb-2"><?= $errors['title'] ?></div>
                <?php endif; ?>

                <div class="form-floating mb-2">
                    <textarea name="content" id="summernote" class="form-control"><?= old_value('content', add_root_to_images($row['content'])) ?></textarea>
                    <label class="form-label" for="summernote">Content</label>
                </div>

                <?php if (!empty($errors['content'])): ?>
                    <div class="text-danger mb-2"><?= $errors['content'] ?></div>
                <?php endif; ?>
                <div class="d-flex justify-content-between mt-2">
                    <a href="<?= ROOT ?>/admin/posts">
                        <button class=" btn btn-lg btn-warning" type="button">Cancel</button>
                    </a>
                    <button class=" btn btn-lg btn-primary" type="submit">Save</button>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-warning">User not found</div>
        <?php endif; ?>
    </main>
    <script src="<?= ROOT ?>/assets/js/jquery.js"></script>
    <script src="<?= ROOT ?>/assets/summernote/summernote-lite.min.js"></script>
    <script>
        $('#summernote').summernote({
            placeholder: 'Post content',
            tabsize: 2,
            height: 200
        });
    </script>
<?php elseif ($action == "delete"): ?>
    <main class="col-md-6 mx-auto">
        <?php if (!empty($row)): ?>
            <form method="post">
                <h2 class="fw-normal mb-3 h3 text-center">Edit account</h2>

                <div class="form-floating mb-2">
                    <div class="form-control"><?= old_value('title', $row['title']) ?></div>
                </div>
                <div class="form-floating mb-2">
                    <div class="form-control"><?= old_value('category_id', $row['category_id']) ?></div>

                </div>
                <div class="d-flex justify-content-between mt-2">
                    <a href="<?= ROOT ?>/admin/posts">
                        <button class=" btn btn-lg btn-warning" type="button">Cancel</button>
                    </a>
                    <button class=" btn btn-lg btn-danger" type="submit">Delete</button>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-warning">User not found</div>
        <?php endif; ?>
    </main>
<?php else: ?>


    <div class="d-flex justify-content-between">
        <h2>Posts table</h2>
        <a href="<?= ROOT ?>/admin/posts/add">
            <button class="btn-primary btn">Add Post</button>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Date</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <?php
            $limit = 10;
            $offset = ($PAGE['page_number'] - 1) * $limit;
            $query = "select * from posts order by id desc limit $limit offset $offset";
            $rows = query($query);

            ?>
            <tbody>
                <?php if (!empty($rows)): ?>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= esc($row['title']) ?></td>
                            <td><?= $row['slug'] ?></td>
                            <td><?= date("jS M, Y", strtotime($row['date'])) ?></td>
                            <td>
                                <img src="<?= get_image($row['image']) ?>" style="width: 50px; height: 50px;border-radius: 50%; object-fit:cover; " />
                            </td>
                            <td>
                                <a href="<?= ROOT ?>/admin/posts/edit/<?= $row['id'] ?>">
                                    <button class="btn btn-outline-success"><i class="bi bi-pencil-fill"></i></button>
                                </a>
                                <a href="<?= ROOT ?>/admin/posts/delete/<?= $row['id'] ?>">
                                    <button class="btn btn-outline-danger"><i class="bi bi-archive-fill"></i></button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>NO Data available</tr>
                <?php endif; ?>
            </tbody>
        </table>
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
<?php endif; ?>