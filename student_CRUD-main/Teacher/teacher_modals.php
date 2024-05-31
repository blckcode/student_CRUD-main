<!-- update modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateModalLabel">Modify Teacher</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="edit-teacher-form">
        <div class="row mb-3">
            <input hidden id="id" name="id" type="text" class="form-control" required>
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
                <input class="form-control" id="edit_department" name="edit_department" placeholder="Department" required>
                </input>
            </div>
            
        </div>

        <div class="row mb-3"> 
                    <div class="col"> 
                        <input type="file" class="form-control" id="file" name="file" accept="image/*" aria-label="Upload Picture" required> 
                    </div> 
            </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-warning">Update Teacher</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    //data retrieval
    $(document).ready(function(){
        
        //edit functions
        $('#updateModal').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);
            var teacherId = button.data('id');
            $('#id').val(teacherId);

            $.ajax({
                type: 'POST',
                url: '../ajax.php',
                data: {
                    teacherInfo: 1,
                    id: teacherId
                },
                dataType: 'json',
                success: function(response){
                    if(response.success){
                        $('#edit_id_number').val(response.teacher.id_number);
                        $('#edit_firstName').val(response.teacher.first_name);
                        $('#edit_middleName').val(response.teacher.middle_name);
                        $('#edit_lastName').val(response.teacher.last_name);
                        $('#edit_email').val(response.teacher.email);
                        $('#edit_department').val(response.teacher.department_id);
                        $('#edit_position').val(response.teacher.position_id);
                    } else {
                        console.error('Error fetching teacher info: ' + response.error);
                    }
                },
                error: function(xhr, status, error){
                    console.error('AJAX Error: ' + error);
                }
            });

            $.ajax({
                url: '../ajax.php',
                type: 'POST',
                data: { fetchDepartments: 1 },
                dataType: 'json',
                success: function(response){
                    if(response.success){
                        $('#edit_department').empty();
                        $('#edit_department').append('<option value="null" selected disabled>Please select department</option>');
                        $.each(response.departments, function(index, department){
                            $('#edit_department').append('<option value="' + department.id + '">' + department.department + '</option>');
                        });
                    } else {
                        console.error('Error fetching departments: ' + response.error);
                    }
                },
                error: function(xhr, status, error){
                    console.error('AJAX Error: ' + error);
                }
            });

            $.ajax({
                url: '../ajax.php',
                type: 'POST',
                data: { fetchPositions: 1 },
                dataType: 'json',
                success: function(response){
                    if(response.success){
                        $('#edit_position').empty();
                        $('#edit_position').append('<option value="null" selected disabled>Please select position</option>');
                        $.each(response.positions, function(index, position){
                            $('#edit_position').append('<option value="' + position.id + '">' + position.position + '</option>');
                        });
                    } else {
                        console.error('Error fetching positions: ' + response.error);
                    }
                },
                error: function(xhr, status, error){
                    console.error('AJAX Error: ' + error);
                }
            });
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
    location.reload();
});


    });
</script>
