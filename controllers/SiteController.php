<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;


use app\models\Staff;

class SiteController extends Controller
{




    public function actionIndex(){ 
        $query = Staff::find();
        $employees = $query->orderBy('id')
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
    
}
