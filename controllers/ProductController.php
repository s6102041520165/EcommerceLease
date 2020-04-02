<?php

namespace app\controllers;

use app\models\Cart;
use Yii;
use app\models\Product;
use app\models\ProductSearch;
use app\models\UploadForm;
use Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','create','update','delete','view'],
                        'roles' => ['@','manageProduct'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        $uploadForm = new UploadForm();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isPost) {
            $uploadForm->imageFiles = UploadedFile::getInstances($uploadForm, 'imageFiles');

            //var_dump($uploadForm->imageFiles);die();
            $picture = $uploadForm->upload('product');

            if ($picture) {
                //Uploaded successfully
                $mergeTextPicture = implode(',', $picture);

                $model->picture = $mergeTextPicture;


                $model->save(false);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'imageModel' => $uploadForm,
        ]);
    }


    public function actionCart(Int $id)
    {
        $modelProduct = $this->findModel($id);
        $model = new Cart();


        try {
            //ค้นหาตะกร้าสินค้าจาก product_id 
            $cart = Cart::findOne(['product_id' => $modelProduct->id]);
            //ถ้าพบสินค้าชิ้นเดียวกับรหัสบาร์โค๊ดให้ทำในเงื่อนไข
            if ($cart !== null) {
                $cart->product_id = $modelProduct->id;
                $cart->id =  $cart->id;
                //เพิ่มจำนวนขึ้นทีละ 1
                $cart->quantity = $cart->quantity += 1;
            } else {
                //กรณีเพิ่มสินค้านี้เป็นชิ้นแรก
                $cart = new Cart();
                $cart->product_id = $modelProduct->id;
                $cart->quantity = 1;
            }

            $cart->save();
        } catch (Exception $e) {
            Yii::$app->session->setFlash('warning', 'ไม่พบสินค้า ' . $modelProduct->barcode);
        }

        return $this->redirect(['/cart/index']);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $uploadForm = new UploadForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $uploadForm->imageFiles = UploadedFile::getInstances($uploadForm, 'imageFiles');
            if ($uploadForm !== null) {
                //var_dump($uploadForm->imageFiles);die();
                $picture = $uploadForm->upload('product');

                if ($picture) {
                    //Uploaded successfully
                    $mergeTextPicture = implode(',', $picture);

                    $model->picture = $mergeTextPicture;


                    $model->save();
                    //return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'imageModel' => $uploadForm,
        ]);
    }

    /**
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
