<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>

<div class="container">
    <div class="login_form">

        <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>
        <p class="text-center login_name">Вход</p>
        <div class="form-group">
            <div class="text-center">
                <?= $form->field($model, 'username', ['enableLabel' => false])->textInput(['class'=>'form-control', 'placeholder'=>"Логин"])?>
            </div>
        </div>
        <div class="form-group">
            <div class="text-center">
                <?= $form->field($model, 'password', ['enableLabel' => false])->passwordInput(['class'=>'form-control','placeholder'=>"Пароль"])?>
            </div>
        </div>
        <div class="form-group">
            <div class="text-center">
                <?= Html::submitButton('Войти', ['class' => 'btn enter_btn']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

        <p><b>Admin login:</b> admin</p>
        <p><b>Admin password:</b> admin</p>
    </div>
</div>