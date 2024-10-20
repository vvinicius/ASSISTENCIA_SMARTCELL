<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "manutencao".
 *
 * @property int $id
 * @property int|null $data_inicio
 * @property string|null $marca
 * @property string|null $modelo
 * @property int|null $situacao
 * @property string|null $descricao
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 *
 * @property Usuario $createdBy
 */
class Manutencao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'manutencao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['situacao', 'created_at', 'updated_at', 'created_by'], 'integer'],
            [['marca', 'modelo', 'descricao'], 'string', 'max' => 255],
            ['data_inicio', 'date', 'format' => 'php:Y-m-d'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'data_inicio' => Yii::t('app', 'Data Inicio'),
            'marca' => Yii::t('app', 'Marca'),
            'modelo' => Yii::t('app', 'Modelo'),
            'situacao' => Yii::t('app', 'Situacao'),
            'descricao' => Yii::t('app', 'Descricao'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
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
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Usuario::class, ['id' => 'created_by']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Converte 'data_pedido' de string (data) para timestamp (integer)
            if (!empty($this->data_inicio)) {
                $this->data_inicio = strtotime($this->data_inicio);
            }
            return true;
        }
        return false;
    }

    public function afterFind()
    {
        parent::afterFind();
        // Converte o timestamp de volta para o formato de data
        if (!empty($this->data_inicio)) {
            $this->data_inicio = date('Y-m-d', $this->data_inicio);
        }
    }
}
