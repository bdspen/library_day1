<?php


/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

  require_once "src/Book.php";
  require_once "src/Author.php";

  $server = 'mysql:host=localhost;dbname=library_test';
  $username = 'root';
  $password = 'root';
  $DB = new PDO($server, $username, $password);

  class AuthorTest extends PHPUnit_Framework_TestCase

  {
      protected function tearDown()
      {
          Book::deleteAll();
          Author::deleteAll();
      }

      function test_getAuthorName()
      {
        //Arrange
        $name = "Big Ben Casalino";
        $id = 1;
        $test_author = new Author ($name, $id);

        //Act
        $result = $test_author->getAuthorName();


        //Assert
        $this->assertEquals ( $name, $result);

      }

      function test_setAuthorName()
      {
        //Arrange
        $name = "Uncle Ben";
        $id = 1;
        $test_author = new Author ($name, $id);

        //Act
        $test_author->setAuthorName("Welcome to Puzzle Heaven");
        $result = $test_author->getAuthorName();

        //Assert
        $this->assertEquals($result, "Welcome to Puzzle Heaven");
      }

      function test_getId()
      {
        //Arrange
        $id = 1;
        $name = "Uncle Ben";
        $test_author = new Author ($name, $id);

        //Act
        $result = $test_author->getId();

        //Assert
        $this->assertEquals(1, $result);

      }

      function test_save()
      {
        //Arrange
        $name = "Uncle Ben";
        $id = 1;
        $test_author = new Author($name, $id);

        //Act
        $test_author->save();

        //Assert
        $result = Author::getAll();

        $this->assertEquals($result[0], $test_author);
      }

      function test_getAll()
      {
        //arrange
        $name = "Uncle Ben";
        $id = 1;
        $test_author1 = new Author($name, $id);
        $test_author1->save();

        $name2 = "Dad";
        $id2 = 2;
        $test_author2 = new Author($name2, $id2);
        $test_author2->save();

        //act
        $result = Author::getAll();


        //assert
        $this->assertEquals([$test_author1, $test_author2], $result);

      }

      function test_deleteAll()
      {
        $name = "Dad";
        $id = 1;
        $test_author1 = new Author($name, $id);
        $test_author1->save();

        $name2 = "Uncle Ben";
        $id2 = 2;
        $test_author2 = new Author($name2, $id2);
        $test_author2->save();

        Author::deleteAll();

        $result = Author::getAll();
        $this->assertEquals([], $result);
      }

      function test_find()
      {
        $name = "Uncle Ben";
        $id = 1;
        $test_author1 = new Author ($name, $id);
        $test_author1->save();

        $name2 = "Goof Ball";
        $id2 = 2;
        $test_author2 = new Author ($name2, $id2);
        $test_author2->save();

        $result = Author::find($test_author2->getId());

        $this->assertEquals($test_author2, $result);
      }

    function testUpdateAuthorName()
    {
      $name = "Uncle Ben";
      $id = 1;
      $test_author = new Author($name, $id);
      $test_author->save();

      $new_name = "Silly Steve";

      $test_author->updateAuthorName($new_name);

      $this->assertEquals("Silly Steve", $test_author->getAuthorName());
    }


    function testDeleteAuthor()
    {
      $name = "Hogan";
      $id = 1;
      $test_author = new Author($name, $id);
      $test_author->save();

      $name2 = "Koolaid Man";
      $id2 = 2;
      $test_author2 = new Author($name2, $id2);
      $test_author2->save();

      $test_author->deleteAuthor();

      $this->assertEquals([$test_author2], Author::getAll());

    }

    function testAddBook()
    {
      //Arrange
      $title = "Kama Sutra";
      $id = 1;
      $test_book = new Book ($title, $id);
      $test_book->save();

      $name = "Mr. Dingus";
      $id2 = 2;
      $test_author = new Author ($name, $id2);
      $test_author->save();


      //Act
      $test_author->addBook($test_book);

      $result = $test_author->getBooks();

      //Assert
      $this->assertEquals([$test_book], $result);
    }

    function testGetBooks()
    {
      $title = "Kama Sutra";
      $id = 1;
      $test_book = new Book ($title, $id);
      $test_book->save();

      $title2 = "Oh Yeah";
      $id2 = 2;
      $test_book2 = new Book($title2, $id2);
      $test_book2->save();

      $name = "Uncle Ben";
      $id3 = 3;
      $test_author = new Author($name, $id3);
      $test_author->save();


      //Act
      $test_author->addBook($test_book);
      $test_author->addBook($test_book2);

      //Assert
      $this->assertEquals($test_author->getBooks(), [$test_book, $test_book2]);

    }

  }
?>
