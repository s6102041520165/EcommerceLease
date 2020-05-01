<?php

namespace app\controllers;

use app\models\Cart;
use Yii;
use app\models\Lease;
use app\models\LeaseDetail;
use app\models\LeaseSearch;
use app\models\Product;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use kartik\mpdf\Pdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use yii\filters\AccessControl;

/**
 * LeaseController implements the CRUD actions for Lease model.
 */
class LeaseController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete', 'view', 'index', 'return', 'active', 'inactive'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'update', 'create', 'view', 'delete', 'return', 'active', 'inactive'],
                        'roles' => ['manageLease'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'update', 'create', 'view', 'delete'],
                        'roles' => ['lease'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Lease models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LeaseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReturn($id)
    {
        $lease = $this->findModel($id);
        if ($lease->status === 10) {
            $lease->setAttribute('status', 11);
            $lease->save();
            $leaseDetail = LeaseDetail::findAll(['lease_id' => $lease->id]);
            foreach ($leaseDetail as $detail) {
                $product = Product::findOne(['id' => $detail->product_id]);
                $product->setAttribute('stock', $product->stock + $detail->qty);
                $product->save();
            }
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Displays a single Lease model.
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

    public function actionCheckReturn($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            //เปลี่ยนสถานะ
            $model->setAttribute('status', 11);
            //var_dump($model->product_status);
            if ($model->save() && $model->product_status == 0) {
                //ใช้งานได้ให้เพิ่มสต็อก
                $leaseDetail = LeaseDetail::findAll(['lease_id' => $model->id]);
                foreach ($leaseDetail as $detail) {
                    $product = Product::findOne(['id' => $detail->product_id]);
                    $product->setAttribute('stock', $product->stock + $detail->qty);
                    $product->save();
                    //die();
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->renderPartial('check-return', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionActive($id)
    {
        $model = $this->findModel($id);
        $model->setAttribute('status', 10);
        $model->save();

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionInactive($id)
    {
        $model = $this->findModel($id);
        $model->setAttribute('status', 8);
        $model->save();

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Creates a new Lease model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $cart = Cart::find()->joinWith(['product'])->where(['cart.created_by' => Yii::$app->user->id])->all();
        $model = new Lease();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            foreach ($cart as $data) {
                /**Orders Detail set values */
                $leaseDetail = new LeaseDetail();
                $leaseDetail->setAttribute('lease_id', $model->id);
                $leaseDetail->setAttribute('product_id', $data->product_id);
                $leaseDetail->setAttribute('qty', $data->quantity);
                //ตัดสต็อก
                $product = Product::findOne(['id' => $leaseDetail->product_id]);
                $product->setAttribute('stock', $product->stock - $leaseDetail->qty);
                /**Insert order detail table */
                $product->save();
                $leaseDetail->save();
            }
            /**Deleted all product in cart */
            Cart::deleteAll(['cart.created_by' => Yii::$app->user->id]);

            Yii::$app->session->setFlash('success', 'บันทึกข้อมูลการเช่าสำเร็จ');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Lease model.
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
     * Deletes an existing Lease model.
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

    // สัญญา
    public function actionContract($id)
    {
        $model = $this->findModel($id);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('contract', ['model' => $model]),
            'methods' => [
                'SetTitle' => 'สัญญาค้ำประกันการเช่าอุปกรณ์ถ่ายภาพ ร้านเช่ากล้อง ปัตตานี',
                //'SetFooter' => ['|Page {PAGENO}|'],
            ]
        ]);

        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $pdf->options['fontDir'] = array_merge($fontDirs, [
            Yii::getAlias('@webroot') . '/fonts'
        ]);


        $pdf->options['fontdata'] = $fontData + [
            'thsarabun' => [
                'R' => 'THSarabun.ttf',
                'B' => 'THSarabunBold.ttf'
            ]

        ];
        //'default_font' => 'frutiger'

        $pdf->options['defaultFont'] = 'thsarabun';
        return $pdf->render();
        //return $this->render('receipt');
    }


    /**
     * Finds the Lease model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lease the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lease::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
