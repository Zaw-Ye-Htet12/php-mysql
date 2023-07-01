<?php require_once ViewDir . "/template/header.php" ; ?>

<h1>Create</h1>

<div class="d-flex justify-content-between mb-4">
    <a href="<?= route("list") ?>" class="btn btn-outline-primary">All Lists</a>
</div>

<div class="border rounded p-3">
    <form action="<?= route("list-store") ?>" method="post" class="form">
        <div class="row align-items-end">
            <div class="col">
                <label for="" class="form-label">Name</label>
                <input type="text" class="form-control" name="name"  >
            </div>
            <div class="col">
                <button class="btn btn-primary btn-lg w-50">Create</button>
            </div>
        </div>
    </form>
</div>

<?php require_once ViewDir . "/template/footer.php" ; ?>