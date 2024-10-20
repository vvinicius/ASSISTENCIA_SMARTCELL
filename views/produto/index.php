<?php

use app\models\Produto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ProdutoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Produtos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Adicionar Produto'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Relatório de Produtos'), ['relatorio'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'quantidade',
            [
                'attribute' => 'data',
                'value' => function($model) {
                    return Yii::$app->formatter->asDate($model->data, 'php:d/m/Y');
                },
                'label' => 'Data',
            ],
            'valor',
            [
                'attribute' => 'nomeproduto',
                'label' => 'Nome'
            ],
            //'marca',
            //'modelo',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Produto $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
