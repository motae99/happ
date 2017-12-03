<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <!-- <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div> -->

        <!-- search form -->
        <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form> -->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Inventories', 'url' => ['/inventory']],
                    ['label' => 'Categories', 'icon' => 'bank', 'url' => ['/category']],
                    ['label' => 'Products', 'icon' => 'eraser', 'url' => ['/product']],
                    ['label' => 'Stocking', 'icon' => 'clone', 'url' => ['/stocking']],
                    ['label' => 'Clients', 'icon' => 'empire', 'url' => ['/client']],
                    ['label' => 'Stock', 'icon' => 'desktop', 'url' => ['/stock']],
                    ['label' => 'Invoices', 'icon' => 'fax', 'url' => ['/invoices']],
                    ['label' => 'Invoices Products', 'icon' => 'building-o', 'url' => ['/invoice-product']],
                    ['label' => 'Payments', 'icon' => 'crosshairs', 'url' => ['/payments']],
                    ['label' => 'Entry', 'icon' => 'apple', 'url' => ['/entry']],
                    ['label' => 'Transactions', 'icon' => 'circle', 'url' => ['/transaction']],
                    ['label' => 'System Accounts', 'icon' => 'car', 'url' => ['/system-account']],
                    ['label' => 'Client Accounts', 'icon' => 'filter', 'url' => ['/client-account']],

                    // ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    // ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    // ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
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
<div class="control-sidebar-bg"></div>