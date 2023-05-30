<?php /** @var array $pageData */ ?>

<h2>Result</h2>

<div class="mb-2">
    <?php if ($pageData['success']) : ?>
        <span class="label label-success">Payment Success</span>
    <?php else : ?>
        <span class="label label-danger">Payment Failed</span>
        <br />
        <br />
        <p><?= $pageData['errorMessage'] ?></p>
    <?php endif; ?>
    <br />
    <br />
</div>
<div class="table-responsive">
    <table class="table">
        <tr>
            <td colspan="2">
                <h1>POST Parameters</h1>
            </td>
        </tr>
        <tr>
            <td style="text-align: right"><b>Name</b></td>
            <td style="text-align: left"><b>Value</b></td>
        </tr>
        <?php foreach ($_POST as $key => $value) : ?>
            <tr>
                <td><?= $key; ?></td>
                <td><?= $value; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>