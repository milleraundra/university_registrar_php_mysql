<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Student.php";
    require_once __DIR__."/../src/Course.php";

    // session_start();
    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $server = 'mysql:host=localhost;dbname=university_registrar';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app = new Silex\Application();

     $app['debug'] = true;

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/students", function() use ($app) {
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->post("/students_add", function() use ($app) {
        $name = $_POST['name'];
        $enrollment_date = $_POST['enrollment_date'];
        $student = new Student($name, $enrollment_date);
        $student->save();
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->get("/students/{id}/edit", function($id) use ($app) {
        $student = Student::find($id);
        return $app['twig']->render('student_edit.html.twig', array('student' => $student, 'courses' => Course::getAll()));
    });

    $app->post("/student_add/{id}/course", function($id) use ($app) {
        $student = Student::find($id);
        $course = Course::find($_POST['course']);
        $student->addCourse($course);
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->patch("/student/{id}/edit_name", function($id) use ($app) {
        $student = Student::find($id);
        $name = $_POST['name'];
        $student->update($name);
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->delete("/student/{id}/delete", function($id) use ($app) {
        $student = Student::find($id);
        $student->delete();
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->get("/courses", function() use ($app) {
        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->post("/courses_add", function() use ($app) {
        $course_name = $_POST['course_name'];
        $course = new Course($course_name);
        $course->save();
        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    return $app;

 ?>
