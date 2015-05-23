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
        $employees = $query->orderBy('id')
            ->all();
        return $this->render('index',[
            'employees'=>$employees,
        ]);
    }

    public function actionSort(){
                // get request
        $request = Yii::$app->request;
        // check request if it's came from ajax 
        if($request->isAjax){
            $post = $request->post();
            $query = Staff::find();
            switch ($post['direction']) {
                case 'asc':
                    $employees = $query->orderBy([$post['field'] => SORT_ASC ])->asArray()
                    ->all();
                    break;
                case 'desc':
                    $employees = $query->orderBy([$post['field'] => SORT_DESC ])->asArray()
                    ->all();
                    break;
                default:
                    $employees = $query->orderBy([$post['field'] => SORT_ASC ])->asArray()
                    ->all();
                    break;
            }
            
            if(($post['field'] == 'first_name' && $post['direction'] == 'asc') || ($post['field'] != 'first_name')){
                $firstNameSortStr = "<th id=\"first_name\" onclick=\"sort('first_name', 'asc')\" style=\"cursor: pointer\">"
                        . "First name"
                        . "</th>";
            }else if($post['field'] == 'first_name' && $post['direction'] == 'desc'){
                $firstNameSortStr = "<th id=\"first_name\" onclick=\"sort('first_name', 'desc')\" style=\"cursor: pointer\">"
                        . "First name"
                        . "</th>";
            }
            
            if(($post['field'] == 'surname' && $post['direction'] == 'asc') || ($post['field'] != 'surname')){
                $surnameSortStr = "<th id=\"surname\" onclick=\"sort('surname', 'asc')\" style=\"cursor: pointer\">"
                        . "Surname"
                        . "</th>";
            }else if($post['field'] == 'surname' && $post['direction'] == 'desc'){
                $surnameSortStr = "<th id=\"surname\" onclick=\"sort('surname', 'desc')\" style=\"cursor: pointer\">"
                        . "Surname"
                        . "</th>";
            }
            
            if(($post['field'] == 'birth_date' && $post['direction'] == 'asc') || ($post['field'] != 'birth_date')){
                $birthDateSortStr = "<th id=\"birth_date\" onclick=\"sort('birth_date', 'asc')\" style=\"cursor: pointer\">"
                        . "Date of Birth"
                        . "</th>";
            }else if($post['field'] == 'birth_date' && $post['direction'] == 'desc'){
                $birthDateSortStr = "<th id=\"birth_date\" onclick=\"sort('birth_date', 'desc')\" style=\"cursor: pointer\">"
                        . "Date of Birth"
                        . "</th>";    
            }
            
            if(($post['field'] == 'salary' && $post['direction'] == 'asc') || ($post['field'] != 'salary')){
                $salarySortStr = "<th id=\"salary\" onclick=\"sort('salary', 'asc')\" style=\"cursor: pointer\">"
                        . "Salary"
                        . "</th>";
            }else{
                $salarySortStr = "<th id=\"salary\" onclick=\"sort('salary', 'desc')\" style=\"cursor: pointer\">"
                        . "Salary"
                        . "</th>";
            }
            $stringHead = "<table id=\"staffTbl\" class=\"table table-bordered\">"
                    . "<tr>".$firstNameSortStr.$surnameSortStr.$birthDateSortStr.$salarySortStr
                    . "</tr>"
                    . "</table>";
            $n = 0;
            foreach($employees as $employee){
                if($n == 0){
                    $stringBody = "<tr id=\"".$employee['id']."\" ondblclick=\"openEditModal(".$employee['id'].")\" onclick=\"\">"
                            . "</tr>";
                }
            } 
                    
            print_r($employees);exit;
        }
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
                $ar = array(
                    "id"=>$lastInsertID,
                    "first_name"=>$newEmployee['first_name'],
                    "birth_date"=>$date->format('d M Y'),
                    "surname"=>$newEmployee['surname'],
                    "salary"=>$newEmployee['salary'],
                );
                print_r(json_encode($ar));exit;
            }else{
                print_r('false');exit;
            }
            
        }

    }
    
    public function actionRemoveEmployee(){
        // get request
        $request = Yii::$app->request;
        // check request if it's came from ajax 
        if($request->isAjax){
            $post = $request->post();
            $employee = Staff::findOne($post['id']);
            $res = $employee->delete();
            if($res == 1){
                print_r('true');exit;
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
               
                $ar = array(
                    "id"=>$post['id'],
                    "surname"=>$post['surname'],
                    "first_name"=>$post['firstName'],
                    "birth_date"=>$birthDate->format('d M Y'),
                    "salary"=>$post["salary"],
                );
                $jsonString = json_encode($ar);
                print_r($jsonString);exit;
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
