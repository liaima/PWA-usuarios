<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\FormValidar;
use app\models\TblUsuario;
use yii\bootstrap\Modal;
use app\models\Query;
use yii\helpers\Html;
use yii\data\Pagination;

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
    public function actionIndex()
    {
        return $this->render('index');
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
        
       // echo "ALGO";
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
     * Displays prueba page.
     *
     * @return string
     */
    public function actionPrueba()
    {
      $variable1='Un dato de String';
      $varieble2=520;
      $variable3=[1,2,3,4,5,6,7];

      return $this->render('prueba',
        [
          'varString'=>$variable1,
          'varInt'=>$varieble2,
          'varArray'=>$variable3
        ]
      );
    } 

    public function actionForm($mensaje=null)
    {
      return $this->render('form', ["mensaje"=>$mensaje]);
    }

    public function actionSform()
    {
      $datotxt=null;
      if(isset($_REQUEST['campotxt']))
      {
        $datotxt = "El valor enviado desde el formulario es: ".$_REQUEST['campotxt'];
      }

      return $this->redirect(['site/form', 'mensaje'=>$datotxt]);
    }
    
    public function actionFormvalidar()
    {
      $model = new FormValidar;

      $mensaje = null;

      if($model->load(Yii::$app->request->post()))
      {
        if ($model->validate())
        {
          //consultas, calulos etc, Guardado
          $tbl = new TblUsuario;
          $tbl->nombre = $model->nombre;
          $tbl->email = $model->email;
          if($tbl->insert())
          {
            $mensaje = "El usurio fue cargado correctamente.";
            $model->nombre=null;
            $model->email=null;
            $model->confEmail=null;
          }
          else{
            $mensaje = "Ha ocurrido un error al insertar";
          }
        }
        else{
          $model->getErrors();
        }
      }
      return $this->render('formValidar', ['model'=>$model, 'mensaje'=>$mensaje]);
    }

    public function actionUsuarios($mensaje=null)
    {
      $model = new Query;
      
      if($model->load(Yii::$app->request->get()))
      {
        if ($model->validate())
        {
          $search = Html::encode($model->query);
          $query = TblUsuario::find()
            ->where(['like', 'id', $search])
            ->orWhere(['like', 'nombre', $search])
            ->orWhere(['like', 'email', $search]);
        }
        else{
          $model->getErrors();
        }
      }
      else
      {
        $query = TblUsuario::find();
      }

      $countQuery = clone $query;
      $pages = new Pagination([
          'totalCount' => $countQuery->count(),
          'pageSize' => 2
      ]);

      $data = $query->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();


      return $this->render('usuarios', [
        'mensaje'=>$mensaje, 
        'data'=>$data, 
        'model'=>$model,
        'pages'=>$pages
      ]);
    }

    public function actionDelusuario($id, $nombre)
    {
  
      $usr = TblUsuario::findOne($id);
      $usr->delete();

      $mensaje = "Se ha eliminado el usuario $nombre";

      return $this->redirect(['site/usuarios', 'mensaje'=>$mensaje]);
    } 
  



}
