<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%produto}}`.
 */
class m241018_015901_create_produto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%produto}}', [
            'id' => $this->primaryKey()->notNull(),
            'quantidade' => $this->integer(),
            'data' => $this->integer(),
            'valor' => $this->float(),
            'nomeproduto' => $this->string(),
            'marca' => $this->string(),
            'modelo' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%produto}}');
    }
}
