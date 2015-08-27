<?php

  class Book
  {
    private $title;
    private $id;

    function __construct($title, $id)
    {
      $this->title = $title;
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

    function getId()
    {
      return $this->id;
    }

    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO books (titles)
      VALUES ('{$this->getTitle()}');");
      $this->id = $GLOBALS['DB']->lastInsertId();

      $GLOBALS['DB']->exec("INSERT INTO copies (book_id) VALUES ({$this->getId()})");

    }

    static function deleteAll()
    {
      $GLOBALS['DB']->exec("DELETE FROM books;");
    }

    static function getAll()
    {
      $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
      $books = array();

      foreach($returned_books as $book) {
        $title = $book['titles'];
        $id = $book['id'];

        $new_book = new Book ($title, $id);
        array_push($books, $new_book);
      }
      return $books;

    }

    static function find($search_id)
    {
      $found_book = null;
      $books = Book::getAll();
      foreach($books as $book) {
        $book_id = $book->getId();
        if ($book_id == $search_id) {
          $found_book = $book;
        }
      }

      return $found_book;
    }

    function updateTitle($new_title)
    {
      $GLOBALS['DB']->exec("UPDATE books SET titles = '{$new_title}' WHERE id = {$this->getId()};");
      $this->setTitle($new_title);
    }

    function deleteBook()
    {
      $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
    }

    function addAuthor($new_author)
          {
            var_dump($new_author);
            $GLOBALS['DB']->exec("INSERT INTO books_authors (book_id, author_id) VALUES ({$this->getId()}, {$new_author->getId()});");
          }

    function getAuthors()
    {
        $found_authors = $GLOBALS['DB']->query("SELECT authors.* FROM
            books JOIN books_authors ON (books.id = books_authors.book_id)
                  JOIN authors ON (books_authors.author_id = authors.id)
                  WHERE books.id = {$this->getId()};");
        $authors = array();
        foreach($found_authors as $author) {
            $name = $author['name'];
            $id = $author['id'];
            $new_author = new Author($name, $id);
            array_push($authors, $new_author);
        }
        return $authors;
    }

    function addCopy($number_of_copies) {
        $count = 1;
        while ($count <= $number_of_copies) {
            $GLOBALS['DB']->exec("INSERT INTO copies (book_id) VALUES ({$this->getId()})");
            $count++;
        }
    }

    function countCopies()
    {
        $matching_copies = $GLOBALS['DB']->query("SELECT * FROM copies");
        $count = 0;

        foreach($matching_copies as $copy) {
          if ($this->getId() == $copy['book_id']) {
            $count++;
          }
        }

        return $count;
    }



  }
?>
