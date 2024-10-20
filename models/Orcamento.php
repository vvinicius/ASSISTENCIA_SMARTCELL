<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "orcamento".
 *
 * @property int $id
 * @property int $cliente_id
 * @property int|null $data_pedido
 * @property float|null $valor
 * @property string|null $descricao
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Cliente $cliente
 */
class Orcamento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orcamento';
    }

    public $produtos;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cliente_id'], 'required'],
            [['cliente_id', 'created_at', 'updated_at'], 'integer'],
            ['data_pedido', 'date', 'format' => 'php:Y-m-d'],
            [['valor'], 'number'],
            [['descricao'], 'string', 'max' => 255],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::class, 'targetAttribute' => ['cliente_id' => 'id']],
            [['produtos'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cliente_id' => Yii::t('app', 'Cliente ID'),
            'data_pedido' => Yii::t('app', 'Data Pedido'),
            'valor' => Yii::t('app', 'Valor'),
            'descricao' => Yii::t('app', 'Descricao'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => time(),
            ],
        ];
    }

    /**
     * Gets query for [[Cliente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Cliente::class, ['id' => 'cliente_id']);
    }

    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['id' => 'produto_id'])
                    ->viaTable('orcamento_produto', ['orcamento_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Converte 'data_pedido' de string (data) para timestamp (integer)
            if (!empty($this->data_pedido)) {
                $this->data_pedido = strtotime($this->data_pedido);
            }
            return true;
        }
        return false;
    }

    public function afterFind()
    {
        parent::afterFind();
        // Converte o timestamp de volta para o formato de data
        if (!empty($this->data_pedido)) {
            $this->data_pedido = date('Y-m-d', $this->data_pedido);
        }
    }
}
