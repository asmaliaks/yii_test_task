<?php
/* @var $this yii\web\View */
$this->title = 'Test task for SCAND';
?>
<script>
        var employeers = new Array();
        var currentEmployee;
</script>    
<div class="site-index">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="staffTbl" class="table table-bordered">
                        <tr>
                            <th id="first_name" onclick="sort('first_name', 'asc')" style="cursor: pointer">
                                First name
                            </th>
                            <th id="surnname" onclick="sort('surname', 'asc')" style="cursor: pointer">
                                Surname
                            </th>
                            <th id="birth_date" onclick="sort('birth_date', 'asc')" style="cursor: pointer">
                                Date of Birth
                            </th>
                            <th id="salary" onclick="sort('salary', 'asc')" style="cursor: pointer">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
//$(document).ready(function(){
//    $( "#staffTbl tr:not(:first-child)" ).dblclick(function() {
//    
//        window.getSelection().removeAllRanges();
//        $('#editFormModal').modal('show');
//    
//});

    $(document).keydown(function(e) {
        var previousRow;
        var nextRow;
        switch(e.which) {
            // up
            case 38: console.log('up');
                
                e.preventDefault();

                previousRow = $('#employeeRow'+currentEmployee.id).prev().prev();
                if(previousRow.attr('id').indexOf("employeeRow") != -1) {
                    var strId = "employeeRow";
                    var strIdLn = strId.length;
                    console.log(previousRow.attr('id').substr(strIdLn));
                    
                    checkRow(parseInt(previousRow.attr('id').substr(strIdLn)));
                    previousRow.addClass('active');
                }

            break;
            // down
            case 40: console.log('down');
                e.preventDefault();
                
                nextRow = $('#employeeRow'+currentEmployee.id).next().next();
                if(nextRow.attr('id').indexOf("employeeRow") != -1) {
                    var strId = "employeeRow";
                    var strIdLn = strId.length;
                    console.log(nextRow.attr('id').substr(strIdLn));
                    
                    checkRow(parseInt(nextRow.attr('id').substr(strIdLn)));
                    nextRow.addClass('active');
                }

            break;
            // delete
            case 46:
                removeEmployee();
            break;
            default: ; // exit this handler for other keys
        }

    });
//    });

function sort(field, direction){
    $.ajax({
       type: "post", 
       url: '?r=site/sort',
       data: {
           field: field,
           direction: direction
       },
       success: function(data) {
           
       }
    });
}

function openEditModal(){

    $('#editFormModal').modal('show');

    var birthDate = currentEmployee.birth_date;
    var date = new Date(birthDate);
    console.log(currentEmployee);
    
    var month = date.getMonth()+1;
    month = addZero(month);
    var year = date.getFullYear();
    var day = date.getDate();
    day = addZero(day);

    currentEmployee.birth_date = year+"-"+month+"-"+day;console.log(currentEmployee.birth_date);
    //sconsole.log(currentEmployee);
    $('#employeeId').val(currentEmployee.id);
    $('#editFirstName').val(currentEmployee.first_name);
    $('#editSurname').val(currentEmployee.surname);
    $('#editBirhtDate').val(currentEmployee.birth_date);
    $('#editSalary').val(currentEmployee.salary);
}    
function addZero(n){
    
    if(n <= 9){
        n = "0"+n;
        return n;
    }else if(n > 9){
        return n;
    }
}  
function removeEmployee(){
    console.log(employeers);
    console.log(currentEmployee);
    if(!currentEmployee){
        alert("Please choose an employee");
    }else{
        $.ajax({
           type: "post", 
           url: '?r=site/remove-employee',
           data: {
               id: currentEmployee.id
           },
           success: function(data) {
               if(data == 'true'){
                   $('#employeeRow'+currentEmployee.id).remove();
                   
                    $.each(employeers, function(el, i){
                        if (this.id == currentEmployee.id){
                            employeers.splice(i, 1);
                        }
                    });
               }
           }
        });
    }
}
function editEmployee(){

    var firstName = $('#editFirstName').val();
    var surname = $('#editSurname').val();
    var birthDate = $('#editBirhtDate').val();
    var salary = $('#editSalary').val();    
    var id = currentEmployee.id;    
   
    
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
       success: function(data) {
           data = JSON.parse(data);
           console.log(data);
           if(data != 'false'){
                $('#employeeRow'+currentEmployee.id).html('');
                $('#employeeRow'+currentEmployee.id).html('<td>'+data.first_name+'</td><td>'+data.surname+'</td><td>'+data.birth_date+'</td><td>'+data.salary+' RUB</td>');
                var birthDate = data.birth_date;
                var date = new Date(birthDate);
                console.log(date);

                var month = date.getMonth()+1;
                month = addZero(month);
                var year = date.getFullYear();
                var day = date.getDate();
                day = addZero(day);

                currentEmployee.birth_date = year+"-"+month+"-"+day;
                currentEmployee.surname = data.surname;
//                currentEmployee.birth_date = data.birth_date;
                currentEmployee.first_name = data.first_name;
                currentEmployee.salary = data.salary;
                $('#editFormModal').modal('hide');
           }
       }
    });
}    
    
// check row and fill the table with it's values    
function checkRow(id){console.log("checkRow id:"+ id);
$('table#staffTbl tr').removeClass("active");
    for(var employeeIdx in employeers){
        var employee = employeers[employeeIdx];
        if(employee.id == id){
            $('#employeeRow'+id).attr('class', 'active');
            currentEmployee = employee;
        }
    }
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
           data = JSON.parse(data);
           console.log(data);
            if(data != 'false'){
                employeers.push(data);
                $('#staffTbl tbody').append("<style></style>");
                var strToAppend = "<tr id=\"employeeRow"+data.id+"\" ondblclick=\"openEditModal("+data.id+")\" onclick=\"checkRow("+data.id+")\" style=\"cursor: pointer\"><td>"+data.first_name+"</td><td>"+data.surname+"</td><td>"+data.birth_date   +"</td><td>"+data.salary+"</td></tr>";

                $('#staffTbl tbody').append(strToAppend);
                $('#createFormModal').modal('hide');
                $('#addForm input').val('');
            }
       }
    });
}
</script>  