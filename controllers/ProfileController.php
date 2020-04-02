<?php

namespace app\controllers;

use Yii;
use app\models\Profile;
use app\models\ProfileSearch;
use app\models\UploadForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
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
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Profile model.
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
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Profile();
        $uploadSingleFile = new UploadForm();
        if(Profile::findOne(['user_id' => Yii::$app->user->id])!=null){
            throw new ForbiddenHttpException('ไม่สามารถเพิ่มโปรไฟล์ซ้ำได้');
        }

        if ($model->load(Yii::$app->request->post())) {
            $uploadSingleFile->imageFiles = UploadedFile::getInstances($uploadSingleFile, 'imageFiles');

            //print_r($pos);die();
            //Upload file
            //var_dump($uploadForm->imageFiles);die();
            $picture = $uploadSingleFile->upload('profile');

            if ($picture) {
                //Uploaded successfully
                $mergeTextPicture = implode(',', $picture);

                $model->picture = $mergeTextPicture;

                //var_dump($model);die();
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }


        return $this->render('create', [
            'model' => $model,
            'imageModel' => $uploadSingleFile,
        ]);
    }

    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        //if ($id === null) {
        $id = Yii::$app->user->id;
        //}
        $model = Profile::findOne(['user_id' => $id]);
        $uploadSingleFile = new UploadForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $uploadSingleFile->imageFiles = UploadedFile::getInstances($uploadSingleFile, 'imageFiles');

            //print_r($pos);die();
            //Upload file
            //var_dump($uploadForm->imageFiles);die();
            $picture = $uploadSingleFile->upload('profile');

            if ($picture) {
                //Uploaded successfully
                $mergeTextPicture = implode(',', $picture);

                $model->picture = $mergeTextPicture;


                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }


        return $this->render('create', [
            'model' => $model,
            'imageModel' => $uploadSingleFile,
        ]);
    }

    /**
     * Deletes an existing Profile model.
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
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
