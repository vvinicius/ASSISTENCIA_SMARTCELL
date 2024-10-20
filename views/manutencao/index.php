<?php

use app\models\Manutencao;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ManutencaoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Manutenções');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manutencao-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Adicionar Manutenção'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=> 'id',
                'label'=> 'Número ID'
            ],
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
            //'descricao',
            //'created_at',
            //'updated_at',
            //'created_by',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Manutencao $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
