<?php

use yii\db\Migration;

/**
 * Class m200711_160048_config_type
 */
class m200711_160048_config_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200711_160048_config_type cannot be reverted.\n";

        return false;
    }

    /**
     * 创建表
     * @return bool|void
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = "CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT='配置分类表'";
        }
        $this->createTable('{{%config_type}}', [
            'id' => $this->primaryKey()->comment('配置分类id'),
            'title' => $this->string(8)->notNull()->comment('配置分类标题'),
            'sort' => $this->smallInteger()->notNull()->defaultValue(0)->comment('配置分类排序'),
            'created_at' => $this->integer()->notNull()->defaultValue(0)->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->defaultValue(0)->comment('更新时间'),
        ], $tableOptions);
    }

    /**
     * 删除表
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable('{{%config_type}}');
    }
}
