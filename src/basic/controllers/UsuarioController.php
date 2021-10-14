<?php

namespace app\controllers;

use app\models\Usuario;
use app\models\UsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuario model.
     * @param int $id ID
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
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuario();

       
        if ($model->load($this->request->post())) {

            if ($model->validate()) {
                $model->username=$_POST['Usuario']['username'];
                $model->nombre=$_POST['Usuario']['nombre'];
                $model->email=$_POST['Usuario']['email'];
                $model->password=password_hash(password: $_POST['Usuario']['password'], algo: PASSWORD_BCRYPT);
                $model->authkey=md5(random_bytes(5));
                $model->accesstoken=password_hash(password: random_bytes(5), algo: PASSWORD_DEFAULT);
                
                if ($model->save()) {
                    return $this->redirect(url: ['view', 'id' => $model->id]);
                } else {
                    $model->getErrors();
                }

            } else {
                $model->getErrors();
            }
        }        

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load($this->request->post())) {

            if ($model->validate()) {
                $model->username=$_POST['Usuario']['username'];
                $model->nombre=$_POST['Usuario']['nombre'];
                $model->email=$_POST['Usuario']['email'];
                $model->password=password_hash(password: $_POST['Usuario']['password'], algo: PASSWORD_BCRYPT);
                $model->authkey=md5(random_bytes(5));
                $model->accesstoken=password_hash(password: random_bytes(5), algo: PASSWORD_DEFAULT);
                
                if ($model->save()) {
                    return $this->redirect(url: ['view', 'id' => $model->id]);
                } else {
                    $model->getErrors();
                }

            } else {
                $model->getErrors();
            }
        }  

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
