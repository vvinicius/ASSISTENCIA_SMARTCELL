<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%usuario}}`.
 */
class m241017_201435_create_usuario_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%usuario}}', [
            'id' => $this->primaryKey(),
            'nome' => $this->string(45)->notNull(),
            'email' => $this->string(45)->notNull(),
            'password' => $this->string(45)->notNull(),
            'cpf' => $this->integer(15)->notNull(),
            'authKey' => $this->string(),
            'accessToken' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);
        // Inserir dados
        $this->insert('{{%usuario}}', [
            'nome' => 'Admin',
            'email' => 'admin@email.com',
            'password' => '2e6f9b0d5885b6010f9167787445617f553a735f',
            'cpf' => 123456789,
            'authKey' => Yii::$app->getSecurity()->generateRandomString(),
            'accessToken' => Yii::$app->getSecurity()->generateRandomString(),
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%usuario}}');
    }
}
