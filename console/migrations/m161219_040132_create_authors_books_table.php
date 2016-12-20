<?php

use yii\db\Migration;

/**
 * Handles the creation of table `authors_books`.
 */
class m161219_040132_create_authors_books_table extends Migration
{
    private $authorsTable = '{{%authors}}';
    private $booksTable = '{{%books}}';
    private $authorsBooksTable = '{{%authors_books}}';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable($this->authorsBooksTable, [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'book_id' => $this->integer()->notNull(),
        ]);
        $this->createIndex('author_id_book_id_idx', $this->authorsBooksTable, ['author_id', 'book_id'], true);
        $this->createIndex('author_id_idx', $this->authorsBooksTable, 'author_id');
        $this->addForeignKey('authors_books_author_id_fk', $this->authorsBooksTable, 'author_id', $this->authorsTable, 'id', 'cascade');
        $this->createIndex('books_id_idx', $this->authorsBooksTable, 'book_id');
        $this->addForeignKey('authors_books_book_id_fk', $this->authorsBooksTable, 'book_id', $this->booksTable, 'id', 'cascade');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('authors_books_author_id_fk', $this->authorsBooksTable);
        $this->dropForeignKey('authors_books_book_id_fk', $this->authorsBooksTable);
        $this->dropTable($this->authorsBooksTable);
    }
}
