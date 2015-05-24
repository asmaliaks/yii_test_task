<?php
/* @var $this yii\web\View */
$this->title = 'Test task for SCAND';
?>
<script>
        var employeers = new Array();
        var currentEmployee;
        var sortingDirection;
        sortingDirection = {
            first_name: 1,
            surname: 1,
            birth_date: 1,
            salary: 1
        };
        var months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Okt","Nov","Dec"];
       
            

</script>    
<div class="site-index">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive" id="divForTable">
                    <table id="staffTbl" class="table table-bordered">
                        <tr>
                            <th id="first_name" onclick="sortTable('first_name')" style="cursor: pointer">
                                First name
                            </th>
                            <th id="surnname" onclick="sortTable('surname')" style="cursor: pointer">
                                Surname
                            </th>
                            <th id="birth_date" onclick="sortTable('birth_date')" style="cursor: pointer">
                                Date of Birth
                            </th>
                            <th id="salary" onclick="sortTable('salary')" style="cursor: pointer">
                                Salary
                            </th>
                        </tr>
                        <?php foreach($employees as $employee){?>
                        <script>
                            employeers.push({
                                id: <?=$employee['id'] ?>,
                                first_name: '<?=$employee['first_name'] ?>',
                                surname: '<?= $employee['surname'] ?>',
                                birth_date: '<?= $employee['birth_date'] ?>',
                                salary: <?= $employee['salary'] ?>
                            })
                        </script>
                            <tr id="employeeRow<?= $employee->id ?>" ondblclick="openEditModal()" onclick="checkRow(<?= $employee->id ?>)" style="cursor: pointer">
                                <td >
                                    <?= $employee->first_name ?>
                                </td>
                                <td >
                                    <?= $employee->surname ?>
                                </td>
                                <td >
                                    <?php $date = new DateTime($employee->birth_date); ?>
                                    <?= $date->format('d M Y');  ?>
                                </td>
                                <td >
                                    <?= $employee->salary?> RUB
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
                <button class="btn btn-primary" onclick="openEditModal()">Edit</button>
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

<?php $this->registerJsFile('@web/js/table.js'); ?> 