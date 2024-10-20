<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cliente}}`.
 */
class m241018_000114_create_cliente_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cliente}}', [
            'id' => $this->primaryKey()->notNull(),
            'cpf' => $this->integer(),
            'nome' => $this->string(50),
            'telefone' => $this->integer(),
            'email' => $this->string(30),
            'rua' => $this->string(50),
            'num_casa' => $this->integer(),
            'cep' => $this->integer(),
            'cidade' => $this->string(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cliente}}');
    }
}
