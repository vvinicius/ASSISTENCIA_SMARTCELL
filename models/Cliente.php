<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cliente".
 *
 * @property int $id
 * @property int|null $cpf
 * @property string|null $nome
 * @property int|null $telefone
 * @property string|null $email
 * @property string|null $rua
 * @property int|null $num_casa
 * @property int|null $cep
 * @property string|null $cidade
 */
class Cliente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cliente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cpf', 'telefone', 'num_casa', 'cep'], 'integer'],
            [['nome', 'rua', 'cidade'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cpf' => Yii::t('app', 'Cpf'),
            'nome' => Yii::t('app', 'Nome'),
            'telefone' => Yii::t('app', 'Telefone'),
            'email' => Yii::t('app', 'Email'),
            'rua' => Yii::t('app', 'Rua'),
            'num_casa' => Yii::t('app', 'Num Casa'),
            'cep' => Yii::t('app', 'Cep'),
            'cidade' => Yii::t('app', 'Cidade'),
        ];
    }
}
