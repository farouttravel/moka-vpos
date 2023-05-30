<?php /** @var array $pageData */ ?>

<form method="post" class="form-horizontal" action="/?p=review">
    <h2>
        TXN Type: <?= array_key_exists('t', $_GET) ? $_GET['t'] : ""; ?>
    </h2>
    <br/>

    <input type="hidden" name="vpos[action]" value="<?= $pageData['action'] ?>"/>

    <?php foreach ($pageData['parameters'] as $name => $value) : ?>
        <div class="form-group form-group-sm">
            <label class="col-sm-3 control-label" for="<?= $name ?>Id"><?= $name ?></label>
            <div class="col-sm-9">
                <input
                        type="text"
                        class="form-control"
                        name="<?= 'vpos[fields][' . $name . ']' ?>"
                        value="<?= array_key_exists($name, $pageData['dummyData']) ? $pageData['dummyData'][$name] : $value ?>"
                        id="<?= $name ?>Id"
                />
            </div>
        </div>
    <?php endforeach; ?>

    <input type="submit" class="btn btn-primary" value="Review"/>
</form>