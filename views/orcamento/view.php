<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Orcamento $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orçamentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="orcamento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Atualizar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Excluir'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Tem certeza de que deseja excluir este item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('app', 'Relatório de Orçamento'), ['relatorio', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'id',
                'value' => $model->id,
                'label' => 'Numero do Orçamento',
            ],
            [
                'attribute' => 'cliente_id',
                'value' => isset($model->cliente) ? $model->cliente->nome : null,
                'label' => 'Cliente',
            ],
            [
                'attribute' => 'data_pedido',
                'value' => function($model) {
                    return Yii::$app->formatter->asDate($model->data_pedido, 'php:d/m/Y');
                },
                'label' => 'Data do Pedido',
            ],
            'valor',
            'descricao',
            //'created_at',
            //'updated_at',
        ],
    ]) ?>

</div>
