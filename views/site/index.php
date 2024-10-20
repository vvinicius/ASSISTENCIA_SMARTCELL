<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ManutencaoSearch $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'SmartCell';
?>
<div class="site-index">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Bem Vindo(a) à SmartCell</h1>

        <p class="lead">Veja o andamento de sua manutenção.</p>

        <?= $form->field($model, 'id')->textInput(['placeholder' => 'Digite o ID da manutenção'])->label(false) ?>

        <p><?= \yii\helpers\Html::submitButton('Ver status de serviço', ['class' => 'btn btn-lg btn-success']) ?></p>
    </div>

    <div class="body-content">
        <?php if ($manutencao !== null): ?>
            <h2>Detalhes da Manutenção</h2>
            <p><strong>ID:</strong> <?= $manutencao->id ?></p>
            <p><strong>Status:</strong> 
                <?php
                    switch ($manutencao->situacao) {
                        case 1:
                            echo "Iniciado";
                            break;
                        case 2:
                            echo "Em Manutenção";
                            break;
                        case 3:
                            echo "Finalizado";
                            break;
                        default:
                            echo "Desconhecido";
                    }
                ?>
            </p>
            <p><strong>Data de Inicio:</strong> <?= Yii::$app->formatter->asDate($manutencao->created_at, 'php:d/m/Y') ?></p>
            <p><strong>Descrição:</strong> <?= $manutencao->descricao ?></p>
            <!-- Exiba outros campos conforme necessário -->
        <?php elseif (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger">
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
