<?php

//all methods working and tests passing

  class Author
  {
    private $name;
    private $id;

    function __construct($name, $id= null)
    {
      $this->name = $name;
      $this->id = $id;
    }

    function setAuthorName($new_name)
    {
      $this->name = $new_name;
    }

    function getAuthorName()
    {
      return $this->name;
    }

    function getId()
    {
      return $this->id;
    }

    //Save method
    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO authors (name)
      VALUES ('{$this->getAuthorName()}');");
      $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function deleteAll()
    {
      $GLOBALS['DB']->exec("DELETE FROM authors;");
      $GLOBALS['DB']->exec("DELETE FROM books_authors;");

    }

    static function getAll()
    {
      $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
      $authors = array();

      foreach($returned_authors as $author) {
        $name = $author['name'];
        $id = $author['id'];

        $new_author = new Author ($name, $id);
        array_push($authors, $new_author);
      }
      return $authors;

    }

    static function find($search_id)
    {
      $found_author = null;
      $authors = Author::getAll();
      foreach($authors as $author) {
        $author_id = $author->getId();
        if ($author_id == $search_id) {
          $found_author = $author;
        }
      }

      return $found_author;
    }

    static function findByName($search_name)
    {
      $found_author = null;
      $authors = Author::getAll();
      foreach($authors as $author) {
        $author_name = $author->getAuthorName();
        if ($author_name == $search_name) {
          $found_author = $author;
        }
      }

      return $found_author;
    }

    function updateAuthorName($new_name)
    {
      $GLOBALS['DB']->exec("UPDATE authors SET name = '{$new_name}' WHERE id = {$this->getId()};");
      $this->setAuthorName($new_name);
    }

    function deleteAuthor()
    {
      $GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
      $GLOBALS['DB']->exec("DELETE FROM books_authors WHERE author_id = {$this->getId()};");
    }

    function addBook($new_book)
          {

            $GLOBALS['DB']->exec("INSERT INTO books_authors (book_id, author_id) VALUES ({$new_book->getId()}, {$this->getId()});");
          }

    function getBooks()
    {
        $found_books = $GLOBALS['DB']->query("SELECT books.* FROM
            authors JOIN books_authors ON (authors.id = books_authors.author_id)
                  JOIN books ON (books_authors.book_id = books.id)
                  WHERE authors.id = {$this->getId()};");
        $books = array();
        foreach($found_books as $book) {
            $name = $book['titles'];
            $id = $book['id'];
            $new_book = new Book($name, $id);
            array_push($books, $new_book);
        }
        return $books;
    }
}
?>
