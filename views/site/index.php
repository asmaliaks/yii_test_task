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

<script>
    $(document).keydown(function(e) {
        var previousRow;
        var nextRow;
        switch(e.which) {
            // up
            case 38: 
                
                e.preventDefault();

                previousRow = $('#employeeRow'+currentEmployee.id).prev().prev();
                console.log();
                if(previousRow.attr('id').indexOf("employeeRow") != -1) {
                    var strId = "employeeRow";
                    var strIdLn = strId.length;
                    
                    checkRow(parseInt(previousRow.attr('id').substr(strIdLn)));
                    previousRow.addClass('active');
                }

            break;
            // down
            case 40:
                e.preventDefault();
                
                nextRow = $('#employeeRow'+currentEmployee.id).next().next();
                if(nextRow.attr('id').indexOf("employeeRow") != -1) {
                    var strId = "employeeRow";
                    var strIdLn = strId.length;
                    
                    checkRow(parseInt(nextRow.attr('id').substr(strIdLn)));
                    nextRow.addClass('active');
                }

            break;
            // delete
            case 46:
                removeEmployee();
            break;
            default: ; 
        }

    });
//    });

function sortTable(field){
    var sortedEmployeers;
    //sortedEmployeers = employeers.sort(sortBy('first_name',1));

    switch(field) {
            
        case 'first_name': 
             if(sortingDirection.first_name == 1){
                sortedEmployeers = employeers.sort(sortBy('first_name'));
            }else{
                sortedEmployeers = employeers.sort(sortBy('first_name',-1));
            }
        break;
        case 'surname':
            if(sortingDirection.surname == 1){
                sortedEmployeers = employeers.sort(sortBy('surname'));
            }else{
                sortedEmployeers = employeers.sort(sortBy('surname',-1));
            }
        break;
        case 'birth_date':
            if(sortingDirection.birth_date == 1){
                sortedEmployeers = employeers.sort(sortBy('birth_date'));
            }else{
                sortedEmployeers = employeers.sort(sortBy('birth_date',-1));
            }
        break;
        case 'salary':
            if(sortingDirection.salary == 1){
                sortedEmployeers = employeers.sort(sortBy('salary'));
            }else{
                sortedEmployeers = employeers.sort(sortBy('salary',-1));
            }
        break;
        default: ;
            
        }
        
    var firstNameCol, surnameCol, birthDate, salary;

    if(field == 'first_name' && sortingDirection.first_name == 1){
        firstNameCol = "<th id=\"first_name\" onclick=\"sortTable('first_name')\" style=\"cursor: pointer\">First name &darr;</th>";
        sortingDirection.first_name = -1;
        sortingDirection.surname = 1;
        sortingDirection.birth_date = 1;
        sortingDirection.salary = 1;
    }else if(field == 'first_name' && sortingDirection.first_name == -1){
        firstNameCol = "<th id=\"first_name\" onclick=\"sortTable('first_name')\" style=\"cursor: pointer\">First name &uarr;</th>";
        sortingDirection.first_name = 1;
        sortingDirection.surname = 1;
        sortingDirection.birth_date = 1;
        sortingDirection.salary = 1;
    }else if(field != 'first_name'){
        firstNameCol = "<th id=\"first_name\" onclick=\"sortTable('first_name')\" style=\"cursor: pointer\">First name</th>";

    }
    
    if(field == 'surname' && sortingDirection.surname == 1){
        surnameCol = "<th id=\"surname\" onclick=\"sortTable('surname')\" style=\"cursor: pointer\">Surname &darr;</th>";
        sortingDirection.first_name = 1;
        sortingDirection.surname = -1;
        sortingDirection.birth_date = 1;
        sortingDirection.salary = 1;
    }else if(field == 'surname' && sortingDirection.surname == -1){
        surnameCol = "<th id=\"surname\" onclick=\"sortTable('surname')\" style=\"cursor: pointer\">Surname &uarr;</th>";
        sortingDirection.first_name = 1;
        sortingDirection.surname = 1;
        sortingDirection.birth_date = 1;
        sortingDirection.salary = 1;
    }else if(field != 'surname'){
        surnameCol = "<th id=\"surname\" onclick=\"sortTable('surname')\" style=\"cursor: pointer\">Surname</th>";

    }
    
    if(field == 'birth_date' && sortingDirection.birth_date == 1){
        birthDate = "<th id=\"birth_date\" onclick=\"sortTable('birth_date')\" style=\"cursor: pointer\">Date of birth &darr;</th>";
        sortingDirection.first_name = 1;
        sortingDirection.surname = 1;
        sortingDirection.birth_date = -1;
        sortingDirection.salary = 1;
    }else if(field == 'birth_date' && sortingDirection.birth_date == -1){
        birthDate = "<th id=\"birth_date\" onclick=\"sortTable('birth_date')\" style=\"cursor: pointer\">Date of birth &uarr;</th>";
        sortingDirection.first_name = 1;
        sortingDirection.surname = 1;
        sortingDirection.birth_date = 1;
        sortingDirection.salary = 1;
    }else if(field != 'birth_date'){
        birthDate = "<th id=\"birth_date\" onclick=\"sortTable('birth_date')\" style=\"cursor: pointer\">Date of birth</th>";
    }
    
    if(field == 'salary' && sortingDirection.salary == 1){
        salary = "<th id=\"salary\" onclick=\"sortTable('salary')\" style=\"cursor: pointer\">Salary &darr;</th>";
        sortingDirection.first_name = 1;
        sortingDirection.surname = 1;
        sortingDirection.birth_date = 1;
        sortingDirection.salary = -1;
    }else if(field == 'salary' && sortingDirection.salary == -1){
        salary = "<th id=\"salary\" onclick=\"sortTable('salary')\" style=\"cursor: pointer\">Salary &uarr;</th>";
        sortingDirection.first_name = 1;
        sortingDirection.surname = 1;
        sortingDirection.birth_date = 1;
        sortingDirection.salary = 1;
    }else if(field != 'salary'){
        salary = "<th id=\"salary\" onclick=\"sortTable('salary')\" style=\"cursor: pointer\">Salary</th>";

    }    

    var sortedTbl = repaintTable(employeers, firstNameCol, surnameCol, birthDate, salary);
                        
   $('#staffTbl').remove();                     
   $('#divForTable').append(sortedTbl); 
}

