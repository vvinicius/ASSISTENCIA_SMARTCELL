<?php

namespace app\controllers;

use Yii;
use app\models\Cliente;
use app\models\ClienteSearch;
use app\models\Orcamento;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;
use yii\filters\AccessControl;

/**
 * ClienteController implements the CRUD actions for Cliente model.
 */
class ClienteController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['index', 'view', 'create', 'update', 'delete'], // Ações que você deseja proteger
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'], // Somente usuários autenticados (logados) podem acessar
                        ],
                    ],
                ],
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
     * Lists all Cliente models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ClienteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cliente model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cliente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Cliente();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cliente model.
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
     * Deletes an existing Cliente model.
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
     * Finds the Cliente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Cliente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cliente::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionRelatorio($id)
    {
        $userId = Yii::$app->user->id;
        $model = $this->findModel($id);
        $template = new TemplateProcessor(Yii::getAlias('@webroot') . '/documentos/Cliente.docx');

        /*$orcamentos = Yii::$app->db->createCommand("
            select * from orcamento where cliente_id = ".$userId."
        ")->queryScalar();*/
        $orcamentos = Orcamento::find()->where(['cliente_id' => $userId,])->all();

        $template->setValue('nome', $model->nome);
        $template->setValue('telefone', $model->telefone);
        $template->setValue('cpf', $model->cpf);
        $template->setValue('email', $model->email);

        //endereco
        $template->setValue('rua', $model->rua);
        $template->setValue('numero', $model->num_casa);
        $template->setValue('cep', $model->cep);
        $template->setValue('cidade', $model->cidade);
        $template->setValue('data_hoje', date('d/m/Y'));

        $orcamentoData = [];
        foreach ($orcamentos as $index => $orcamento) {
            $orcamentoData[] = [
                'orcamento_valor' => $orcamento->valor,
                'orcamento_data' => Yii::$app->formatter->asDate($orcamento->data_pedido, 'php:d/m/Y'),
                'orcamento_descricao' => $orcamento->descricao,
            ];
        }

        // Preencher os orçamentos no documento
        $template->cloneBlock('block_orcamento', count($orcamentoData), true, false, $orcamentoData);

        $outputFilePath = Yii::getAlias('@runtime') . '/relatorio_cliente.docx';
        $template->saveAs($outputFilePath);

        Yii::$app->response->sendFile($outputFilePath);
        unlink($outputFilePath);
    }
}
