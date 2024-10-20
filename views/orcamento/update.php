<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Orcamento $model */

$this->title = Yii::t('app', 'Update Orcamento: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orcamentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="orcamento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listaClientes' => $listaClientes,
        'produtos' => $produtos,
    ]) ?>

</div>
