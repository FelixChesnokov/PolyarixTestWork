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
    <p class="text-center login_name">New client</p>
    <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>
    <div class="text-center">
        <div class="login_form">
            <div class="form-group">
                <div class="text-center">
                    <?= $form->field($user, 'username', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Username"])?>
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <?= $form->field($user, 'password', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Password"])?>
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <?= $form->field($user, 'is_admin')->checkbox(['class'=>'client_checkbox', 'label'=>'admin'])?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="text-center">
            <?= Html::submitButton('Create', ['class' => 'btn enter_btn margin_b_10px', 'name'=>'Registration']) ?>
        </div>
    </div>
    <div class="form-group">
        <div class="text-center">
            <?= Html::submitButton('Delete', ['class' => 'btn btn-danger margin_b_10px', 'name'=>'Delete']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    
    <?php if( Yii::$app->session->hasFlash('clientRegistered') ): ?>
        <p class="text-center color_red"><?php echo(Yii::$app->session->getFlash('clientRegistered')); ?></p>
    <?php endif;?>

        <hr>

    <p class="text-center login_name">Add balans</p>
    <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>
    <div class="text-center">
        <div class="login_form">
            <div class="form-group">
                <div class="text-center">
                    <?= $form->field($user, 'username', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Username"])?>
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <?= $form->field($transaction, 'balans', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Balans"])?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="text-center">
            <?= Html::submitButton('Add', ['class' => 'btn enter_btn margin_b_10px', 'name'=>'Add']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php if( Yii::$app->session->hasFlash('clientNotFoundToAddBalanse') ): ?>
        <p class="text-center color_red"><?php echo(Yii::$app->session->getFlash('clientNotFoundToAddBalanse')); ?></p>
    <?php endif;?>

    <hr>

    <p class="text-center login_name">Change status</p>
    <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>
    <div class="text-center">
        <div class="login_form">
            <div class="form-group">
                <div class="text-center">
                    <?= $form->field($user, 'username', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Username"])?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="text-center">
            <?= Html::submitButton('Change', ['class' => 'btn enter_btn margin_b_10px', 'name'=>'Change']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php if( Yii::$app->session->hasFlash('clientNotFound') ): ?>
        <p class="text-center color_red"><?php echo(Yii::$app->session->getFlash('clientNotFound')); ?></p>
    <?php endif;?>
    <?php if( Yii::$app->session->hasFlash('transactionNotFound') ): ?>
        <p class="text-center color_red"><?php echo(Yii::$app->session->getFlash('transactionNotFound')); ?></p>
    <?php endif;?>

    <hr>

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
                            <?= $transaction->user->username ?>
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
</div>

