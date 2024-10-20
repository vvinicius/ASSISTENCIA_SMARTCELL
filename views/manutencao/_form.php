<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Manutencao $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="manutencao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'data_inicio')->input('date')->label('Data de Inicio') ?>

    <?= $form->field($model, 'marca')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'modelo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'situacao')->dropDownList([
        1 => 'Iniciado',
        2 => 'Em Manutenção',
        3 => 'Finalizado',
    ])->label('Situação') ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true])->label('Descrição') ?>

    <?= $form->field($model, 'created_at')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'updated_at')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'created_by')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Salvar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
