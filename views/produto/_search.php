<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ProdutoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="produto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'quantidade') ?>

    <?= $form->field($model, 'data') ?>

    <?= $form->field($model, 'valor') ?>

    <?= $form->field($model, 'nomeproduto') ?>

    <?php // echo $form->field($model, 'marca') ?>

    <?php // echo $form->field($model, 'modelo') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
