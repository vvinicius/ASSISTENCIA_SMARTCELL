<?php

namespace app\controllers;

use Yii;
use app\models\Orcamento;
use app\models\OrcamentoSearch;
use app\models\OrcamentoProduto;
use app\models\Cliente;
use app\models\Produto;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use PhpOffice\PhpWord\TemplateProcessor;
use yii\filters\AccessControl;

/**
 * OrcamentoController implements the CRUD actions for Orcamento model.
 */
class OrcamentoController extends Controller
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
     * Lists all Orcamento models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrcamentoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orcamento model.
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
     * Creates a new Orcamento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Orcamento();
        $produtosPost = Yii::$app->request->post('produtos', []); 

        $clientes = Cliente::find()->select(['id', 'nome', 'cpf'])->all();
        $listaClientes = [];
        foreach ($clientes as $cliente) {
            $listaClientes[$cliente->id] = $cliente->nome . ' CPF(' . $cliente->cpf . ')';
        }

        $produtos = Produto::find()->select(['id', 'nomeproduto', 'valor', 'quantidade'])->all();

        if ($this->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            
            $valorTotal = 0;

            foreach ($produtosPost as $produtoId => $quantidade) {
                $produto = Produto::findOne($produtoId);

                if ($produto && $produto->quantidade >= $quantidade) {
                    $produto->quantidade -= $quantidade;
                    $produto->save();

                    $valorTotal += $produto->valor * $quantidade;

                    $orcamentoProduto = new OrcamentoProduto();
                    $orcamentoProduto->orcamento_id = $model->id;
                    $orcamentoProduto->produto_id = $produtoId;
                    $orcamentoProduto->quantidade = $quantidade;
                    $orcamentoProduto->save();
                } else {
                    Yii::$app->session->setFlash('error', "Estoque insuficiente para o produto: {$produto->nome}");
                    return $this->redirect(['create']);
                }
            }

            $model->valor = $valorTotal;
            $model->save(false);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'listaClientes' => $listaClientes,
            'produtos' => $produtos,
        ]);
    }

    

    /**
     * Updates an existing Orcamento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $clientes = Cliente::find()->select(['id', 'nome', 'cpf'])->all();
        $listaClientes = [];
        foreach ($clientes as $cliente) {
            $listaClientes[$cliente->id] = $cliente->nome . ' CPF(' . $cliente->cpf . ')';
        }

        $produtos = Produto::find()->select(['id', 'nomeproduto', 'valor', 'quantidade'])->all();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'listaClientes' => $listaClientes,
            'produtos' => $produtos,
        ]);
    }

    /**
     * Deletes an existing Orcamento model.
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
     * Finds the Orcamento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Orcamento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orcamento::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionRelatorio($id)
    {
        $userId = Yii::$app->user->id;
        $model = $this->findModel($id);
        $template = new TemplateProcessor(Yii::getAlias('@webroot') . '/documentos/Orcamento.docx');

        // Consulta para obter os produtos do orçamento
        $orcamentos = Yii::$app->db->createCommand("
            SELECT 
                op.orcamento_id,
                op.produto_id,
                p.nomeproduto,
                op.quantidade
            FROM 
                orcamento_produto op
            INNER JOIN 
                produto p ON op.produto_id = p.id
            WHERE 
                op.orcamento_id = :id
        ")->bindValue(':id', $id)->queryAll();

        // Preenchendo o template com os dados do orçamento
        $template->setValue('numero', $model->id);
        $template->setValue('cliente', $model->cliente_id);
        $template->setValue('data', Yii::$app->formatter->asDate($model->data_pedido, 'php:d/m/Y'));
        $template->setValue('valor', $model->valor);
        $template->setValue('descricao', $model->descricao);
        $template->setValue('data_hoje', date('d/m/Y'));

        // Processando os dados dos produtos do orçamento
        $orcamentoData = [];
        foreach ($orcamentos as $index => $orcamento) {
            $orcamentoData[] = [
                'nomeproduto' => $orcamento['nomeproduto'],
                'quantidade' => $orcamento['quantidade'],
            ];
        }

        $template->cloneBlock('block_orcamento', count($orcamentoData), true, false, $orcamentoData);

        // Salvando o documento gerado
        $outputFilePath = Yii::getAlias('@runtime') . '/relatorio_orcamento.docx';
        $template->saveAs($outputFilePath);

        // Enviando o arquivo como resposta
        Yii::$app->response->sendFile($outputFilePath);
        unlink($outputFilePath);
    }
}
