<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Staff;

class SiteController extends Controller
{
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

    public function actionIndex(){ 
        $query = Staff::find();
        $employees = $query->orderBy('birth_date')
            ->all();
        return $this->render('index',[
            'employees'=>$employees,
        ]);
    }

    public function actionAddEmployee(){
        // get request
        $request = Yii::$app->request;
        // check request if it's came from ajax 
        if($request->isAjax){
            $post = $request->post();
            
            $staffObj = new Staff();
            $staffObj->surname = $post['surname'];
            $staffObj->first_name = $post['firstName'];
            $staffObj->birth_date = $post['birthDate'];
            $staffObj->salary = $post['salary'];
            // get result of the insertion
            $res = $staffObj->insert();
            //get ID of the last insertion
            $db = Yii::$app->db;
            $lastInsertID = $db->getLastInsertID();
            if($res){
                $newEmployee = Staff::find()->where(array('id'=>$lastInsertID))->asArray()->one();
                $date = new \DateTime($newEmployee['birth_date']);
                $string = "<tr id=\"".$lastInsertID."\" ><td>".$newEmployee['first_name']."</td><td>".$newEmployee['surname']."</td><td>".$date->format('d M Y')."</td><td>".$newEmployee['salary']." RUB</td></tr>";
                print_r($string);exit;
            }else{
                print_r('false');exit;
            }
            
        }

    }
    
    public function actionEditEmployee(){
        // get request
        $request = Yii::$app->request;
        // check request if it's came from ajax 
        if($request->isAjax){
            $post = $request->post();
            
           // $staffObj = new Staff();
            $employee = Staff::findOne($post['id']);
            $employee->surname = $post['surname'];
            $employee->first_name = $post['firstName'];
            $employee->birth_date = $post['birthDate'];
            $employee->salary = $post['salary'];
            $res = $employee->save();
            $birthDate = new \DateTime($employee->birth_date);
            if($res){
                $string = '<td>'.$post['firstName'].'</td><td>'.$post['surname'].'</td><td>'.$birthDate->format('d M Y') .'</td><td>'.$post['salary'].' RUB</td>';
                print_r($string);exit;
            }else{
                print_r('false');exit;
            }
            
        }    
    }
    
    public function actionLogin()
    {
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
