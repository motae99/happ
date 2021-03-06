<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<div class="content-wrapper">
    <section class="content-header">
       

        <?=
        Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer" style="text-align: center;">
    <div class="pull-right hidden-xs">
        <b>Version</b> 0.0
    </div>
    <strong>Copyright &copy; 2018 Mo Taha.</strong> All rights
    reserved.
</footer>

