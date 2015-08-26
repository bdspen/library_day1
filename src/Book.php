<?php

  class Book
  {
    private $title;
    private $author;
    private $id;

    function __construct($title, $author, $id)
    {
      $this->title = $title;
      $this->author = $author;
      $this->id = $id;
    }

    function setTitle($new_title)
    {
      $this->title = $new_title;
    }

    function getTitle()
    {
      return $this->title;
    }

    function setAuthor($new_author)
    {
      $this->author = $new_author;
    }

    function getAuthor()
    {
      return $this->author;
    }

    function getId()
    {
      return $this->id;
    }

    //Save method
    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO books (titles, authors)
      VALUES ('{$this->getTitle()}', '{$this->getAuthor()}');");
      $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
      $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
      $books = array();

      foreach($returned_books as $book) {
        $title = $book['titles'];
        $author = $book['authors'];
        $id = $book['id'];

        $new_book = new Book ($title, $author, $id);
        array_push($books, $new_book);
      }
      return $books;

    }

    static function deleteAll()
    {
      $GLOBALS['DB']->exec("DELETE FROM books;");
    }

  }
?>
