<?php

namespace app\modules\admin\controllers;

use app\models\Employee;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    //public $layout = 'basic';
    public $defaultAction = 'index';
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
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

    public function actionIndex()
    {
        $employee = Employee::find()->where(['user_id' => Yii::$app->user->id])->one();

        if($employee){
            return $this->render('index', [
                'employee' => $employee,
            ]);
        }else{
            return $this->redirect('site/new-employee');
        }
    }

    public function actionNewEmployee()
    {
        $model = new Employee();
        $model->scenario = 'new-employee';
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->team_id = 1;
            $model->branch_id = 1;
            $model->position_id = 1;
            $model->role_id = 1;
            $avatar = UploadedFile::getInstance($model, 'avatar');
            $time = date('YmdHis');
            if($avatar){
                $model->avatar = 'images/employees/' . $time . '.' . $avatar->extension;
            }
            if($model->save()){
                if($avatar){
                    $dir = \Yii::getAlias('@app');
                    $avatar->saveAs($dir.'/web/images/employees/' .$time . '.' . $avatar->extension);
                }
                return $this->redirect(['site/index']);
            }else{
                vd($model->errors);
            }

        }
        return $this->render('new-employee', [
            'model' => $model,
        ]);

    }

    

    public function actionLogin()
    {
        $this->layout = 'auth';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
