<?php

/**
 * Class used for export data in PDF Formate.
 * 
 * @package EduSec.components 
 */

namespace app\components;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException; 
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

use \Mpdf\Mpdf;

 
class ExportToPdf extends Component
{
	public function exportData($title='',$filename='Pdf',$html, $level='', $subject='')
	{	
		// $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
		// $fontDirs = $defaultConfig['fontDir'];

		// $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
		// $fontData = $defaultFontConfig['fontdata'];

		// $mpdf = new Mpdf([
		//   //   'fontDir' => array_merge($fontDirs, [
		//   //      Yii::getAlias('@web') . '/fonts/',
		//   //   ]),
		//   //   'fontdata' => $fontData + [
		//   //       "ArabicKufi" => [ 
		// 		// 	'R' => "DroidKufi-Regular.ttf",
		// 		// 	'B' => "DroidKufi-Regular-Bold.ttf",
		// 		// 	'useOTL' => 0xFF,
		// 		// 	'useKashida' => 75,
		// 		// ]
		//   //   ],
		//   //   'default_font' => 'ArabicKufi'
		// ]);

		// $pdf = Yii::$app->pdf;
		$mpdf = new Mpdf('utf-8', 'A4',0,'',5,5,25,16,4,9,'L');
		// $default = $pdf->api->ConfigVariables();
		$src = Yii::getAlias('@web').'/data/logo.jpg';
		$image=Html::img($src,['alt'=>'No Image','width'=>90, 'height'=>70]); 
		$mpdf->SetHTMLHeader('<table style="border-bottom:1.6px solid #999998;border-top:hidden;border-left:hidden;border-right:hidden;width:100%;"><tr style="border:hidden"><td vertical-align="center" style="width:35px;border:hidden" align="left">'.$image.'</td><td style="border:hidden;text-align:center;color:#555555;"><b style="font-size:22px;">'.'عربي كﻻم'.'</b><br/><span style="font-size:18px">'.$level.'<br>'.$subject.'</td></tr></table>');
		$stylesheet = file_get_contents('css/pdf.css'); // external css
		$mpdf->WriteHTML($stylesheet,0);
		$mpdf->showWatermarkImage = true;
		$mpdf->WriteHTML('<watermarkimage src='.$src.' alpha="0.33" size="80,60"/>');
		$arr = [
		  'odd' => [
		    'L' => [
		      'content' => '$title',
		      'font-size' => 10,
		      'font-style' => 'B',
		      'font-family' => 'serif',
		      'color'=>'#27292b'
		    ],
		    'C' => [
		      'content' => 'Page - {PAGENO}/{nbpg}',
		      'font-size' => 10,
		      'font-style' => 'B',
		      'font-family' => 'serif',
		      'color'=>'#27292b'
		    ],
		    'R' => [ 
		      'content' => 'Printed @ {DATE j-m-Y}',
		      'font-size' => 10,
		      'font-style' => 'B',
		      'font-family' => 'serif',
		      'color'=>'#27292b'
		    ],
		    'line' => 1,
		  ],
		  'even' => []
		];
		$mpdf->SetFooter($arr);
		// $mpdf->setAutoBottomMargin = 'stretch';
		// $mpdf->WriteHTML('<sethtmlpageheader name="main" page="ALL" value="on" show-this-page="1">');
		$mpdf->WriteHTML($html);
		$mpdf->Output($filename.'.pdf',"I");

	}
}

?>
