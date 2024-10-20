<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%compras}}`.
 */
class m241018_002825_create_compras_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%compras}}', [
            'id' => $this->primaryKey()->notNull(),
            'cliente_id' => $this->integer()->notNull(),
            'data_pedido' => $this->integer(),
            'valor' => $this->float(),
            'tipo' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk-compras-cliente_id', 
            'compras', 
            'cliente_id', 
            'cliente', 
            'id', 
            'CASCADE', 
            'CASCADE'  
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%compras}}');
    }
}
