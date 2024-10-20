<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Manutencao $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Manutenções'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="manutencao-view">

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
        <?= Html::a(Yii::t('app', 'Relatório de Manutenção'), ['relatorio', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'data_inicio',
                'value' => function($model) {
                    return Yii::$app->formatter->asDate($model->data_inicio, 'php:d/m/Y');
                },
                'label' => 'Data de Inicio',
            ],
            'marca',
            'modelo',
            [
                'attribute' => 'situacao',
                'label' => 'Situação',
                'value' => function($model) {
                    switch ($model->situacao) {
                        case 1:
                            return "Iniciado";
                        case 2:
                            return "Em Manutenção";
                        case 3:
                            return "Finalizado";
                        default:
                            return "Desconhecido"; 
                    }
                }
            ],
            'descricao',
            //'created_at',
            //'updated_at',
            [
                'attribute' => 'created_by',
                'label' => 'Tecnico Responsável',
                'value' => isset($tecnico) ? $tecnico : null,
            ],
        ],
    ]) ?>

</div>
