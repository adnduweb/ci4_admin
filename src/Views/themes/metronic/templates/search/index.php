<?php if(!empty($resultSearch)) : ?>

    <?php foreach($resultSearch as $k => $v) : ?>

    <?php  $namespace = stristr($k, 'Models', true); ?>

        <?= view($namespace . 'Views\themes\metronic\search', ['items' => $v]); ?>

    <?php endforeach; ?>

<?php endif; ?>
