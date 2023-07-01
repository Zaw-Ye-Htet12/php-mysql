<?php require_once ViewDir . "/template/header.php" ; ?>

<h1>List</h1>
<div class="d-flex justify-content-between mb-4">
    <a href="<?= route("list-create") ?>" class="btn btn-outline-primary">Create New</a>
    <form action="" method="get">
        <div class=" input-group">
            <input type="text" name="q" <?php if(isset($_GET['q'])) { ?>  value="<?= filter($_GET['q'],true) ?>"  <?php } ?>  class=" form-control">
            
            <?php if (isset($_GET['q'])) : ?>
                <a href="<?= route("list") ?>" class=" btn btn-danger">
                    Del
                </a>
            <?php endif; ?>
            <button class=" btn btn-primary">Search</button>
        </div>
    </form>
</div>
<table class="table table-bordered ">
    <thead class="fw-bold text-center" >
        <th>ID</th>
        <th>Name</th>
        <th>Control</th>
        <th>Created Time</th>
        
    </thead>
    <tbody class="text-center">
        
        <?php foreach($lists['data'] as $list): ?>
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
        <?php if(empty($lists['data'])){ ?>
            <h3 class="text-center text-primary fw-bold ">No data found</h3>
        <?php } ?>   

    </tbody>

</table>

<?php echo(paginator($lists)) ?>


<?php require_once ViewDir . "/template/footer.php" ; ?>