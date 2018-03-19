<?php use yii\helpers\Html; ?>
<?php if(Yii::$app->language == 'ar'): ?> <!-- Add RTL css for supporting Arabic Language -->
	<!-- Bootstrap 3.3.5 RTL -->
	<link rel="stylesheet" href="<?= Yii::getAlias('@web'); ?>/css/ar/bootstrap-rtl.min.css"> 
	<!-- Theme RTL style -->
	<link rel="stylesheet" href="<?= Yii::getAlias('@web'); ?>/css/ar/AdminLTE-rtl.css">

<?php  

$this->registerCss('

		body {
	    	font-family: ArabicKufi, serif !important;
		}

		h1 {
	    	font-family: ArabicKufi, serif !important;
		}
		h2 {
	    	font-family: ArabicKufi, serif !important;
		}
		h3 {
	    	font-family: ArabicKufi, serif !important;
		}
		h4 {
	    	font-family: ArabicKufi, serif !important;
		}
		h5 {
	    	font-family: ArabicKufi, serif !important;
		}
		h6 {
	    	font-family: ArabicKufi, serif !important;
		}

		.sidebar-mini.sidebar-collapse .content-wrapper, .sidebar-mini.sidebar-collapse .right-side, .sidebar-mini.sidebar-collapse .main-footer {
		    margin-left: 0px !important;
		}

		#anchor {
			float: right;
		}
		input[type], textarea {
			direction: rtl;
		}
		.box-title {
			float:right !important;
			/*padding:0 !important;*/
		}
		.box.box-solid .box-title {
			float:right !important;
			padding:5px !important;
		}
		.eArLangCss {
			float:right !important;
		}
		.edusecArLangHide {
			display:none !important;
		}
		.table.detail-view th {
			float:right !important;
		}
		.close {
			float:left !important;
		}
		.highcharts-legend-item text, text {
			direction:ltr;
		}
		.table th {
			text-align: right !important;
		}
		.table td {
			text-align: right !important;
		}
		.popover {
			width:300px;
		}
		.nav-tabs > li {
			float: right;
		}
		.select2-search-choice-close {
			right: unset !important;
		}
		.edusecArLangPopover {
			width: 6.667% !important;
		}
		
');

endif; ?>
