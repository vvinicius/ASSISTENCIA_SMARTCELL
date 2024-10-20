<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ClienteSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="cliente-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cpf') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'telefone') ?>

    <?= $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'rua') ?>

    <?php // echo $form->field($model, 'num_casa') ?>

    <?php // echo $form->field($model, 'cep') ?>

    <?php // echo $form->field($model, 'cidade') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
