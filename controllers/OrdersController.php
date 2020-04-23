<?php

namespace app\controllers;

use app\models\DatePicker;
use app\models\OrderDetail;
use Yii;
use app\models\Orders;
use app\models\OrdersSearch;
use app\models\Product;
use app\models\VerifyOrderForm;
use InvalidArgumentException;
use kartik\mpdf\Pdf;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use yii\filters\AccessControl;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
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
                'only' => ['delete', 'create', 'update', 'active', 'index', 'view', 'picker'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'active', 'picker'],
                        'allow' => true,
                        'roles' => ['manageOrder'],
                    ],
                    [
                        'actions' => ['index', 'view', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
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
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orders();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Orders model.
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
        $model->setAttribute('status', 9);
        $model->save();

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionPicker()
    {
        $model = new DatePicker();
        if ($model->load(Yii::$app->request->queryParams)) {
            return $this->redirect(['report', 'dateStart' => $model->dateStart, 'dateEnd' => $model->dateEnd]);
        }
        return $this->render('_picker', ['model' => $model]);
    }

    public function actionReport($dateStart, $dateEnd)
    {
        if ($dateStart != null) {
            $model = Orders::find()->select(['*'])
                ->where(['status' => 10])
                ->andWhere(['between', "FROM_UNIXTIME(created_at,'%Y-%m-%d')", $dateStart, $dateEnd])
                //->groupBy(["FROM_UNIXTIME(created_at,'%Y-%m-%d')"])
                ->all();
            //$model = $this->findModel($id);

            // setup kartik\mpdf\Pdf component
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'format' => Pdf::FORMAT_A4,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('report', [
                    'model' => $model,
                    'reportDate' => [$dateStart, $dateEnd]
                ]),
                'options' => [
                    // any mpdf options you wish to set
                ],
                'methods' => [
                    'SetTitle' => 'สรุปรายการสั่งซื้อ',
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
                ]

            ];
            //'default_font' => 'frutiger'

            $pdf->options['defaultFont'] = 'thsarabun';
            return $pdf->render();
        } else {
            throw new NotFoundHttpException('ไม่พบหน้าที่ร้องขอ');
        }
    }

    public function actionReceipt($id)
    {
        $model = $this->findModel($id);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('receipt', ['model' => $model]),
            'options' => [
                // any mpdf options you wish to set
            ],
            'methods' => [
                'SetTitle' => 'รายการสั่งซื้อ',
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
            ]

        ];
        //'default_font' => 'frutiger'

        $pdf->options['defaultFont'] = 'thsarabun';
        return $pdf->render();
        //return $this->render('receipt');
    }


    public function actionVerifyOrder($token, $order_id)
    {
        try {
            $model = new VerifyOrderForm($token, $order_id);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            Yii::$app->session->setFlash('success', 'ยืนยันการสั่งซื้อสำเร็จ!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'ขออภัย, ไม่สามารถยืนยันการสั่งซื้อได้');
        return $this->goHome();
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $order = $this->findModel($id);
        if ($order->status === 10) {
            $order->delete();
        } else {
            //คืนสต็อกก่อนลบจริง
            $orderDetail = OrderDetail::findAll(['order_id' => $order->id]);
            foreach ($orderDetail as $detail) {
                $product = Product::findOne(['id' => $detail->product_id]);
                $product->setAttribute('stock', $product->stock + $detail->qty);
                $product->save();

                //deleted order detail
                $detail->delete();
            }
            $order->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
