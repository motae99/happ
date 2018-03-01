<?php

namespace app\controllers;

use Yii;
use app\models\Physician;
use app\models\Availability;
use app\models\Model;
use app\models\InsuranceAcceptance;
use app\models\PhysicianSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PhysicianController implements the CRUD actions for Physician model.
 */
class PhysicianController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Physician models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PhysicianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Physician model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Physician model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Physician();
        $availability = [new Availability];
        $insurance = [[new InsuranceAcceptance]];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $availability = Model::createMultiple(Availability::classname());
            Model::loadMultiple($availability, Yii::$app->request->post());
            // validate person and Availabilitys models
            $valid = $model->validate();
            $valid = Model::validateMultiple($availability) && $valid;
            if (isset($_POST['InsuranceAcceptance'][0][0])) {
                foreach ($_POST['InsuranceAcceptance'] as $indexAvail => $insurances) {
                    foreach ($insurances as $indexInsu => $insu) {
                        $data['InsuranceAcceptance'] = $insu;
                        $modelInsurance = new InsuranceAcceptance;
                        $modelInsurance->load($data);
                        $modelsInsurance[$indexAvail][$indexInsu] = $modelInsurance;
                        $valid = $modelInsurance->validate();
                    }
                }
            }
            // return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('_form', [
            'model' => $model,
            // 'availability' => $availability,
            'availability' => (empty($availability)) ? [new Availability] : $availability,
            'insurance' => (empty($insurance)) ? [[new Insurance]] : $insurance,
        ]);
    }

        public function actionCr()

    {
        $modelPerson = new Person;
        $modelsHouse = [new House];
        $modelsRoom = [[new Room]];
        if ($modelPerson->load(Yii::$app->request->post())) {
            $modelsHouse = Model::createMultiple(House::classname());
            Model::loadMultiple($modelsHouse, Yii::$app->request->post());
            // validate person and houses models
            $valid = $modelPerson->validate();
            $valid = Model::validateMultiple($modelsHouse) && $valid;
            if (isset($_POST['Room'][0][0])) {
                foreach ($_POST['Room'] as $indexHouse => $insurances) {
                    foreach ($rooms as $indexRoom => $room) {
                        $data['Room'] = $room;
                        $modelRoom = new Room;
                        $modelRoom->load($data);
                        $modelsRoom[$indexHouse][$indexRoom] = $modelRoom;
                        $valid = $modelRoom->validate();
                    }
                }
            }
            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelPerson->save(false)) {
                        foreach ($modelsHouse as $indexHouse => $modelHouse) {
                            if ($flag === false) {
                                break;
                            }
                            $modelHouse->person_id = $modelPerson->id;
                            if (!($flag = $modelHouse->save(false))) {
                                break;
                            }
                            if (isset($modelsRoom[$indexHouse]) && is_array($modelsRoom[$indexHouse])) {
                                foreach ($modelsRoom[$indexHouse] as $indexRoom => $modelRoom) {
                                    $modelRoom->house_id = $modelHouse->id;
                                    if (!($flag = $modelRoom->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelPerson->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        return $this->render('create', [
            'modelPerson' => $modelPerson,
            'modelsHouse' => (empty($modelsHouse)) ? [new House] : $modelsHouse,
            'modelsRoom' => (empty($modelsRoom)) ? [[new Room]] : $modelsRoom,
        ]);

    }
    /**
     * Updates an existing Physician model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Physician model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Physician model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Physician the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Physician::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
