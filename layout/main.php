<?php /** @var \Vpos\Core $app */ ?>

<?php include_once 'header.php'; ?>

<div class="container">
    <div class="row page-header text-left">
        <h1>moka Test Scripts</h1>
        <nav class="text-left">
            <a href="/">List</a>
        </nav>
    </div>

    <div class="row">
        <div class="col-12">
            <?php $app->load(); ?>
        </div>
    </div>
</div>

<?php include_once 'footer.php'; ?>