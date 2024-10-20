<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "produto".
 *
 * @property int $id
 * @property int|null $quantidade
 * @property int|null $data
 * @property float|null $valor
 * @property string|null $nomeproduto
 * @property string|null $marca
 * @property string|null $modelo
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Produto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade', 'created_at', 'updated_at'], 'integer'],
            ['data', 'date', 'format' => 'php:Y-m-d'],
            [['valor'], 'number'],
            [['nomeproduto', 'marca', 'modelo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'quantidade' => Yii::t('app', 'Quantidade'),
            'data' => Yii::t('app', 'Data'),
            'valor' => Yii::t('app', 'Valor'),
            'nomeproduto' => Yii::t('app', 'Nomeproduto'),
            'marca' => Yii::t('app', 'Marca'),
            'modelo' => Yii::t('app', 'Modelo'),
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Converte 'data_pedido' de string (data) para timestamp (integer)
            if (!empty($this->data)) {
                $this->data = strtotime($this->data);
            }
            return true;
        }
        return false;
    }

    public function afterFind()
    {
        parent::afterFind();
        // Converte o timestamp de volta para o formato de data
        if (!empty($this->data)) {
            $this->data = date('Y-m-d', $this->data);
        }
    }
}
