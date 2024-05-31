<?php
$driver = new mysqli_driver();
$driver->report_mode = MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR;

class DB {
    private $db_host = 'localhost';
    private $db_user = 'root';
    private $db_pass = '';
    private $db_name = 'student_info_system';
    private $db_port = 3306; 

    public $mysql;
    public $res;

    public function __construct()
    {
        try {
            // Include the port parameter in the mysqli constructor
            if (!$this->mysql = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name, $this->db_port)) {
                throw new Exception($this->mysql->connect_error);
            }
        } catch (Exception $e) {
            die("Error on Database fix it quick! " . $e->getMessage());
        }
    }
    

    public function login_admin($username, $password)
{
    $username = $this->mysql->real_escape_string($username);
    $password = $this->mysql->real_escape_string($password);
    
    $hashedPassword = md5($password);
    
    $sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$hashedPassword'";
    $result = $this->mysql->query($sql);
    
    if ($result && $result->num_rows == 1) {
        $adminData = $result->fetch_assoc();
        $_SESSION['admin_logged_in'] = true;

        $dashboard = $this->getDashboardStats();

        $_SESSION['studentCount'] = $dashboard['studentCount'];
        $_SESSION['teacherCount'] = $dashboard['teacherCount'];
        $_SESSION['admin_name'] = isset($adminData['name']) ? $adminData['name'] : '';

        return [
            'studentCount' => $dashboard['studentCount'],
            'teacherCount' => $dashboard['teacherCount'],
            'name' => $_SESSION['admin_name'],
        ];
    } else {
        return false;
    }
}

    public function login_teacher($username, $password)
    {
        $username = $this->mysql->real_escape_string($username);
        $password = $this->mysql->real_escape_string($password);
        
        $hashedPassword = md5($password);
        
        $sql = "SELECT * FROM teachers WHERE username = '$username' AND password = '$hashedPassword'";
        $result = $this->mysql->query($sql);
        
        if ($result && $result->num_rows == 1) {
            $teacherData = $result->fetch_assoc();
            $_SESSION['teacher_logged_in'] = true;

            $dashboard = $this->getDashboardStats();

            $_SESSION['studentCount'] = $dashboard['studentCount'];
            $_SESSION['teacher_name'] = isset($teacherData['name']) ? $teacherData['name'] : '';
            $_SESSION['id'] = isset($teacherData['id']) ? $teacherData['id'] : '';
            return [
                'studentCount' => $dashboard['studentCount'],
                'name' => $_SESSION['teacher_name'],
                'id' => $_SESSION['id'],
            ];
        } else {
            return false;
        }
    }





    public function login_student($username, $password)
    {
        $username = $this->mysql->real_escape_string($username);
        $password = $this->mysql->real_escape_string($password);

        $hashedPassword = md5($password);
        
        $sql = "SELECT * FROM students WHERE username = '$username' AND password = '$hashedPassword'";
        $result = $this->mysql->query($sql);
        
        if ($result) {
            if ($result->num_rows == 1) {
                $studentData = $result->fetch_assoc();
                $_SESSION['student_logged_in'] = true;

                // You can customize the data to return as needed
                $data = [
                    'id' => $studentData['id'],
                    'username' => $studentData['username'],
                ];

                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function getDashboardStats() {
    $sql = "SELECT COUNT(*) AS total_students FROM students";
    $studentCountResult = $this->mysql->query($sql);
    $studentCount = $studentCountResult->fetch_assoc()['total_students'];

    $sql = "SELECT COUNT(*) AS total_teachers FROM teachers";
    $teacherCountResult = $this->mysql->query($sql);
    $teacherCount = $teacherCountResult->fetch_assoc()['total_teachers'];

    return [
        'studentCount' => $studentCount,
        'teacherCount' => $teacherCount,
    ];
}


    public function fetchStudents(){
        $sql = "SELECT * FROM students";
        $result = $this->mysql->query($sql);

        if($result){
            if($result->num_rows > 0){
                $student_data = array();

                while($row = $result->fetch_assoc()){
                    $student_data[] = $row;
                }

                return $student_data;
            }else{
                return false;
            }   
        }else{
            return false;
        }
    }

    public function fetchStudents0(){
        $sql = "SELECT * FROM students WHERE approved = 0";
        $result = $this->mysql->query($sql);

        if($result){
            if($result->num_rows > 0){
                $student_data = array();

                while($row = $result->fetch_assoc()){
                    $student_data[] = $row;
                }

                return $student_data;
            }else{
                return false;
            }   
        }else{
            return false;
        }
    }

    public function fetchCourses(){
        $sql = "SELECT * FROM courses";
        $result = $this->mysql->query($sql);

        if($result){
            if($result->num_rows > 0){
                $courses = array();

                while($row = $result->fetch_assoc()){
                    $courses[] = $row;
                }

                return $courses;
            }else{
                return false;
            }   
        }else{
            return false;
        }
    }

    public function fetchYears(){
        $sql = "SELECT * FROM years";
        $result = $this->mysql->query($sql);

        if($result){
            if($result->num_rows > 0){
                $years = array();

                while($row = $result->fetch_assoc()){
                    $years[] = $row;
                }

                return $years;
            }else{
                return false;
            }   
        }else{
            return false;
        }
    }

    public function fetchSections(){
        $sql = "SELECT * FROM sections";
        $result = $this->mysql->query($sql);

        if($result){
            if($result->num_rows > 0){
                $sections = array();

                while($row = $result->fetch_assoc()){
                    $sections[] = $row;
                }

                return $sections;
            }else{
                return false;
            }   
        }else{
            return false;
        }
    }

    public function fetchStudentData($id){
        $sql = "SELECT * FROM students WHERE id ='$id'";
        $result = $this->mysql->query($sql);

        if($result){
            if($result->num_rows > 0){
                $student_data = array();

                while($row = $result->fetch_assoc()){
                    $student_data[] = $row;
                }

                return $student_data;
            }else{
                return false;
            }   
        }else{
            return false;
        }
    }

    
    public function updateStudent($data){
        $sql = "UPDATE students
                SET first_name = '$data[first_name]', 
                    middle_name = '$data[middle_name]', 
                    last_name = '$data[last_name]', 
                    email = '$data[email]', 
                    current_age = '$data[current_age]', 
                    current_year = '$data[current_year]', 
                    current_section = '$data[current_section]', 
                    course = '$data[course]',
                    profile_picture = '$data[profile_picture]',
                    approved = 1"; // Set approved status to 0 after update
                
        if (isset($data['profile_picture'])) {
            $sql .= ", profile_picture = '$data[profile_picture]'";
        }
        
        $sql .= " WHERE id = $data[id]";
        
        $result = $this->mysql->query($sql);
        
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function updateTeacher($data){
        $sql = "UPDATE teachers
                SET first_name = '$data[first_name]', 
                    middle_name = '$data[middle_name]', 
                    last_name = '$data[last_name]', 
                    email = '$data[email]', 
                    department = '$data[department]',
                    profile_picture = '$data[profile_picture]',
                    approved = 0"; // Set approved status to 0 after update
                
        if (isset($data['profile_picture'])) {
            $sql .= ", profile_picture = '$data[profile_picture]'";
        }
        
        $sql .= " WHERE id = $data[id]";
        
        $result = $this->mysql->query($sql);
        
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    
    

    public function removeStudent($id){
        $sql = "DELETE FROM students WHERE id = $id";
        $result = $this->mysql->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function removeTeacher($id){
        $sql = "DELETE FROM teachers WHERE id = $id";
        $result = $this->mysql->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function createAdmin($data){
        $table_columns = implode(',', array_keys($data));
        $table_values = implode("','", $data);
        $sql = "INSERT INTO admin($table_columns) VALUES ('$table_values')";

        $result = $this->mysql->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function fetchTeacherData($id) {
        $sql = "SELECT * FROM teachers WHERE id ='$id'";
        $result = $this->mysql->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                $teacher_data = array();

                while ($row = $result->fetch_assoc()) {
                    $teacher_data[] = $row;
                }

                return $teacher_data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function fetchTeachers(){
        $sql = "SELECT * FROM teachers";
        $result = $this->mysql->query($sql);

        if($result){
            if($result->num_rows > 0){
                $teacher_data = array();

                while($row = $result->fetch_assoc()){
                    $teacher_data[] = $row;
                }

                return $teacher_data;
            } else {
                return false;
            }   
        } else {
            return false;
        }
    }

    public function createTeacher($data){
        $table_columns = implode(',', array_keys($data));
        $table_values = implode("','", $data);
        $sql = "INSERT INTO teachers($table_columns) VALUES ('$table_values')";

        $result = $this->mysql->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }


   
    public function createStudent($data){
    // Prepare data for insertion
    $table_columns = implode(',', array_keys($data));
    $table_values = "'" . implode("','", array_map([$this->mysql, 'real_escape_string'], array_values($data))) . "'";

    // Construct the SQL query for inserting student data
    $sql = "INSERT INTO students ($table_columns) VALUES ($table_values)";

    // Execute the SQL query
    $result = $this->mysql->query($sql);

    // Check if the insertion was successful and return appropriate response
    if ($result) {
        return true;
    } else {
        return false;
    }
}

public function updateApprovalStatus($id, $approved) {
    $query = "UPDATE students SET approved = ? WHERE id = ?";
    $stmt = $this->mysql->prepare($query);
    $stmt->bind_param('ii', $approved, $id);
    return $stmt->execute();
}
    
}
?>
