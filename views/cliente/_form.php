<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Cliente $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="cliente-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cpf')->textInput()->label('CPF') ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefone')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('E-mail') ?>

    <?= $form->field($model, 'rua')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num_casa')->textInput()->label('Número da Casa') ?>

    <?= $form->field($model, 'cep')->textInput() ?>

    <?= $form->field($model, 'cidade')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Cadastrar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
