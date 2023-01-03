<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 text-center">Add Shortlink</h4>
                <form action="<?= site_url('admin/links/add') ?>" method="post" autocomplete="off">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Text</label>
                                <input type="text" class="form-control" name="name" placeholder="Name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Api Url</label>
                                <b>Example: https://abc.xyz/api?api=qwerty&url={url}</b>
                                <input type="text" class="form-control" name="url" placeholder="Format: https://abc.xyz/api?api=qwerty&url={url}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Reward</label>
                                <input type="number" class="form-control" name="reward" placeholder="Reward" min="0.00001" step="0.00001">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Energy Reward</label>
                                <input type="number" class="form-control" name="energy_reward" placeholder="Energy Reward for each view">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>View Per Day</label>
                                <input type="number" class="form-control" name="view_per_day" placeholder="Max view per day">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                    <button type="submit" class="btn btn-success btn-lg btn-block"><i class="fas fa-check"></i> Add</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Your links</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">API Url</th>
                                <th scope="col">Reward</th>
                                <th scope="col">Energy Reward</th>
                                <th scope="col">View per Day</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($links as $link) { ?>
                                <form action="<?= site_url('/admin/links/update/' . $link['id']) ?>" method="POST">
                                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
                                    <tr>
                                        <th scope="row"><?= $link['id'] ?></th>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="name" value="<?= $link['name'] ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="url" value="<?= $link['url'] ?>">
                                            </div>

                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="number" class="form-control" name="reward" value="<?= $link['reward'] ?>" min="0.00001" step="0.00001">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="number" class="form-control" name="energy_reward" value="<?= $link['energy_reward'] ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="number" class="form-control" name="view_per_day" value="<?= $link['view_per_day'] ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <button type="submit" class="edit-button btn btn-warning btn-sm">edit</button>
                                            <a class="btn btn-danger btn-sm" href="<?= site_url('admin/links/delete/' . $link['id']) ?>">delete</a>
                                        </td>
                                    </tr>
                                </form>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>