<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Course.php";

    $server = 'mysql:host=localhost;dbname=university_registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Course::deleteAll();
        }

        function test_allGetters()
        {
            $course_name = "Biology";
            $id = 1;
            $course = new Course($course_name, $id);

            $result1 = $course->getCourseName();
            $result2 = $course->getId();

            $this->assertEquals("Biology", $result1);
            $this->assertEquals(1, $result2);
        }

        function test_save()
        {
            $course_name = "Biology";
            $id = null;
            $course = new Course($course_name, $id);
            $course->save();

            $result = Course::getAll();

            $this->assertEquals([$course], $result);

        }

        function test_getAll()
        {
            $course_name = "Biology";
            $id = null;
            $course = new Course($course_name, $id);
            $course->save();

            $course_name2 = "Economics";
            $course2 = new Course($course_name2, $id);
            $course2->save();

            $result = Course::getAll();

            $this->assertEquals([$course, $course2], $result);
        }

        function test_deleteAll()
        {
            $course_name = "Biology";
            $id = null;
            $course = new Course($course_name, $id);
            $course->save();

            $course_name2 = "Economics";
            $course2 = new Course($course_name2, $id);
            $course2->save();

            Course::deleteAll();

            $this->assertEquals([], Course::getAll());
        }

        function test_find()
        {
            $course_name = "Biology";
            $id = null;
            $course = new Course($course_name, $id);
            $course->save();

            $course_name2 = "Economics";
            $course2 = new Course($course_name2, $id);
            $course2->save();

            $result = Course::find($course->getId());

            $this->assertEquals($course, $result);

        }

        function test_update()
        {
            $course_name = "Biology";
            $id = null;
            $course = new Course($course_name, $id);
            $course->save();

            $new_course_name = "Science";
            $course->update($new_course_name);

            $this->assertEquals($new_course_name, $course->getCourseName());
        }

    }
?>
