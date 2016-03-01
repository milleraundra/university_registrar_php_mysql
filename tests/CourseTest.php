<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Course.php";
    require_once "src/Student.php";

    $server = 'mysql:host=localhost;dbname=university_registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Course::deleteAll();
            Student::deleteAll();
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

        function test_deleteOne()
        {
            $course_name = "Biology";
            $id = null;
            $course = new Course($course_name, $id);
            $course->save();

            $course_name2 = "Economics";
            $course2 = new Course($course_name2, $id);
            $course2->save();

            $course->delete();
            $result = Course::getAll();

            $this->assertEquals([$course2], $result);
        }

        function test_addStudent()
        {
            $course_name = "Biology";
            $id = null;
            $test_course = new Course($course_name, $id);
            $test_course->save();

            $name = "Thelma English";
            $enrollment_date = "2016-03-13";
            $test_student = new Student($name, $enrollment_date, $id);
            $test_student->save();

            $test_course->addStudent($test_student);

            $this->assertEquals($test_course->getStudents(), [$test_student]);
        }

        function test_getStudents()
        {
            $course_name = "Biology";
            $id = null;
            $test_course = new Course($course_name, $id);
            $test_course->save();

            $name = "Thelma English";
            $enrollment_date = "2016-03-13";
            $test_student = new Student($name, $enrollment_date, $id);
            $test_student->save();

            $name2 = "Roger Rook";
            $enrollment_date2 = "2018-04-18";
            $test_student2 = new Student($name2, $enrollment_date2, $id);
            $test_student2->save();

            $test_course->addStudent($test_student);
            $test_course->addStudent($test_student2);

            $this->assertEquals($test_course->getStudents(), [$test_student, $test_student2]);
        }


    }
?>
