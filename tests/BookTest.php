<?php


/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

  require_once "src/Book.php";

  $server = 'mysql:host=localhost;dbname=library_test';
  $username = 'root';
  $password = 'root';
  $DB = new PDO($server, $username, $password);

  class BookTest extends PHPUnit_Framework_TestCase

  {
      protected function tearDown()
      {
          Book::deleteAll();
      }

      function test_getTitle()
      {
        //Arrange
        $title = "Fun with pillows";
        $author = "Cringleberry Jones";
        $id = 1;
        $test_book = new Book ($title, $author, $id);

        //Act
        $result = $test_book->getTitle();


        //Assert
        $this->assertEquals ( $title, $result);

      }

      function test_setTitle()
      {
        //Arrange
        $title = "Uncle Ben's puzzle basement";
        $author = "Dr. H.L. Big-Boi";
        $id = 1;
        $test_book = new Book ($title, $author, $id);

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
        $author = "A.J.";
        $test_book = new Book ($title, $author, $id);

        //Act
        $result = $test_book->getId();

        //Assert
        $this->assertEquals(1, $result);

      }

      function test_save()
      {
        //Arrange
        $title = "Growing up Casalino: the Big Ben story";
        $author = "Big Ben Casalino";
        $id = 1;
        $test_book = new Book($title, $author, $id);

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
        $author = "Grimey Harry";
        $id = 1;
        $test_book1 = new Book($title, $author, $id);
        $test_book1->save();

        $title2 = "My dad my hero";
        $author2 = "Grimey Harry Jr.";
        $id2 = 2;
        $test_book2 = new Book($title2, $author2, $id2);
        $test_book2->save();

        //act
        $result = Book::getAll();

        var_dump($result);

        //assert
        $this->assertEquals([$test_book1, $test_book2], $result);

      }

      function test_deleteAll()
      {
        $title = "Poles, Sweat, and Chicken Strips: the definitive guide to Portland strip clubs";
        $author = "Grimey Harry";
        $id = 1;
        $test_book1 = new Book($title, $author, $id);
        $test_book1->save();

        $title2 = "My dad my hero";
        $author2 = "Grimey Harry Jr.";
        $id2 = 2;
        $test_book2 = new Book($title2, $author2, $id2);
        $test_book2->save();

        Book::deleteAll();

        $result = Book::getAll();
        $this->assertEquals([], $result);
      }

      function test_find()
      {
        $title = "Life without apostrophes";
        $author = "S.B. Dingus";
        $id = 1;
        $test_book1 = new Book ($title, $author, $id);
        $test_book1->save();

        $title2 = "Down by the riverside";
        $author2 = "S.B. Dingus";
        $id2 = 2;
        $test_book2 = new Book ($title2, $author2, $id2);
        $test_book2->save();

        $result = Book::find($test_book2->getId());

        $this->assertEquals($test_book2, $result);
      }

    function testUpdateTitle()
    {
      $title = "The Life and Times of Carrot Top";
      $author = "Ernest Hemingway";
      $id = 1;
      $test_book = new Book($title, $author, $id);
      $test_book->save();

      $new_title = "The Old Man Had to Pee";

      $test_book->updateTitle($new_title);

      $this->assertEquals("The Old Man Had to Pee", $test_book->getTitle());
    }


    function testDeleteBook()
    {
      $title = "BRING ON THE PAIN";
      $author = "Hulk Hogan";
      $id = 1;
      $test_book = new Book($title, $author, $id);
      $test_book->save();

      $title2 = "Oh Yeah";
      $author2 = "Kool-aid Man and Randal Savage";
      $id2 = 2;
      $test_book2 = new Book($title2, $author2, $id2);
      $test_book2->save();

      $test_book->deleteBook();

      $this->assertEquals([$test_book2], Book::getAll());

    }
  }



?>
