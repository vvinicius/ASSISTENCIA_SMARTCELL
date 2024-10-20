<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Orcamento $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="orcamento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cliente_id')->dropDownList($listaClientes, ['prompt' => 'Selecione um cliente'])->label('Clientes') ?>

    <?= $form->field($model, 'data_pedido')->input('date') ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true])->label('Descrição') ?>

    <!-- Campo para selecionar os produtos e quantidades -->
    <div class="form-group">
        <label>Produtos:</label>
        <?php foreach ($produtos as $produto): ?>
            <div class="row">
                <div class="col-md-6">
                    <?= Html::label($produto->nomeproduto . ' (Estoque: ' . $produto->quantidade . ')') ?>
                </div>
                <div class="col-md-6">
                    <?= Html::input('number', "produtos[{$produto->id}]", 0, ['class' => 'form-control', 'min' => 0, 'max' => $produto->quantidade]) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?= $form->field($model, 'valor')->textInput()->label('R$ Valor (Opcional)') ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

