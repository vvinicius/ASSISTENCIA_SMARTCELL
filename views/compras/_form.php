<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Compras $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="compras-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'cliente_id')->dropDownList(
        $lista,
        ['prompt' => 'Selecione um cliente']
    ) ?>

    <?= $form->field($model, 'data_pedido')->input('date') ?>

    <?= $form->field($model, 'valor')->textInput() ?>

    <?= $form->field($model, 'tipo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
