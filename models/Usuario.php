<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;


/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string $password
 * @property int $cpf
 * @property string|null $authKey
 * @property string|null $accessToken
 * @property int $created_at
 * @property int $updated_at
 */
class Usuario extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'email', 'password', 'cpf'], 'required'],
            [['cpf'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['nome', 'email', 'password'], 'string', 'max' => 45],
            [['authKey', 'accessToken'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nome' => Yii::t('app', 'Nome'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Senha'),
            'cpf' => Yii::t('app', 'Cpf'),
            'authKey' => Yii::t('app', 'Auth Key'),
            'accessToken' => Yii::t('app', 'Access Token'),
            'created_at' => Yii::t('app', 'Criado em'),
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
            if ($this->isNewRecord) {
                $this->authKey = \Yii::$app->security->generateRandomString();
                $this->accessToken = \Yii::$app->security->generateRandomString();
                $this->password = sha1($this->password);
                $this->cpf = $this->cpf;
            }
            return true;
        }
        return false;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Localiza uma identidade pelo token informado
     *
     * @param string $token o token a ser localizado
     * @return IdentityInterface|null o objeto da identidade que corresponde ao token informado
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string o ID do usuário atual
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string a chave de autenticação do usuário atual
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @param string $authKey
     * @return bool se a chave de autenticação do usuário atual for válida
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function findByUsername($nome)
    {
        return static::findOne(['nome'=>$nome]);
    }

    public function validatePassword($password)
    {
        return $this->password === sha1($password);
    }

}
