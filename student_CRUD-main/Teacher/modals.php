


<!-- add modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addModalLabel">Create New Student</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="add-student-form">
        <div class="row mb-3">
            <div class="col">
                <input name="first_name" type="text" class="form-control" placeholder="First name" aria-label="First name" required>
            </div>
            <div class="col">
                <input name="middle_name" type="text" class="form-control" placeholder="Middle name" aria-label="Last name" required>
            </div>
            <div class="col">
                <input name="last_name" type="text" class="form-control" placeholder="Last name" aria-label="Last name" required>
            </div>
        </div>
        <div class="row mb-3">
             <div class="col">
                <input name="id_number" type="text" class="form-control" placeholder="Student ID Number" aria-label="Student ID Number" required>
            </div>
            <div class="col">
                <input name="email" type="email" class="form-control" placeholder="Email @" aria-label="Email" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <input name="current_age" type="number" min="0" class="form-control" placeholder="Age" aria-label="Age" required>
            </div>
            <div class="col">
                <select name="course" id="course" class="form-select" aria-label="Select Course" required>
                    <option selected>Please select course...</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <select id="year" name="current_year" class="form-select" aria-label="Select Year" required>
                    <option selected>Please select year</option>
                </select>
            </div>
            <div class="col">
                <select id="section" name="current_section" class="form-select" aria-label="Select Section" required>
                    <option selected>Please select section</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Create Student</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Update Modal for Teachers -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateModalLabel">Modify Teacher</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-teacher-form" enctype="multipart/form-data" method="post">
                    <input hidden id="teacher_id" name="teacher_id" type="text" class="form-control" required>
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
                            <input id="edit_id_number" name="edit_id_number" type="text" class="form-control" placeholder="Teacher ID Number" aria-label="Teacher ID Number" required>
                        </div>
                        <div class="col">
                            <input id="edit_email" name="edit_email" type="email" class="form-control" placeholder="Email @" aria-label="Email" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input id="edit_age" name="edit_age" type="number" min="0" class="form-control" placeholder="Age" aria-label="Age" required>
                        </div>
                        <div class="col">
                            <input class="form-control" aria-label="Select Department" id="edit_department" name="edit_department"  placeholder="Department"  required>
                            </i>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="file" class="form-control" id="teacher_file" name="teacher_file" accept="image/*" aria-label="Upload Picture" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Update Teacher</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- delete modal -->

<div class="modal fade" id="removeModal" tabindex="-1" aria-labelledby="removeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-danger" id="removeModalLabel">Remove Student</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="remove-student-form">
            <div class="row mb-3">
                <div class="col">
                    <input type="text" class="form-control" placeholder="id" aria-label="id" name="student_id" id="remove_id" required>
                </div>
                <p>Are you sure you want to delete this student?</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Remove Student</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script>
    //data retrieval
    $(document).ready(function(){
        //add functions
        $('#addModal').on('show.bs.modal', function(event){
            $.ajax({
                url: '../ajax.php',
                type: 'POST',
                data: { fetchCourses: 1 },
                dataType: 'json',
                success: function(response){
                    if(response.success){
                        $('#course').empty();
                        $('#course').append('<option value="null" selected disabled>Please select course</option>');
                        $.each(response.courses, function(index, course){
                            $('#course').append('<option value="' + course.id + '">' + course.course + '</option>');
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
                        $('#year').empty();
                        $('#year').append('<option value="null" selected disabled>Please select year</option>');
                        $.each(response.years, function(index, year){
                            $('#year').append('<option value="' + year.id + '">' + year.year + '</option>');
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
                        $('#section').empty();
                        $('#section').append('<option value="null" selected disabled>Please select section</option>');
                        $.each(response.sections, function(index, section){
                            $('#section').append('<option value="' + section.id + '">' + section.section + '</option>');
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


        $('#add-student-form').on('submit', function(e){
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '../ajax.php',
                data: {
                    createStudent: 1,
                    id_number: $('input[name="id_number"]').val(),
                    first_name: $('input[name="first_name"]').val(),
                    middle_name: $('input[name="middle_name"]').val(),
                    last_name: $('input[name="last_name"]').val(),
                    email: $('input[name="email"]').val(),
                    current_age: $('input[name="current_age"]').val(),
                    course: $('#course').val(),
                    current_year: $('#year').val(),
                    current_section: $('#section').val(),
                },
                dataType: 'json',
                success: function(response){
                    if(response.success){
                        $('#addModal').modal('hide'); 
                        $('#status').html(response.message);
                    } else {
                        $('#status').html(response.error);
                        console.error('Error: ' + response.error);
                    }
                },
                error: function(xhr, status, error){
                    $('#addModal').modal('hide'); 
                    $('#status').html(xhr.responseText);
                    console.error('AJAX Error: ' + xhr.responseText);
                }
            });

            location.reload();
        });


        
        $('#edit-teacher-form').on('submit', function(e){
    e.preventDefault();
    var formData = new FormData(); // Create FormData object
    
    // Append each form field individually
    formData.append('updateTeacher', 1);
    formData.append('id', $('#id').val());
    formData.append('first_name', $('#edit_firstName').val());
    formData.append('middle_name', $('#edit_middleName').val());
    formData.append('last_name', $('#edit_lastName').val());
    formData.append('email', $('#edit_email').val());
    formData.append('current_age', $('#edit_age').val());
    formData.append('department', $('#edit_department').val());

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
    // location.reload();
});


        //remove functions
        $('#removeModal').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);
            var recipient = button.data('id');

            $('#remove_id').val(recipient);
        })

        $('#removeModal').on('hidden.bs.modal', function(event){
            $('#remove_id').val('');
        })

        $('#remove-student-form').on('submit', function(e){
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '../ajax.php',
                data: {
                    removeStudent: 1,
                    id: $('input[name="student_id"]').val(),
                },
                dataType: 'json',
                success: function(response){
                    if(response.success){
                        $('#removeModal').modal('hide'); 
                        $('#status').html(response.message);
                    } else {
                        $('#status').html(response.error);
                        console.error('Error: ' + response.error);
                    }
                },
                error: function(xhr, status, error){
                    $('#removeModal').modal('hide'); 
                    $('#status').html(xhr.responseText);
                    console.error('AJAX Error: ' + xhr.responseText);
                }
            });
            location.reload();
            
        });
    });
</script>