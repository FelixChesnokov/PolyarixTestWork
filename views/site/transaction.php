<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
?>

<?php
    echo Nav::widget([
        'options' => ['class' => 'main_name'],
        'items' => [
            Yii::$app->user->isGuest ? (
            ['label' => 'Войти', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Выйти (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'main_name']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    ?>
 <hr>
<div class="row ">
    <p class="text-center login_name">Transactions</p>
    <table class="table table-striped client_table">
            <thead>
                <tr>
                <th>Name</th>
                <th>Id Transaction</th>
                <th>balans</th>
                <th>status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($AllTransaction as $transaction): ?>
                    <tr>
                        <td>
                            <?= Yii::$app->user->identity->username ?>
                        </td>
                        <td>
                            <?= $transaction->id ?>
                        </td>
                        <td>
                            <?= $transaction->balans ?>
                        </td>
                        <td>
                            <?= $transaction->status ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <hr>
        <p class="text-center login_name">Enter password</p>
        <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>
        <div class="text-center">
            <div class="login_form">
                <div class="form-group">
                    <div class="text-center">
                        <?= $form->field($user, 'password', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Password"])?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="text-center">
                <?= Html::submitButton('Succesed', ['class' => 'btn enter_btn margin_b_10px', 'name'=>'Succesed']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <?php if( Yii::$app->session->hasFlash('clientsTransaction') ): ?>
            <p class="text-center color_red"><?php echo(Yii::$app->session->getFlash('clientsTransaction')); ?></p>
        <?php endif;?>
</div>