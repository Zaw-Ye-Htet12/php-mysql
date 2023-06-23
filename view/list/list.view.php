<?php require_once ViewDir . "/template/header.php" ; ?>

<h1>List</h1>
<div class="d-flex justify-content-between mb-4">
    <a href="<?= route("list-create") ?>" class="btn btn-outline-primary">Create New</a>
</div>
<table class="table table-bordered ">
    <thead class="fw-bold text-center" >
        <th>ID</th>
        <th>Name</th>
        <th>Control</th>
        <th>Created Time</th>
        
    </thead>
    <tbody class="text-center">
        <?php foreach($lists as $list): ?>
            <tr>
                <td><?= $list['id'] ?></td>
                <td><?= $list['name'] ?></td>
                <td>
                    <form action="<?= route("list-delete") ?>" class="d-inline-block" method="post">
                        <input type="hidden" name="id" value="<?= $list['id'] ?>">
                        <input type="hidden" name="_method" value="delete">
                        <button onclick="return confirm('Are you sure to delete?')" class="btn btn-outline-danger">DELETE</button>
                    </form>
                    <a href="<?php echo route("list-update",['id' => $list['id']]); ?>" class="btn btn-outline-primary">UPDATE</a>
                </td>
                <td><?= $list['created_at'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once ViewDir . "/template/footer.php" ; ?>