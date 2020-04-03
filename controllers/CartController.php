<?php

namespace app\controllers;

use Yii;
use app\models\Cart;
use app\models\CartSearch;
use app\models\Lease;
use app\models\LeaseDetail;
use app\models\OrderDetail;
use app\models\Orders;
use app\models\Product;
use app\models\Profile;
use app\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['index','checkout','plus','minus','create','update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Cart models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CartSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCheckout()
    {
        $id = Yii::$app->user->id;
        $profile = Profile::findOne(['user_id' => $id]); //User 

        $searchModel = new CartSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //ถ้ามีการเปลี่ยนแปลงข้อมูลส่วนตัวให้บันทึกข้อมูลก่อน
        if ($profile->load(Yii::$app->request->post()) && $profile->save()) {
            if (Yii::$app->request->post('typeButton') === "lease") {
                /*$id = $this->saveLease();
                return $this->redirect(['/lease/update', 'id' => $id]);*/
            } else {
                $_user = User::findOne(['id' => Yii::$app->user->id]);
                $orderId = $this->saveOrder();
                $this->sendEmail($_user, $orderId);
                return $this->redirect(['/orders/index']);
            }

            return $this->redirect(['checkout']);
        }

        return $this->render('checkout', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'profile' => $profile
        ]);
    }


    public function saveOrder()
    {
        //เอาข้อมูลใน Cart มา
        $cart = Cart::find()->joinWith(['product'])->where(['cart.created_by' => Yii::$app->user->id])->all();
        //ราคารวมของ User คนที่สั่งซื้อ
        $grand_total = 0;
        foreach ($cart as $data) {
            $grand_total +=  $data->product['price_for_order'] * $data->quantity;
        }
        //Saving Order
        $orderModel = new Orders();

        $orderModel->setAttribute('grand_total', $grand_total);
        $orderModel->setAttribute('status', 8);
        if ($orderModel->save()) {
            foreach ($cart as $data) {
                /**Orders Detail set values */
                $orderDetail = new OrderDetail();
                $orderDetail->setAttribute('order_id', $orderModel->id);
                $orderDetail->setAttribute('product_id', $data->product_id);
                $orderDetail->setAttribute('qty', $data->quantity);
                /**Insert order detail table */
                $orderDetail->save();

                /**Decrement stock and update product table*/
                $modelProduct = Product::findOne(['id' => $data->product_id]);
                $modelProduct->setAttribute('stock', (int) ($modelProduct->stock - $data->quantity));
                $modelProduct->save();

                /**Deleted all product in cart */
                Cart::deleteAll(['cart.created_by' => Yii::$app->user->id]);
            }

            Yii::$app->session->setFlash('success', 'บันทึกรายการที่คุณสั่งซื้อสำเร็จ กรุณายืนยันการสั่งซื้อในอีเมล');
        }
        return $orderModel->id;
    }

    protected function sendEmail($user, $orderId)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'orderVerify-html','text' => 'orderVerify-text'],
                ['user' => $user, 'id' => $orderId],
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setTo($user->email)
            ->setSubject('ยืนยันการสั่งซื้อ รหัสการสั่งซื้อ : ' . $orderId)
            ->send();
    }



    /**
     * Displays a single Cart model.
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
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cart();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cart model.
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

    public function actionPlus($id)
    {
        $model = $this->findModel($id);
        $model->setAttribute('quantity', $model->quantity + 1);
        $model->save();

        return $this->redirect(['index']);
    }

    public function actionMinus($id)
    {
        $model = $this->findModel($id);
        $model->setAttribute('quantity', $model->quantity - 1);
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Cart model.
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
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cart::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
