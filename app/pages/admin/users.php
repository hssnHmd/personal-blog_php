<?php if ($action == "add"): ?>
    <main class="col-md-6 mx-auto">
        <form method="post" enctype="multipart/form-data">
            <h2 class="fw-normal mb-3 h3 text-center">Create account</h2>
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
                <input value="<?= old_value('username') ?>" name="username" type="text" class="form-control" id="username" placeholder="username">
                <label for="username">User name</label>
            </div>
            <?php if (!empty($errors['username'])): ?>
                <div class="text-danger mb-2"><?= $errors['username'] ?></div>
            <?php endif; ?>
            <div class="form-floating mb-2">
                <select name="role" class="form-select">
                    <option <?= old_selected("role", 'admin') ?> value="admin">Admin</option>
                    <option <?= old_selected("role", 'user') ?> value="user">User</option>
                </select>
                <label for="username">Role</label>
            </div>
            <?php if (!empty($errors['role'])): ?>
                <div class="text-danger mb-2"><?= $errors['role'] ?></div>
            <?php endif; ?>
            <div class="form-floating mb-2">
                <input value="<?= old_value('email') ?>" name="email" type="email" class="form-control" id="email" placeholder="name@example.com">
                <label for="email">Email address</label>
            </div>
            <?php if (!empty($errors['email'])): ?>
                <div class="text-danger mb-2"><?= $errors['email'] ?></div>
            <?php endif; ?>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
            <?php if (!empty($errors['password'])): ?>
                <div class="text-danger mb-2"><?= $errors['password'] ?></div>
            <?php endif; ?>
            <div class="form-floating">
                <input type="password" class="form-control" name="retype_password" id="retype_password" placeholder="Password confirmation">
                <label for="retype_password">Conform password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Create</button>
        </form>
    </main>

<?php elseif ($action == "edit"): ?>
    <main class="col-md-6 mx-auto">
        <?php if ($row): ?>
            <form method="post" enctype="multipart/form-data">
                <h2 class="fw-normal mb-3 h3 text-center">Edit account</h2>
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
                    <input value="<?= old_value('username', $row['username']) ?>" name="username" type="text" class="form-control" id="username" placeholder="username">
                    <label for="username">User name</label>
                </div>
                <?php if (!empty($errors['username'])): ?>
                    <div class="text-danger mb-2"><?= $errors['username'] ?></div>
                <?php endif; ?>
                <div class="form-floating mb-2">
                    <select name="role" class="form-select">
                        <option <?= old_selected("role", 'admin', $row['role']) ?> value="admin">Admin</option>
                        <option <?= old_selected("role", 'user', $row['role']) ?> value="user">User</option>
                    </select>
                    <label for="username">Role</label>
                </div>
                <?php if (!empty($errors['role'])): ?>
                    <div class="text-danger mb-2"><?= $errors['role'] ?></div>
                <?php endif; ?>
                <div class="form-floating mb-2">
                    <input value="<?= old_value('email', $row['email']) ?>" name="email" type="email" class="form-control" id="email" placeholder="name@example.com">
                    <label for="email">Email address</label>
                </div>
                <?php if (!empty($errors['email'])): ?>
                    <div class="text-danger mb-2"><?= $errors['email'] ?></div>
                <?php endif; ?>
                <div class="form-floating mb-2">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    <label for="password">Password</label>
                </div>
                <?php if (!empty($errors['password'])): ?>
                    <div class="text-danger mb-2"><?= $errors['password'] ?></div>
                <?php endif; ?>
                <div class="form-floating">
                    <input type="password" class="form-control" name="retype_password" id="retype_password" placeholder="Password confirmation">
                    <label for="retype_password">Conform password</label>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <a href="<?= ROOT ?>/admin/users">
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
                    <div class="form-control"><?= old_value('username', $row['username']) ?></div>
                </div>
                <div class="form-floating mb-2">
                    <div class="form-control"><?= old_value('email', $row['email']) ?></div>

                </div>
                <div class="d-flex justify-content-between mt-2">
                    <a href="<?= ROOT ?>/admin/users">
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
        <h2>Users table</h2>
        <a href="<?= ROOT ?>/admin/users/add">
            <button class="btn-primary btn">Add user</button>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Image</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <?php
            $limit = 10;
            $offset = ($PAGE['page_number'] - 1) * $limit;
            $query = "select * from users order by id desc limit $limit offset $offset";
            $rows = query($query);

            ?>
            <tbody>
                <?php if (!empty($rows)): ?>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= esc($row['username']) ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['role'] ?></td>
                            <td>
                                <img src="<?= get_image($row['image']) ?>" style="width: 50px; height: 50px;border-radius: 50%; object-fit:cover; " />
                            </td>
                            <td><?= date("jS M, Y", strtotime($row['date'])) ?></td>
                            <td>
                                <a href="<?= ROOT ?>/admin/users/edit/<?= $row['id'] ?>">
                                    <button class="btn btn-outline-success"><i class="bi bi-pencil-fill"></i></button>
                                </a>
                                <a href="<?= ROOT ?>/admin/users/delete/<?= $row['id'] ?>">
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