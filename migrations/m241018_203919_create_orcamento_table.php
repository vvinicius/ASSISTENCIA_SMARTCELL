<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orcamento}}`.
 */
class m241018_203919_create_orcamento_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orcamento}}', [
            'id' => $this->primaryKey()->notNull(),
            'cliente_id' => $this->integer()->notNull(),
            'data_pedido' => $this->integer(),
            'valor' => $this->float(),
            'descricao' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk-orcamento-cliente_id', 
            'orcamento', 
            'cliente_id', 
            'cliente', 
            'id', 
            'CASCADE', 
            'CASCADE'
        );

        // Tabela para relação muitos-para-muitos entre compras e produtos
        $this->createTable('{{%orcamento_produto}}', [
            'orcamento_id' => $this->integer()->notNull(),
            'produto_id' => $this->integer()->notNull(),
            'quantidade' => $this->integer()->notNull()->defaultValue(1),
            'PRIMARY KEY(orcamento_id, produto_id)',
        ]);

        // Adicionando chaves estrangeiras
        $this->addForeignKey(
            'fk-orcamento_produto-orcamento_id',
            '{{%orcamento_produto}}',
            'orcamento_id',
            '{{%orcamento}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-orcamento_produto-produto_id',
            '{{%orcamento_produto}}',
            'produto_id',
            '{{%produto}}',
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
        $this->dropTable('{{%orcamento_produto}}');
        $this->dropTable('{{%orcamento}}');
    }
}
