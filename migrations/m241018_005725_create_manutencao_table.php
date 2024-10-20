<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%manutencao}}`.
 */
class m241018_005725_create_manutencao_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%manutencao}}', [
            'id' => $this->primaryKey()->notNull(),
            'data_inicio' => $this->integer(),
            'marca' => $this->string(),
            'modelo' => $this->string(),
            'situacao' => $this->boolean(),
            'descricao' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk-manutencao-created_by', // Nome da chave estrangeira
            'manutencao', // Tabela que contém a chave estrangeira
            'created_by', // Coluna na tabela compras que será a chave estrangeira
            'usuario', // Tabela referenciada
            'id', // Coluna na tabela cliente que será referenciada
            'CASCADE', // Ação em DELETE (CASCADE para deletar em cascata)
            'CASCADE'  // Ação em UPDATE (CASCADE para atualizar em cascata)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%manutencao}}');
    }
}
