<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Yii::getAlias('@web')?>/data/mine.png" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Mo Taha</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    // ['label' => 'Menu Options', 'options' => ['class' => 'header']],
                    // ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    // ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    // ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => Yii::t('app', 'المؤسسات'), 'icon' => 'hospital-o', 'url' => ['/clinic']],
                    // ['label' => Yii::t('app', 'Specialization'), 'icon' => 'sitemap', 'url' => ['/specialization']],
                    ['label' => Yii::t('app', 'الأطباء'), 'icon' => 'user-md', 'url' => ['/physician']],
                    ['label' => Yii::t('app', 'شركات التأمين'), 'icon' => 'h-square', 'url' => ['/insurance']],
                    ['label' => Yii::t('app', 'الحجوزات'), 'icon' => 'heartbeat', 'url' => ['/register']],
                    ['label' => Yii::t('app', 'الصيدليات'), 'icon' => 'medkit', 'url' => ['/pharmacy']],
                    ['label' => Yii::t('app', 'المعامل'), 'icon' => 'plus-square', 'url' => ['/lab']],
                    ['label' => Yii::t('app', 'شركات الاسعاف'), 'icon' => 'ambulance', 'url' => ['/ambulance']],
                    ['label' => Yii::t('app', 'طلبات الاسعاف'), 'icon' => 'wheelchair', 'url' => ['/ambulance/request']],
                    ['label' => Yii::t('app', 'الخدمات والأعلان'), 'icon' => 'home', 'url' => ['/services']],
                   
                    // [
                    //     'label' => 'Same tools',
                    //     'icon' => 'share',
                    //     'url' => '#',
                    //     'items' => [
                    //         ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                    //         ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                    //         [
                    //             'label' => 'Level One',
                    //             'icon' => 'circle-o',
                    //             'url' => '#',
                    //             'items' => [
                    //                 ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                    //                 [
                    //                     'label' => 'Level Two',
                    //                     'icon' => 'circle-o',
                    //                     'url' => '#',
                    //                     'items' => [
                    //                         ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                    //                         ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                    //                     ],
                    //                 ],
                    //             ],
                    //         ],
                    //     ],
                    // ],
                ],
            ]
        ) ?>

    </section>

</aside>
