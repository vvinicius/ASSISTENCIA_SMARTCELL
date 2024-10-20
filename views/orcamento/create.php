<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Orcamento $model */

$this->title = Yii::t('app', 'Adicionar Orcamento');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orcamentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orcamento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listaClientes' => $listaClientes,
        'produtos' => $produtos,
    ]) ?>

</div>
