<?php
    class Course
    {
        private $course_name;
        private $id;

        function __construct($course_name, $id = null)
        {
            $this->course_name = $course_name;
            $this->id = $id;
        }

        function getCourseName()
        {
            return $this->course_name;
        }

        function getId()
        {
            return $this->id;
        }

        function setCourseName($new_course_name)
        {
            $this->course_name = $new_course_name;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO courses (course_name) VALUES ('{$this->getCourseName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses");
            $courses = array();
            foreach($returned_courses as $course){
                $course_name = $course['course_name'];
                $id = $course['id'];
                $new_course = new Course($course_name, $id);
                array_push( $courses, $new_course);
            }
            return $courses;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses");
        }

    }
 ?>
