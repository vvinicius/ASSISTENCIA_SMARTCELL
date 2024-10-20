<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Produto $model */

$this->title = Yii::t('app', 'Create Produto');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Produtos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
