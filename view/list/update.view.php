<?php require_once ViewDir . "/template/header.php" ; ?>


<h1>Edit</h1>


<div class="border rounded p-3">
    <form action="<?= route("list-edit") ?>" method="post" class="form">
        <input type="hidden" name="_method" value="put">
        <input type="hidden" name="id" value="<?= $list['id'] ?>">

        <div class="row align-items-end">
            <div class="col">
                <label for="" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="<?= $list['name'] ?>">
            </div>
            <div class="col">
                <button class="btn btn-primary btn-lg w-50">Edit</button>
            </div>
        </div>
    </form>
</div>




<?php require_once ViewDir . "/template/footer.php" ; ?>
