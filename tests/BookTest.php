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

  class BookTest extends PHPUnit_Framework_TestCase

  {
      protected function tearDown()
      {
          Book::deleteAll();
          Author::deleteAll();
      }

      function test_getTitle()
      {
        //Arrange
        $title = "Fun with pillows";
        $id = 1;
        $test_book = new Book ($title, $id);

        //Act
        $result = $test_book->getTitle();


        //Assert
        $this->assertEquals ( $title, $result);

      }

      function test_setTitle()
      {
        //Arrange
        $title = "Uncle Ben's puzzle basement";
        $id = 1;
        $test_book = new Book ($title, $id);

        //Act
        $test_book->setTitle("Welcome to Puzzle Heaven");
        $result = $test_book->getTitle();

        //Assert
        $this->assertEquals($result, "Welcome to Puzzle Heaven");
      }

      function test_getId()
      {
        //Arrange
        $id = 1;
        $title = "Aunt Jehmaima: A century of syrups";
        $test_book = new Book ($title, $id);

        //Act
        $result = $test_book->getId();

        //Assert
        $this->assertEquals(1, $result);

      }

      function test_save()
      {
        //Arrange
        $title = "Growing up Casalino: the Big Ben story";
        $id = 1;
        $test_book = new Book($title, $id);

        //Act
        $test_book->save();

        //Assert
        $result = Book::getAll();

        $this->assertEquals($result[0], $test_book);
      }

      function test_getAll()
      {
        //arrange
        $title = "Poles, Sweat, and Chicken Strips: the definitive guide to Portland strip clubs";
        $id = 1;
        $test_book1 = new Book($title, $id);
        $test_book1->save();

        $title2 = "My dad my hero";
        $id2 = 2;
        $test_book2 = new Book($title2, $id2);
        $test_book2->save();

        //act
        $result = Book::getAll();


        //assert
        $this->assertEquals([$test_book1, $test_book2], $result);

      }

      function test_deleteAll()
      {
        $title = "Poles, Sweat, and Chicken Strips: the definitive guide to Portland strip clubs";
        $id = 1;
        $test_book1 = new Book($title, $id);
        $test_book1->save();

        $title2 = "My dad my hero";
        $id2 = 2;
        $test_book2 = new Book($title2, $id2);
        $test_book2->save();

        Book::deleteAll();

        $result = Book::getAll();
        $this->assertEquals([], $result);
      }

      function test_find()
      {
        $title = "Life without apostrophes";
        $id = 1;
        $test_book1 = new Book ($title, $id);
        $test_book1->save();

        $title2 = "Down by the riverside";
        $id2 = 2;
        $test_book2 = new Book ($title2, $id2);
        $test_book2->save();

        $result = Book::find($test_book2->getId());

        $this->assertEquals($test_book2, $result);
      }

    function testUpdateTitle()
    {
      $title = "The Life and Times of Carrot Top";
      $id = 1;
      $test_book = new Book($title, $id);
      $test_book->save();

      $new_title = "The Old Man Had to Pee";

      $test_book->updateTitle($new_title);

      $this->assertEquals("The Old Man Had to Pee", $test_book->getTitle());
    }


    function testDeleteBook()
    {
      $title = "BRING ON THE PAIN";
      $id = 1;
      $test_book = new Book($title, $id);
      $test_book->save();

      $title2 = "Oh Yeah";
      $id2 = 2;
      $test_book2 = new Book($title2, $id2);
      $test_book2->save();

      $test_book->deleteBook();

      $this->assertEquals([$test_book2], Book::getAll());

    }

    function testAddAuthor()
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
      $test_book->addAuthor($test_author);

      $result = $test_book->getAuthors();

      //Assert
      $this->assertEquals([$test_author], $result);
    }

    function testGetAuthors()
    {
      $name = "Uncle Ben";
      $id3 = 3;
      $test_author = new Author($name, $id3);
      $test_author->save();

      $name2 = "Goof Ball";
      $id2 = 2;
      $test_author2 = new Author ($name2, $id2);
      $test_author2->save();

      $title = "Kama Sutra";
      $id = 1;
      $test_book = new Book ($title, $id);
      $test_book->save();

      //Act
      $test_book->addAuthor($test_author);
      $test_book->addAuthor($test_author2);

      //Assert
      $this->assertEquals($test_book->getAuthors(), [$test_author, $test_author2]);

    }

    function test_countCopies()
    {
      //Arrange
      $title = "Growing up Casalino: the Big Ben story";
      $id = 1;
      $test_book = new Book($title, $id);
      $test_book->save();


      //Act
      $test_book->addCopy(4);

      //Assert
      $result = $test_book->countCopies();

      $this->assertEquals($result, 5);
    }

  }



?>
