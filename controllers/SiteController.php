<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\OrderDetail;
use app\models\Orders;
use app\models\PasswordResetRequestForm;
use app\models\Product;
use app\models\ProductSearch;
use app\models\ResendVerificationEmailForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\VerifyEmailForm;
use InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($category = null)
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', ['model' => $model]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {

            Yii::$app->session->setFlash('success', 'กรุณายืนยันบัญชีในอีเมล');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'รับลิงค์ในอีเมลของคุณเพื่อเปลี่ยนรหัสผ่าน');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'บันทึกรหัสผ่านใหม่สำเร็จ.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'อีเมลได้รับการยืนยันเรียบร้อย!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    public function actionCheckOrders()
    {
        //Query เฉพาะรายการที่เคยสั่งซื้อไปแล้วมากกว่า 3 วัน และยังไม่ชำระเงิน
        $sql = "SELECT * ,FROM_UNIXTIME(created_at,'%Y-%m-%d %H:%i:%s') AS duetime
        FROM `orders` 
        WHERE CURRENT_TIMESTAMP() > DATE_ADD(FROM_UNIXTIME(created_at,'%Y-%m-%d %H:%i:%s'),INTERVAL 4 DAY ) AND status = 9; ";

        $params = [];
        //$order = new Orders();

        $kw = Yii::$app->db->createCommand($sql, $params)->queryAll();

        $response = null;
        if ($kw !== NULL) {
            for ($i = 0; $i < count($kw); $i++) {
                //array_push($arrs, $kw[$i]['id'])

                $orderDetail = OrderDetail::findAll(['order_id' => $kw[$i]['id']]);
                foreach ($orderDetail as $model) {

                    //คืน Stock

                    $product = Product::findOne(['id' => $model->product_id]);
                    $product->stock = $model->qty + $product->stock;
                    if ($product->save()) {
                        $model->delete();
                    }
                }

                Orders::findOne(['id' => $kw[$i]['id']])->delete();
            }
        } else
            $response->status = 'Orders is empty!';


        echo json_encode($response);
    }

    public function actionCheckVerify()
    {
        //Query เฉพาะรายการที่เคยสั่งซื้อไปแล้วมากกว่า 3 วัน และยังไม่ชำระเงิน
        $sql = "SELECT * ,FROM_UNIXTIME(created_at,'%Y-%m-%d %H:%i:%s') AS duetime
        FROM `orders` 
        WHERE CURRENT_TIMESTAMP() > DATE_ADD(FROM_UNIXTIME(created_at,'%Y-%m-%d %H:%i:%s'),INTERVAL 1 DAY ) AND status = 8; ";

        $params = [];
        //$order = new Orders();

        $kw = Yii::$app->db->createCommand($sql, $params)->queryAll();

        $response = null;
        if ($kw !== NULL) {
            for ($i = 0; $i < count($kw); $i++) {
                //array_push($arrs, $kw[$i]['id'])

                $orderDetail = OrderDetail::findAll(['order_id' => $kw[$i]['id']]);
                foreach ($orderDetail as $model) {

                    //คืน Stock

                    $product = Product::findOne(['id' => $model->product_id]);
                    $product->stock = $model->qty + $product->stock;
                    if ($product->save()) {
                        $model->delete();
                    }
                }

                Orders::findOne(['id' => $kw[$i]['id']])->delete();
            }
        } else
            $response->status = 'Orders is empty!';


        echo json_encode($response);
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'ตรวจสอบกล่องข้อความในอีเมลของคุณ.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'ขออภัย, เราไม่สามารถส่งข้อความไปยังอีเมลนี้ได้');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
