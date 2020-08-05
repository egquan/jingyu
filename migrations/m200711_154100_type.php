<?php

use yii\db\Migration;

/**
 * Class m200711_154100_type
 */
class m200711_154100_type extends Migration
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
        echo "m200711_154100_type cannot be reverted.\n";

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
            $tableOptions = "CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT='文章表分类表'";
        }
        $this->createTable('{{%type}}', [
            'id' => $this->primaryKey()->comment('分类id'),
            'title' => $this->string(8)->notNull()->comment('分类标题'),
            'keyword' => $this->string(64)->notNull()->comment('分类关键词'),
            'description' => $this->string(128)->notNull()->comment('分类描述'),
            'sort' => $this->smallInteger()->notNull()->defaultValue(0)->comment('分类排序'),
            'created_at' => $this->integer()->notNull()->defaultValue(0)->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->defaultValue(0)->comment('更新时间'),
        ], $tableOptions);
        $this->createIndex('sort','{{%type}}',['sort']);
    }

    /**
     * 删除表
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable('{{%type}}');
    }

}
