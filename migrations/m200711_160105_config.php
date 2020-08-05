<?php

use yii\db\Migration;

/**
 * Class m200711_160105_config
 */
class m200711_160105_config extends Migration
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
        echo "m200711_160105_config cannot be reverted.\n";

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
            $tableOptions = "CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT='配置表'";
        }
        $this->createTable('{{%config}}', [
            'id' => $this->primaryKey()->comment('配置id'),
            'title' => $this->string(12)->notNull()->comment('配置标题'),
            'description' => $this->string(128)->notNull()->comment('配置描述'),
            'type_id' => $this->integer(11)->notNull()->comment('配置分类Id'),
            'key' => $this->string(32)->notNull()->unique()->comment('配置key'),
            'value' => $this->string(1024)->notNull()->comment('配置value'),
            'created_at' => $this->integer()->notNull()->defaultValue(0)->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->defaultValue(0)->comment('更新时间'),
        ], $tableOptions);
        $this->createIndex('type_id','{{%config}}',['type_id']);
    }

    /**
     * 删除表
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable('{{%config}}');
    }
}
