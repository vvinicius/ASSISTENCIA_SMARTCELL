<?php

namespace app\controllers;

use Yii;
use app\models\Manutencao;
use app\models\ManutencaoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use PhpOffice\PhpWord\TemplateProcessor;

/**
 * ManutencaoController implements the CRUD actions for Manutencao model.
 */
class ManutencaoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Manutencao models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ManutencaoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Manutencao model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $tecnico = Yii::$app->db->createCommand("
            select nome from usuario where id = ".$model->created_by."
        ")->queryScalar();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'tecnico' => $tecnico,
        ]);
    }

    /**
     * Creates a new Manutencao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Manutencao();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Preenche o campo 'created_by' com o ID do usuário autenticado
                $model->created_by = Yii::$app->user->id;
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Manutencao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Manutencao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Manutencao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Manutencao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Manutencao::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionRelatorio($id)
    {
        $userId = Yii::$app->user->id;
        $model = $this->findModel($id);
        $template = new TemplateProcessor(Yii::getAlias('@webroot') . '/documentos/Manutencao.docx');

        $tecnico = Yii::$app->db->createCommand("
            select nome from usuario where id = ".$model->created_by."
        ")->queryScalar();
        $nomeSituacao = '';
        if($model->situacao == 1){
            $nomeSituacao = 'Iniciado';
        }elseif($model->situacao == 2){
            $nomeSituacao = 'Em Manutenção';
        }elseif($model->situacao == 2){
            $nomeSituacao = 'Finalizado';
        }else{
            $nomeSituacao = 'Desconhecido';
        }
        // Preenchendo o template com os dados do orçamento
        $template->setValue('id', $model->id);
        $template->setValue('data_inicio', Yii::$app->formatter->asDate($model->data_inicio, 'php:d/m/Y'));
        $template->setValue('marca', $model->marca);
        $template->setValue('modelo', $model->modelo);
        $template->setValue('situacao', $nomeSituacao);
        $template->setValue('descricao', $model->descricao);
        $template->setValue('responsavel', $tecnico);
        $template->setValue('data_hoje', date('d/m/Y'));


        // Salvando o documento gerado
        $outputFilePath = Yii::getAlias('@runtime') . '/relatorio_manutencao.docx';
        $template->saveAs($outputFilePath);

        // Enviando o arquivo como resposta
        Yii::$app->response->sendFile($outputFilePath);
        unlink($outputFilePath);
    }
}
