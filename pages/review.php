<?php /** @var array $pageData */ ?>

<h2>Review</h2>

<form id="form-review" method="post" action="<?= $pageData['action'] ?>">
    <table class="table table-hover">
        <tr>
            <th>Data Name</th>
            <th>Value</th>
        </tr>
        <tr>
            <td>CheckKey</td>
            <td><?= $pageData['CheckKey'] ?></td>
            <input type="hidden" name="CheckKey" value="<?= $pageData['CheckKey'] ?>"/>
        </tr>
        <?php foreach ($_POST['vpos']['fields'] as $name => $value) : ?>
            <?php if (!is_null($value) && $value != '') : ?>
                <tr>
                    <td><?= $name ?></td>
                    <td><?= $value ?></td>
                    <input type="hidden" name="<?= $name ?>" value="<?= $value ?>"/>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>

    <button type="button" onclick="history.back();return false;" class="btn btn-danger">Back</button>
    <button type="submit" class="btn btn-primary">Proceed</button>
</form>