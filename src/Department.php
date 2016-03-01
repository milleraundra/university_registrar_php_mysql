<?php

    class Department
    {
        private $department_name;
        private $id;

        function __construct($department_name, $id = null)
        {
            $this->department_name = $department_name;
            $this->id = $id;
        }

        function setDepartmentName($new_department_name)
        {
            $this->department_name = $new_department_name;
        }

        function getDepartmentName()
        {
            return $this->department_name;
        }

        function getId()
        {
            return $this->id;
        }
    }




 ?>
