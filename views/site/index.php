<?php
/* @var $this yii\web\View */
$this->title = 'Test task for SCAND';
?>
<div class="site-index">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="staffTbl" class="table table-bordered">
                        <caption>Company staff</caption>
                        <tr>
                            <th>First name</th>
                            <th>Surname</th>
                            <th>Date of Birth</th>
                            <th>Salary</th>
                        </tr>
                        <?php foreach($employees as $employee){?>
                            <tr id="<?= $employee->id ?>" onclick="checkRow(<?= $employee->id ?>)" style="cursor: pointer">
                                <td >
                                    <?= $employee->first_name ?>
                                    <input id="hiddenFirstName<?= $employee->id ?>" type="hidden" value="<?= $employee->first_name ?>">
                                </td>
                                <td >
                                    <?= $employee->surname ?>
                                    <input id="hiddenSurname<?= $employee->id ?>" type="hidden" value="<?= $employee->surname ?>">
                                </td>
                                <td >
                                    <?php $date = new DateTime($employee->birth_date); ?>
                                    <?= $date->format('d M Y');  ?>
                                    <input id="hiddenBirthDate<?= $employee->id ?>" type="hidden" value="<?= $date->format('m/d/Y') ?>">
                                </td>
                                <td >
                                    <?= $employee->salary?> RUB
                                    <input type="radio" id="radio<?= $employee->id ?>" style="display: none" value="<?= $employee->id ?>">
                                    <input id="hiddenSalary<?= $employee->id ?>" type="hidden" value="<?= $employee->salary ?>">
                                </td>
                            </tr>    
                        <?php } ?>
                        
                    </table>
                </div>    
            </div>
        </div>
        <div class="col-lg-6"></div>
        <div class="col-lg-6">
            <div class="col-lg-2">
                <button class="btn btn-primary" data-toggle="modal" data-target="#createFormModal">Add</button>
            </div>    
            <div class="col-lg-2">
                <button class="btn btn-primary" data-toggle="modal" data-target="#editFormModal">Edit</button>
            </div>    
            <div class="col-lg-2">
                <button id="deleteButton" class="btn btn-primary" onclick="removeEmployee()">Delete</button>
            </div>    
        </div>
    </div>
</div>


<div class="modal fade" id="editFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit employee</h4>
      </div>
      <div class="modal-body">
        <form id='editForm'>
          <div class="form-group">
            <label for="exampleInputEmail1">Firstname</label>
            <input type="text" class="form-control" id="editFirstName" placeholder="Enter firstname">
            <input type="hidden" id="employeeId" >
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Surname</label>
            <input type="text" class="form-control" id="editSurname" placeholder="Enter surname">
          </div>
          <div class="form-group">
            <label for="exampleInputFile">Date of birth</label>
            <input type="date" class="form-control" id="editBirhtDate"  >
          </div>
          <div class="form-group">
            <label for="exampleInputFile">Employee's salary</label>
            <input type="text" class="form-control" id="editSalary" placeholder="Salary" >

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="editEmployee()">Save changes</button>
      </div>
    </div>
  </div>
</div>
</div>

<!-- Pop-up for employee creation-->
<div class="modal fade" id="createFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Create employee</h4>
      </div>
      <div class="modal-body">
            <form id="addForm" method="post" >
                <div class="form-group">
                  <label for="exampleInputEmail1">Firstname</label>
                  <input type="text" class="form-control" id="addFirstName" placeholder="Enter firstname">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Surname</label>
                  <input type="text" class="form-control" id="addSurname" placeholder="Enter surname">
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">Date of birth</label>
                  <input type="date" class="form-control" id="addBirthDate"  >
                  
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">Employee's salary</label>
                  <input type="text" class="form-control" id="addSalary" placeholder="Salary" >
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="addEmployee()">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script>
function removeEmployee(id){
    if(!id){
        alert("Please choose an employee");
    }else{
        $.ajax({
           type: "post", 
           url: '?r=site/remove-employee',
           data: {
               id: id
           },
           success: function(data) {
               if(data != 'false'){
                   $('tr#'+id).remove();
                   $('#editFormModal').modal('hide');
               }
           }
        });
    }
}
function editEmployee(){
    var id = $('#employeeId').val(); 
    var firstName = $('#hiddenFirstName'+id).val();
    var surname = $('#hiddenSurname'+id).val();
    var birthDate = $('#hiddenBirthDate'+id).val();
    var salary = $('#hiddenSalary'+id).val();
    
    
    var firstName = $('#editFirstName').val();
    var surname = $('#editSurname').val();
    var birthDate = $('#editBirhtDate').val();
    var salary = $('#editSalary').val();    
   
    
    $.ajax({
       type: "post", 
       url: '?r=site/edit-employee',
       data: {
           firstName: firstName,
           surname: surname,
           birthDate: birthDate,
           salary: salary,
           id: id
       },
       success: function(data) {console.log(data);
           if(data != 'false'){
               $('tr#'+id).html(data);
               $('#editFormModal').modal('hide');
           }
       }
    });
}    
    
// check row and fill the table with it's values    
function checkRow(id){
    // uncheck posible cases
    $('td input[type=radio]').attr('checked', false);
    $('table#staffTbl tr').removeClass("active");
    // add a function to delete button
    $('#deleteButton').attr("onclick","removeEmployee("+id+")");
    // check clicked row
    $('#radio'+id).attr('checked',true);
    $('tr#'+id).attr('class', 'active');
    // get values from the checked row
    var firstName = $('#hiddenFirstName'+id).val();
    var surname = $('#hiddenSurname'+id).val();
    var birthDate = $('#hiddenBirthDate'+id).val();
    var dateParts = birthDate.split('/');
    var employesDate = dateParts[2]+"-"+dateParts[0]+"-"+dateParts[1];
    var salary = $('#hiddenSalary'+id).val();
    // fill the edit form with the row's values
    $('#employeeId').val(id);
    $('#editFirstName').val(firstName);
    $('#editSurname').val(surname);
    $('#editBirhtDate').val(employesDate);
    $('#editSalary').val(salary);
}    
    
function addEmployee(){
    var firstName = $('#addFirstName').val();
    var surname = $('#addSurname').val();
    var birthDate = $('#addBirthDate').val();
    var salary = $('#addSalary').val();

    $.ajax({
       type: "post", 
       url: '?r=site/add-employee',
       data: {
           firstName: firstName,
           surname: surname,
           birthDate: birthDate,
           salary: salary
       },
       success: function(data) {
            if(data != 'false'){
                $('#staffTbl').append(data);
                $('#createFormModal').modal('hide');
                $('#addForm input').val('');
            }
       }
    });
}
</script>  