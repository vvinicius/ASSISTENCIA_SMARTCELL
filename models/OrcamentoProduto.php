<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "orcamento_produto".
 *
 * @property int $orcamento_id
 * @property int $produto_id
 * @property int $quantidade
 *
 * @property Orcamento $orcamento
 * @property Produto $produto
 */
class OrcamentoProduto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orcamento_produto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['orcamento_id', 'produto_id', 'quantidade'], 'required'],
            [['orcamento_id', 'produto_id', 'quantidade'], 'integer'],
            [['orcamento_id', 'produto_id'], 'unique', 'targetAttribute' => ['orcamento_id', 'produto_id']],
            [['orcamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orcamento::class, 'targetAttribute' => ['orcamento_id' => 'id']],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'id']],
        ];
    }

    /**
     * Gets query for [[Orcamento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrcamento()
    {
        return $this->hasOne(Orcamento::class, ['id' => 'orcamento_id']);
    }

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['id' => 'produto_id']);
    }
}
