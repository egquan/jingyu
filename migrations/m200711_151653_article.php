<?php

use yii\db\Migration;

/**
 * Class m200711_151653_config
 */
class m200711_151653_article extends Migration
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
        echo "m200711_151653_config cannot be reverted.\n";

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
            $tableOptions = "CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT='文章表'";
        }
        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey()->comment('文章id'),
            'title' => $this->string(64)->notNull()->comment('文章标题'),
            'keyword' => $this->string(64)->notNull()->comment('文章关键词'),
            'description' => $this->string(128)->notNull()->comment('文章描述'),
            'type_id' => $this->integer(11)->notNull()->comment('文章分类Id'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment('文章状态 0删除 1正常'),
            'user_id' => $this->integer(11)->notNull()->comment('发布用户Id'),
            'cover' => $this->string(128)->notNull()->comment('文章封面图'),
            'content' => $this->text()->notNull()->comment('文章内容'),
            'created_at' => $this->integer()->notNull()->defaultValue(0)->comment('发布时间'),
            'updated_at' => $this->integer()->notNull()->defaultValue(0)->comment('更新时间'),
        ], $tableOptions);
        $this->createIndex('title','{{%article}}',['title']);
        $this->createIndex('type_id','{{%article}}',['type_id']);
        $this->createIndex('status','{{%article}}',['status']);
    }

    /**
     * 删除表
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable('{{%article}}');
    }
}
