<?php if ($action == "add"): ?>
    <main class="col-md-6 mx-auto">
        <form method="post" enctype="multipart/form-data">
            <h2 class="fw-normal mb-3 h3 text-center">Create Category</h2>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">Please fix the errors belows</div>
            <?php endif; ?>
            <div class="form-floating mb-2">
                <input value="<?= old_value('category') ?>" name="category" type="text" class="form-control" id="category" placeholder="category">
                <label for="category">Category</label>
            </div>
            <?php if (!empty($errors['category'])): ?>
                <div class="text-danger mb-2"><?= $errors['category'] ?></div>
            <?php endif; ?>
            <div class="form-floating mb-2">
                <select name="disabled" class="form-select">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                <label for="username">Active</label>
            </div>
            <?php if (!empty($errors['disabled'])): ?>
                <div class="text-danger mb-2"><?= $errors['disabled'] ?></div>
            <?php endif; ?>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Create</button>
        </form>
    </main>

<?php elseif ($action == "edit"): ?>
    <main class="col-md-6 mx-auto">
        <?php if ($row): ?>
            <form method="post">
                <h2 class="fw-normal mb-3 h3 text-center">Edit Category</h2>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">Please fix the errors belows</div>
                <?php endif; ?>
                <div class="form-floating mb-2">
                    <input value="<?= old_value('category', $row['category']) ?>" name="category" type="text" class="form-control" id="category" placeholder="category">
                    <label for="category">User name</label>
                </div>
                <?php if (!empty($errors['category'])): ?>
                    <div class="text-danger mb-2"><?= $errors['category'] ?></div>
                <?php endif; ?>
                <div class="form-floating mb-2">
                    <select name="disabled" class="form-select">
                        <option <?= old_selected("disabled", '1', $row['disabled']) ?> value="1">Yes</option>
                        <option <?= old_selected("disabled", '0', $row['disabled']) ?> value="0">No</option>
                    </select>
                    <label for="username">Active</label>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <a href="<?= ROOT ?>/admin/categories">
                        <button class=" btn btn-lg btn-warning" type="button">Cancel</button>
                    </a>
                    <button class=" btn btn-lg btn-primary" type="submit">Save</button>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-warning">User not found</div>
        <?php endif; ?>
    </main>
<?php elseif ($action == "delete"): ?>
    <main class="col-md-6 mx-auto">
        <?php if (!empty($row)): ?>
            <form method="post">
                <h2 class="fw-normal mb-3 h3 text-center">Edit account</h2>

                <div class="form-floating mb-2">
                    <div class="form-control"><?= old_value('category', $row['category']) ?></div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <a href="<?= ROOT ?>/admin/categories">
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
        <h2>Categories table</h2>
        <a href="<?= ROOT ?>/admin/categories/add">
            <button class="btn-primary btn">Add Catgory</button>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Category</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Active</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <?php
            $limit = 10;
            $offset = ($PAGE['page_number'] - 1) * $limit;
            $query = "select * from categories order by id desc limit $limit offset $offset";
            $rows = query($query);

            ?>
            <tbody>
                <?php if (!empty($rows)): ?>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= esc($row['category']) ?></td>
                            <td><?= $row['slug'] ?></td>
                            <td><?= $row['disabled'] ? "active" : "not active" ?></td>
                            <td>
                                <a href="<?= ROOT ?>/admin/categories/edit/<?= $row['id'] ?>">
                                    <button class="btn btn-outline-success"><i class="bi bi-pencil-fill"></i></button>
                                </a>
                                <a href="<?= ROOT ?>/admin/categories/delete/<?= $row['id'] ?>">
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