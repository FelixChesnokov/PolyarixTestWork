<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Clients;
use app\models\User;
use app\models\Transaction;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'main', 'transaction'],
                'rules' => [
                    [
                        'actions' => ['logout', 'main', 'transaction'],
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
     * @inheritdoc
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
        $user = new User();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = User::findOne(['username' => $model->username, 'password'=> $model->password]);
            if($user->is_admin == 1){
                return $this->redirect(array('main'));
            } else {
                return $this->redirect(array('transaction'));
            }
            
        }
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

    public function actionMain()
    {
        $user = new User();
        $transaction = new Transaction();

        if($user->load(Yii::$app->request->post())){
             //Add user
            if(isset($_POST['Registration'])){
                $user->save();   
            } 
            //Delete user
            if(isset($_POST['Delete'])){
                $user = User::findOne(['username' => $user->username, 'password'=> $user->password]);
                if(isset($user)){
                    $user->delete();
                } else {
                    Yii::$app->session->setFlash('clientRegistered', "Client not found");
                }
            }
            //Change status
            if(isset($_POST['Change'])){
                $currentUser = User::findOne(['username' => $user->username]);
                if(isset($currentUser)){
                    $currentTransactions = Transaction::findAll(['user_id'=>$currentUser->id, 'status'=>'new']);
                    if(isset($currentTransactions)){
                        $transaction->changeStatus($currentTransactions);
                    } else {
                        Yii::$app->session->setFlash('transactionNotFound', "Client do not have any transactions");
                    }
                } else {
                    Yii::$app->session->setFlash('clientNotFound', "Client not found");
                }
            } 
            $this->redirect(array('main'));
        }
       
        if($user->load(Yii::$app->request->post()) &&  $transaction->load(Yii::$app->request->post())){
            //Add balans
            if(isset($_POST['Add'])){
                $currentUser = User::findOne(['username' => $user->username]);
                if(isset($currentUser)){
                    $transaction->addBalans($currentUser->id); 
                } else {
                    Yii::$app->session->setFlash('clientNotFoundToAddBalanse', "Client not found");
                }
            } 
            $this->redirect(array('main'));
        }
        $AllTransaction = Transaction::find()->with('user.transaction')->all();
        return $this->render('main', compact('user', 'transaction', 'AllTransaction'));
    }

    public function actionTransaction()
    {
        $user_id = Yii::$app->user->identity->id;
        $user = new User();
        $AllTransaction = Transaction::findAll(['user_id'=>$user_id]);
        if($user->load(Yii::$app->request->post())){
            //Add status succesed
            if(isset($_POST['Succesed'])){
                $user = User::findOne(['username' => Yii::$app->user->identity->username, 'password'=> $user->password]);
                if(isset($user)){
                    $transactions = Transaction::find()->where(['user_id'=>$user->id])->all();
                    if(isset($transactions)){
                        $transaction->changeStatusSuccesed($transactions);
                    } else {
                        Yii::$app->session->setFlash('clientsTransaction', "Transaction not found");
                    }
                } else {
                    Yii::$app->session->setFlash('clientsTransaction', "Client not found");
                }   
            }
            $this->redirect(array('transaction'));
        }
        return $this->render('transaction', compact('AllTransaction', 'user'));
    }
}
