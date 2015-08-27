<?php
    // This is the initial setup for the app.php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Patron.php";

    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/librarian", function() use ($app) {
    return $app['twig']->render('librarian.html.twig', array('books' => Book::getAll(),
    'authors' => Author::getAll()));
    });

    $app->post("/librarian", function() use ($app) {
        $title = $_POST['title'];
        $book = new Book($title);
        $book->save();

        $name = $_POST['author'];
        $author = new Author($name);
        $author->save();

        $book->addAuthor($author);


        return $app['twig']->render('librarian.html.twig', array('books' => Book::getAll(),
    'authors' => Author::getAll()));
    });

    $app->delete("/book/{id}/delete", function($id) use ($app) {
        $book = Book::find($id);
        $book->deleteBook();
        return $app['twig']->render('librarian.html.twig', array('books' => Book::getAll(),
    'authors' => Author::getAll()));

    });

    $app->post("/delete_all_books", function() use ($app) {
        Book::deleteAll();
        return $app['twig']->render('librarian.html.twig', array('books' => Book::getAll(),
    'authors' => Author::getAll()));
    });


    return $app;

 ?>
