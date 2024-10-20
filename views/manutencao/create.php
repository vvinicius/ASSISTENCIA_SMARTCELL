<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Manutencao $model */

$this->title = Yii::t('app', 'Adicionar Manutenção');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Manutencaos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manutencao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