function sortBy(key, reverse) {

  var moveSmaller = reverse ? 1 : -1;

 
  var moveLarger = reverse ? -1 : 1;

 
  return function(a, b) {
    if (a[key] < b[key]) {
      return moveSmaller;
    }
    if (a[key] > b[key]) {
      return moveLarger;
    }
    return 0;
  };

}
function openEditModal(){

    $('#editFormModal').modal('show');

    var birthDate = currentEmployee.birth_date;
    var date = new Date(birthDate);
    
    var month = date.getMonth()+1;
    month = addZero(month);
    var year = date.getFullYear();
    var day = date.getDate();
    day = addZero(day);

    currentEmployee.birth_date = year+"-"+month+"-"+day;
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
                            var firstNameCol, surnameCol, birthDate, salary;
                            firstNameCol = "<th id=\"first_name\" onclick=\"sortTable('first_name')\" style=\"cursor: pointer\">First name</th>";
                            surnameCol = "<th id=\"surname\" onclick=\"sortTable('surname')\" style=\"cursor: pointer\">Surname</th>";
                            birthDate = "<th id=\"birth_date\" onclick=\"sortTable('birth_date')\" style=\"cursor: pointer\">Date of birth</th>";
                            salary = "<th id=\"salary\" onclick=\"sortTable('salary')\" style=\"cursor: pointer\">Salary</th>";
                            var tblAfterRemoving = repaintTable(employeers, firstNameCol, surnameCol, birthDate, salary);

                           $('#staffTbl').remove();                     
                           $('#divForTable').append(tblAfterRemoving); 
                        }
                    });
               }
           }
        });
    }
}
function repaintTable(obj, firstNameCol, surnameCol, birthDate, salary){
    var bodyStr, k;
    bodyStr = '';
    for (k = 0; k < obj.length; ++k) {
        var date = new Date(obj[k].birth_date);

        var month = date.getMonth();
        var year = date.getFullYear();
        var day = date.getDate();
        day = addZero(day);

        month = months[month];

        var tblDate = day+" "+month+" "+year;

        bodyStr = bodyStr+"<style></style><tr id=\"employeeRow"+obj[k].id+"\" ondblclick=\"openEditModal()\" onclick=\"checkRow("+obj[k].id+")\" style=\"cursor: pointer\">\n\
        <td>"+obj[k].first_name+"</td>\n\
        <td>"+obj[k].surname+"</td>\n\
        <td>"+tblDate+"</td>\n\
        <td>"+obj[k].salary+" RUB</td>\n\
        </tr>";
    }


    return "<table id=\"staffTbl\" class=\"table table-bordered\">\n\
                    <tr>\n\
                    "+firstNameCol+"\n\
                    "+surnameCol+"\n\
                    "+birthDate+"\n\
                    "+salary+"\n\
                    </tr> \n\
                    "+bodyStr+"\n\
                    </table>";
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
                currentEmployee.first_name = data.first_name;
                currentEmployee.salary = data.salary;
                $('#editFormModal').modal('hide');
           }
       }
    });
}    
    
// check row and fill the table with it's values    
function checkRow(id){ console.log(id);
$('#staffTbl tr').removeClass("active");
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
            if(data != 'false'){
                employeers.push(data);
                $('#staffTbl tbody').append("<style></style>");
                var strToAppend = "<tr id=\"employeeRow"+data.id+"\" \n\
                                    ondblclick=\"openEditModal("+data.id+")\" onclick=\"checkRow("+data.id+")\"\n\
                                    style=\"cursor: pointer\">\n\
                                    <td>"+data.first_name+"</td>\n\
                                    <td>"+data.surname+"</td>\n\
                                    <td>"+data.birth_date   +"</td>\n\
                                    <td>"+data.salary+" RUB</td>\n\
                                    </tr>";

                $('#staffTbl tbody').append(strToAppend);
                $('#createFormModal').modal('hide');
                $('#addForm input').val('');
            }
       }
    });
}
</script>  