<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Client Accounts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-account-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $note = Yii::$app->fcm->createNotification("test title", "testing body");
        $note->setIcon('notification_icon_resource_name')
            ->setColor('#ffffff')
            ->setBadge(1);

        $message = Yii::$app->fcm->createMessage();
        $message->addRecipient(new \paragraph1\phpFCM\Recipient\Device('dPt-kKrTUgg:APA91bFaZdVYMROmh9ueT3KZ2HgJcw0xnQw8qGadnnY4JSi9XXioB-_TYRG25qTPOJ1JrPmlkCoRehi_Z1SGtTFlPk0j64y1fQdnORGi8EWfCxhXqTIwBuw5IN1Vf2_OMSiCQ7PM_gOL'));
        $message->setNotification($note)
            ->setData(['someId' => 111]);

        $response = Yii::$app->fcm->send($message);
        var_dump($response->getStatusCode());
    ?>

    

</div>
