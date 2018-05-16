<?php 
use mdm\admin\components\MenuHelper;
use mdm\admin\components\Helper;
use yii\bootstrap\Nav;
?>
<aside class="main-sidebar">

    <section class="sidebar">


        <?php $menuItems = [
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => Yii::t('app', 'المؤسسات'), 'icon' => 'hospital-o', 'url' => ['/clinic']],
                    ['label' => Yii::t('app', 'الأطباء'), 'icon' => 'user-md', 'url' => ['/physician']],
                    ['label' => Yii::t('app', 'شركات التأمين'), 'icon' => 'h-square', 'url' => ['/insurance']],
                    ['label' => Yii::t('app', 'الحجوزات'), 'icon' => 'heartbeat', 'url' => ['/register']],
                    ['label' => Yii::t('app', 'الصيدليات'), 'icon' => 'medkit', 'url' => ['/pharmacy']],
                    ['label' => Yii::t('app', 'المعامل'), 'icon' => 'plus-square', 'url' => ['/lab']],
                    ['label' => Yii::t('app', 'شركات الاسعاف'), 'icon' => 'ambulance', 'url' => ['/ambulance']],
                    ['label' => Yii::t('app', 'طلبات الاسعاف'), 'icon' => 'wheelchair', 'url' => ['/ambulance/request']],
                    ['label' => Yii::t('app', 'الخدمات والأعلان'), 'icon' => 'home', 'url' => ['/services']],
                   

                    // doctors
                    ['label' => 'اليوم', 'icon' => 'home', 'url' => ['doctor/index']],
                    ['label' => "التقارير", 'icon' => 'dashboard', 'url' => ['doctor/report']],
                    ['label' => 'الاعدادات', 'icon' => 'gear', 'url' => ['doctor/setting']],
                    

                    // medicals
                    ['label' => "التقارير", 'icon' => 'dashboard', 'url' => ['medical/report']],
                    // ['label' => 'اليوم', 'icon' => 'home', 'url' => ['medical/index']],
                    ['label' => 'الاعدادات', 'icon' => 'gear', 'url' => ['medical/setting']],
                    
                ];
            
        $menuItems = Helper::filter($menuItems);
        
        echo dmstr\widgets\Menu::widget([
            'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
            'items' => $menuItems,
        ]);
        ?>

    </section>

</aside>
