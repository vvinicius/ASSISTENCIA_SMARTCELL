<?php

use app\models\Orcamento;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\OrcamentoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Orçamentos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orcamento-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Adicionar Orçamento'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'id',
                'value' => function($model) {
                    return isset($model->cliente) ? $model->cliente->nome : null;
                },
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
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Orcamento $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
