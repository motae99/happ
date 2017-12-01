<?php
use yii\widgets\Breadcrumbs;
use kartik\growl\Growl;
// use dmstr\widgets\Alert;

?>
<div class="content-wrapper">
    <section class="content-header">
        <?php if (isset($this->blocks['content-header'])) { ?>
            <h1><?= $this->blocks['content-header'] ?></h1>
        <?php } else { ?>
            <h1>
                <?php
                // uncomment this to show page title
                // if ($this->title !== null) {
                //     echo \yii\helpers\Html::encode($this->title);
                // } else {
                //     echo \yii\helpers\Inflector::camel2words(
                //         \yii\helpers\Inflector::id2camel($this->context->module->id)
                //     );
                //     echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                // } 
                ?>
            </h1>
        <?php } ?>
            <?=
            Breadcrumbs::widget(
                [
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]
            ) ?>

    </section>

    <section class="content">
        <?php //echo Alert::widget() ?>

        <?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
            <?php
                echo Growl::widget([
                    'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
                    'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
                    'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
                    'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
                    'showSeparator' => true,
                    'delay' => 1, //This delay is how long before the message shows
                    'pluginOptions' => [
                        'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
                        'placement' => [
                            'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                            'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
                        ]
                    ]
                ]);
            ?>
        <?php endforeach; ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; <?= date('Y')?> <a href="motae99@gmail.com">Mo Taha</a>.</strong> All rights
    reserved.
</footer>
