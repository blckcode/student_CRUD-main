<!-- update modal -->

<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateModalLabel">Modify Student</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="edit-student-form" enctype="multipart/form-data" method="post" >
            <input hidden id="id" name="id" type="text" class="form-control" required>
            <div class="row mb-3">
                <div class="col">
                    <input id="edit_firstName" name="edit_first_name" type="text" class="form-control" placeholder="First name" aria-label="First name" required>
                </div>
                <div class="col">
                    <input id="edit_middleName" name="edit_middle_name" type="text" class="form-control" placeholder="Middle name" aria-label="Middle name" required>
                </div>
                <div class="col">
                    <input id="edit_lastName" name="edit_last_name" type="text" class="form-control" placeholder="Last name" aria-label="Last name" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <input id="edit_email" name="edit_email" type="email" class="form-control" placeholder="Email @" aria-label="Email" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <input id="edit_age" name="edit_age" type="number" min="0" class="form-control" placeholder="Age" aria-label="Age" required>
                </div>
                <div class="col">
                    <select class="form-select" aria-label="Select Section" id="edit_section" name="edit_section" required>
                        <option selected>Please select section</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <select class="form-select" aria-label="Select Course" id="edit_course" name="edit_course" required>
                        <option selected>Please select course...</option>
                    </select>
                </div>
                <div class="col">
                    <select class="form-select" aria-label="Select Year" id="edit_year" name="edit_year" required>
                        <option selected>Please select year</option>
                    </select>
                </div>
                <div class="row mb-3"> 
                    <div class="col"> 
                        <input type="file" class="form-control" id="file" name="file" accept="image/*" aria-label="Upload Picture" required> 
                    </div> 
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-dark">Update Student</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script>
    //data retrieval
    $(document).ready(function(){
        //update functions
        $('#updateModal').on('show.bs.modal', function(event){
            $.ajax({
                url: '../ajax.php',
                type: 'POST',
                data: { fetchCourses: 1 },
                dataType: 'json',
                success: function(response){
                    if(response.success){
                        $('#edit_course').empty();
                        $('#edit_course').append('<option value="null" selected disabled>Please select course</option>');
                        $.each(response.courses, function(index, course){
                            $('#edit_course').append('<option value="' + course.id + '">' + course.course + '</option>');
                        });
                    } else {
                        console.error('Error fetching courses: ' + response.error);
                    }
                },
                error: function(xhr, status, error){
                    console.error('AJAX Error: ' + error);
                }
            });

            $.ajax({
                url: '../ajax.php',
                type: 'POST',
                data: { fetchYears: 1 }, 
                dataType: 'json',
                success: function(response){
                    if(response.success){
                        $('#edit_year').empty();
                        $('#edit_year').append('<option value="null" selected disabled>Please select year</option>');
                        $.each(response.years, function(index, year){
                            $('#edit_year').append('<option value="' + year.id + '">' + year.year + '</option>');
                        });
                    } else {
                        console.error('Error fetching courses: ' + response.error);
                    }
                },
                error: function(xhr, status, error){
                    console.error('AJAX Error: ' + error);
                }
            });

            $.ajax({
                url: '../ajax.php',
                type: 'POST',
                data: { fetchSections: 1 }, 
                dataType: 'json',
                success: function(response){
                    if(response.success){
                        $('#edit_section').empty();
                        $('#edit_section').append('<option value="null" selected disabled>Please select section</option>');
                        $.each(response.sections, function(index, section){
                            $('#edit_section').append('<option value="' + section.id + '">' + section.section + '</option>');
                        });
                    } else {
                        console.error('Error fetching courses: ' + response.error);
                    }
                },
                error: function(xhr, status, error){
                    console.error('AJAX Error: ' + error);
                }
            });

            var button = $(event.relatedTarget);
            var student_id = button.data('id');


            $.ajax({
                url: '../ajax.php',
                type: 'POST',
                data: { 
                    fetchStudentData: 1,
                    id: student_id,  
                }, 
                dataType: 'json',
                success: function(response){
                    if(response.success){
                        $.each(response.student, function(index, student){
                            $("#id").val(student.id);
                            $("#edit_firstName").val(student.first_name);
                            $("#edit_middleName").val(student.middle_name);
                            $("#edit_lastName").val(student.last_name);
                            $("#edit_email").val(student.email);
                            $("#edit_age").val(student.current_age);
                            $("#edit_course").val(student.course);
                            $("#edit_year").val(student.current_year);
                            $("#edit_section").val(student.current_section);
                            $("#file").val(student.file);
                        });
                    } else {
                        console.error('Error fetching courses: ' + response.error);
                    }
                },
                error: function(xhr, status, error){
                    console.error('AJAX Error: ' + error);
                }
            });
        })

        $('#edit-student-form').on('submit', function(e){
    e.preventDefault();
    var formData = new FormData(); // Create FormData object
    
    // Append each form field individually
    formData.append('updateStudent', 1);
    formData.append('id', $('#id').val());
    formData.append('first_name', $('#edit_firstName').val());
    formData.append('middle_name', $('#edit_middleName').val());
    formData.append('last_name', $('#edit_lastName').val());
    formData.append('email', $('#edit_email').val());
    formData.append('current_age', $('#edit_age').val());
    formData.append('course', $('#edit_course').val());
    formData.append('current_year', $('#edit_year').val());
    formData.append('current_section', $('#edit_section').val());
    formData.append('file', $('#file')[0].files[0]); // Append file
    
    $.ajax({
        type: 'POST',
        url: '../ajax.php',
        data: formData,
        processData: false, // Don't process the data (required for FormData)
        contentType: false, // Don't set contentType (required for FormData)
        dataType: 'json',
        success: function(response){
            if(response.success){
                $('#updateModal').modal('hide'); 
                $('#status').html(response.message);
            } else {
                $('#status').html(response.error);
                console.error('Error: ' + response.error);
            }
        },
        error: function(xhr, status, error){
            $('#updateModal').modal('hide'); 
            $('#status').html(xhr.responseText);
            console.error('AJAX Error: ' + xhr.responseText);
        }
    });
    location.reload();
});

    });
</script>