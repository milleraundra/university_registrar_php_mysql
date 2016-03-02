<?php

    class Student {
        private $name;
        private $enrollment_date;
        private $department_id;
        private $id;

        function __construct($name, $enrollment_date, $department_id, $id = null)
        {
            $this->name = $name;
            $this->enrollment_date = $enrollment_date;
            $this->department_id = $department_id;
            $this->id = $id;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function setEnrollmentDate($new_enrollment_date)
        {
            $this->enrollment_date = $new_enrollment_date;
        }

        function getEnrollmentDate()
        {
            return $this->enrollment_date;
        }

        function setDepartmentId($new_department_id)
        {
            $this->department_id = $new_department_id;
        }

        function getDepartmentId()
        {
            return $this->department_id;
        }

        function getId()

        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO students (name, enrollment_date, department_id) VALUES ('{$this->getName()}', '{$this->getEnrollmentDate()}', {$this->getDepartmentId()})");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $all_students = $GLOBALS['DB']->query("SELECT * FROM students;");
            $students = array();
            foreach($all_students as $student) {
                $name = $student['name'];
                $enrollment_date = $student['enrollment_date'];
                $department_id = $student['department_id'];
                $id = $student['id'];
                $new_student = new Student($name, $enrollment_date, $department_id, $id);
                array_push($students, $new_student);
            }
            return $students;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM students");
        }

        static function find($id)
        {
            $all_students = Student::getAll();
            $found_student = null;
            foreach($all_students as $student) {
                $student_id = $student->getId();
                if ($student_id == $id) {
                    $found_student = $student;
                }
            }
            return $found_student;
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE students SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM students WHERE id = {$this->getId()};");
        }

        function addCourse($course)
        {
            $GLOBALS['DB']->exec("INSERT INTO courses_students (student_id, course_id) VALUES ({$this->getId()}, {$course->getId()}) ;");
        }

        function getCourses()
        {
            $query = $GLOBALS['DB']->query("SELECT courses.* FROM students JOIN courses_students ON (students.id = courses_students.student_id) JOIN courses ON (courses_students.course_id = courses.id) WHERE students.id = {$this->getId()}; ");
            $returned_courses = $query->fetchAll(PDO::FETCH_ASSOC);
            $courses = array();
            foreach($returned_courses as $course){
                $course_name = $course['course_name'];
                $id = $course['id'];
                $new_course = new Course($course_name, $id);
                array_push( $courses, $new_course);
            }
            return $courses;
        }
    }




 ?>
