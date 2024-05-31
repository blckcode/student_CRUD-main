<?php
    session_start();

    require "dbconfig.php";
    $db = new DB();

    

    // LOGIN ADMIN
if (isset($_POST['loginAdmin'])) {
    $username = isset($_POST['username']) ? $_POST['username'] : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";

    if ($db->login_admin($username, $password)) {
        $data = $db->login_admin($username, $password);

        $_SESSION['admin_logged_in'] = true;
        $_SESSION['name'] = $data['name'];
        $_SESSION['studentCount'] = $data['studentCount'];
        $_SESSION['teacherCount'] = $data['teacherCount'];
        echo json_encode(['success' => true, 'redirect' => './Admin/admin_dashboard.php']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Login failed. Check your username and password.']);
    }
}

    // LOGIN teacher
    if (isset($_POST['loginTeacher'])) {
        $username = isset($_POST['username']) ? $_POST['username'] : "";
        $password = isset($_POST['password']) ? $_POST['password'] : "";
        
        if ($db->login_teacher($username, $password)) {
            $data = $db->login_teacher($username, $password);
            $_SESSION['teacher_logged_in'] = true;
            $_SESSION['student_data'] = $data;

            $_SESSION['id'] = $data['id'];
            $_SESSION['name'] = $data['name'];
            $_SESSION['studentCount'] = $data['studentCount'];
            echo json_encode(['success' => true, 'redirect' => './Teacher/teacher_dashboard.php']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Login failed. Check your username and password.']);
        }
    }

    if(isset($_POST['updateApproval'])) {
    try {
        $studentId = $_POST['student_id'];
        $approved = $_POST['approved'];

        $response = $db->updateApprovalStatus($studentId, $approved);

        if ($response) {
            echo json_encode(['success' => true, 'message' => 'Approval status updated successfully!']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update approval status.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
    }
}

    


// LOGIN STUDENT
if (isset($_POST['loginStudent'])) {
    $username = isset($_POST['username']) ? $_POST['username'] : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";

    if ($db->login_student($username, $password)) {
        $data = $db->login_student($username, $password);

        $_SESSION['student_logged_in'] = true;
        $_SESSION['id'] = $data['id'];
        $_SESSION['student_data'] = $data;

        echo json_encode(['success' => true, 'redirect' => './Student/student_dashboard.php']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Login failed. Check your username and password.']);
    }
}


if (isset($_POST['fetchTeacherData'])) {
    try {
        if(isset($_POST['id'])) {
            $teacher = $db->fetchTeacherData($_POST['id']);
            
            if ($teacher !== false) {
                echo json_encode(['success' => true, 'teacher' => $teacher]);
            } else {
                echo json_encode(['success' => false, 'error' => 'No teacher data found.']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Teacher ID is not provided.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
    }
}


// FETCH STUDENT DATA
if (isset($_POST['fetchStudentData'])) {
    try {
        if(isset($_POST['id'])) {
            $student = $db->fetchStudentData($_POST['id']);
            
            if ($student !== false) {
                echo json_encode(['success' => true, 'student' => $student]);
            } else {
                echo json_encode(['success' => false, 'error' => 'No student data found.']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Student ID is not provided.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
    }
}



if(isset($_POST['fetchTeachers'])){
    try {
        $teacher_data = $db->fetchTeachers();

        if ($teacher_data !== false) {
            echo json_encode(['success' => true, 'teacher_data' => $teacher_data]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No teachers data found.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
    }
}


if(isset($_POST['fetchStudents'])){
    try {
        $student_data = $db->fetchStudents();

        if ($student_data !== false) {
            echo json_encode(['success' => true, 'student_data' => $student_data]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No students data found.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
    }
}

if(isset($_POST['fetchStudents0'])){
    try {
        $student_data = $db->fetchStudents0();

        if ($student_data !== false) {
            echo json_encode(['success' => true, 'student_data' => $student_data]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No students need aprroval.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
    }
}

    if(isset($_POST['fetchCourses'])){
        try {
            $courses = $db->fetchCourses();
    
            if ($courses !== false) {
                echo json_encode(['success' => true, 'courses' => $courses]);
            } else {
                echo json_encode(['success' => false, 'error' => 'No courses data found.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
        }
    }

    if(isset($_POST['fetchYears'])){
        try {
            $years = $db->fetchYears();
    
            if ($years !== false) {
                echo json_encode(['success' => true, 'years' => $years]);
            } else {
                echo json_encode(['success' => false, 'error' => 'No years data found.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
        }
    }

    if(isset($_POST['fetchSections'])){
        try {
            $sections = $db->fetchSections();
    
            if ($sections !== false) {
                echo json_encode(['success' => true, 'sections' => $sections]);
            } else {
                echo json_encode(['success' => false, 'error' => 'No years data found.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
        }
    }

    if(isset($_POST['updateStudent'])){
        try {
            $studentData = [
                'id' => $_POST['id'],
                'first_name' => $_POST['first_name'],
                'middle_name' => $_POST['middle_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'current_age' => $_POST['current_age'],
                'current_year' => $_POST['current_year'],
                'current_section' => $_POST['current_section'],
                'profile_picture' => '', // Initialize profile picture to empty string
                'course' => $_POST['course'],
            ];
            
            // Check if file was uploaded
            if(empty($_FILES['file']['name'])) {
                die("No file specified!");
            }
    
            $targetFolder = 'uploads/';
            $targetFile = $targetFolder . uniqid() . '_' . basename($_FILES['file']['name']);
    
            // Check if file upload was successful
            if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                // Set profile picture field in student data
                $studentData['profile_picture'] = $targetFile;
            } else {
                die("File upload failed!");
            }
    
            $response = $db->updateStudent($studentData);
    
            if ($response) {
                echo json_encode(['success' => true, 'message' => 'Student updated successfully!']);
                
            } else {
                echo json_encode(['success' => false, 'error' => 'Student update failed.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
        }
    }

    if(isset($_POST['updateTeacher'])){
        try {
            $teacherData = [
                'id' => $_POST['id'],
                'first_name' => $_POST['first_name'],
                'middle_name' => $_POST['middle_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'department' => $_POST['department'],
                'profile_picture' => '',
            ];
            
            // Check if file was uploaded
            if(empty($_FILES['file']['name'])) {
                die("No file specified!");
            }
    
            $targetFolder = 'uploads/';
            $targetFile = $targetFolder . uniqid() . '_' . basename($_FILES['file']['name']);
    
            // Check if file upload was successful
            if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                // Set profile picture field in teacher data
                $teacherData['profile_picture'] = $targetFile;
            } else {
                die("File upload failed!");
            }
    
            $response = $db->updateTeacher($teacherData);
    
            if ($response) {
                echo json_encode(['success' => true, 'message' => 'Student updated successfully!']);
                
            } else {
                echo json_encode(['success' => false, 'error' => 'Student update failed.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
        }
    }
    
    
    
    if(isset($_POST['removeStudent'])){
        try {

            $response = $db->removeStudent($_POST['id']);
    
            if ($response) {
                echo json_encode(['success' => true, 'message' => 'Student removed successfully!']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Student removing failed.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
        }
    }

    if(isset($_POST['removeTeacher'])){
        try {

            $response = $db->removeTeacher($_POST['id']);
    
            if ($response) {
                echo json_encode(['success' => true, 'message' => 'Teacher removed successfully!']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Teacher removing failed.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
        }
    }

    if(isset($_POST['createAdmin'])){
        try {

            $hashedPassword = md5($_POST['password']);

            $data = [
                'name' => $_POST['name'],
                'username' => $_POST['username'],
                'password' => $hashedPassword,
            ];

            $response = $db->createAdmin($data);
    
            if ($response) {
                echo json_encode(['success' => true, 'message' => 'Admin added successfully!']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Admin adding failed.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
        }
    }

    if(isset($_POST['createTeacher'])){
        try {
            // Hash the password
            $hashedPassword = md5($_POST['password']);
    
            // Prepare data for insertion
            $data = [
                'first_name' => isset($_POST['first_name']) ? $_POST['first_name'] : null,
                'middle_name' => isset($_POST['middle_name']) ? $_POST['middle_name'] : null,
                'last_name' => isset($_POST['last_name']) ? $_POST['last_name'] : null,
                'email' => isset($_POST['email']) ? $_POST['email'] : null,
                'current_age' => isset($_POST['current_age']) ? $_POST['current_age'] : null,
                'department' => isset($_POST['department']) ? $_POST['department'] : null,
                'username' => isset($_POST['username']) ? $_POST['username'] : null,
                'password' => $hashedPassword,
            ];
    
            // Assuming $db is your database object with a method createTeacher() for inserting student data
            $response = $db->createTeacher($data);
    
            // Check if insertion was successful and return appropriate response
            if ($response) {
                echo json_encode(['success' => true, 'message' => 'Student added successfully!']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to add student.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
        }
    }

    if(isset($_POST['createStudent'])){
        try {
            // Hash the password
            $hashedPassword = md5($_POST['password']);
    
            // Prepare data for insertion
            $data = [
                'id_number' => isset($_POST['id_number']) ? $_POST['id_number'] : null,
                'first_name' => isset($_POST['first_name']) ? $_POST['first_name'] : null,
                'middle_name' => isset($_POST['middle_name']) ? $_POST['middle_name'] : null,
                'last_name' => isset($_POST['last_name']) ? $_POST['last_name'] : null,
                'email' => isset($_POST['email']) ? $_POST['email'] : null,
                'current_age' => isset($_POST['current_age']) ? $_POST['current_age'] : null,
                'current_year' => isset($_POST['current_year']) ? $_POST['current_year'] : null,
                'current_section' => isset($_POST['current_section']) ? $_POST['current_section'] : null,
                'course' => isset($_POST['course']) ? $_POST['course'] : null,
                'username' => isset($_POST['username']) ? $_POST['username'] : null,
                'password' => $hashedPassword,
            ];
    
            // Assuming $db is your database object with a method createStudent() for inserting student data
            $response = $db->createStudent($data);
    
            // Check if insertion was successful and return appropriate response
            if ($response) {
                echo json_encode(['success' => true, 'message' => 'Student added successfully!']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to add student.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
        }
    }

    
    
?>