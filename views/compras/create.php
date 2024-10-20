<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Compras $model */

$this->title = Yii::t('app', 'Create Compras');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Compras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="compras-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'lista' => $lista,
    ]) ?>

</div>
