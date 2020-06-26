<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%plot}}`.
 */
class m200625_161840_create_plot_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%plot}}', [
            'id' => $this->primaryKey(),
            'egrn' => $this->string(25)->notNull(),
            'address' => $this->string(255)->notNull(),
            'price' => $this->float()->notNull(),
            'area' => $this->float()->notNull()
        ]);

        $this->createIndex(
            'idx-egrn',
            'plot',
            'egrn'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%plot}}');
    }
}
