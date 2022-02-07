<?php
session_start();

if($_SESSION["isLoggedIn"]==false){

    header("Location: login.php");
}

echo  " Hi : ".$_SESSION["user_name"]." <a href='logout.php'>Logout</a>";
?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
       <?php include 'template/head.php'; ?>
    </head>
    <body>
        <div class="container" style="margin-top: 100px;">
            <div class="row">
            <div class="col-3">
                <input type="text" class="form-control" placeholder="Search" id="search" style="margin: 5px;">
            </div>
            
            <div class="col-3">
                      <!-- Button trigger modal -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_customer_modal">
  Add
</button>
            </div>
            
        </div>
        <div class="row">
            
            <div class="col-12" >
                       <table class="table table-bordered table-hover" id="customer_table">
    
            <thead>
                <tr>
                    <th>id</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Added Date</th>
                    <th>Updated Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="customer_table_tbody" >
             </tbody>
        </table>
        
                
                
            </div>
          
            
        </div>
    <div class="row"> 
        <div class="col-3">
             <button type="button" onclick="load_table()" class="btn btn-primary">Reload</button>
        </div>
       
    </div>
        </div>
        
       
        




<!-- Modal -->
<div class="modal fade" id="add_customer_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form>
      <div class="modal-body">
          <div class="col-12">
              <label>Customer Name<span style="color: red">*</span></label>
              <input type="text" class='form-control' name="cust_name"  required="" >

          </div>
          <div class="col-12">
              <label>Customer Contact<span style="color: red">*</span></label>
              <input type="text" class='form-control' name="cust_contact"  required="" >

          </div>
          
          
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add_customer-form_submit">Add Customer</button>
      </div>
    </form>
    </div>
  </div>
</div>
        
        
<div class="modal fade" id="edit_customer_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form>
      <div class="modal-body">
          <div class="col-12">
              <label>Customer Name<span style="color: red">*</span></label>
              <input type="text" class='form-control' name="cust_name" id="edit_customer-cust_name"  required="" >

          </div>
          <div class="col-12">
              <label>Customer Contact<span style="color: red">*</span></label>
              <input type="text" class='form-control' name="cust_contact" id="edit_customer-cust_contact"  required="" >

          </div>
          
          
          
      </div>
      <div class="modal-footer">
          <input type="hidden" id="edit_customer-cust_id" name="cust_id">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-warning" id="edit_customer-form_submit">Edit Customer</button>
      </div>
    </form>
    </div>
  </div>
</div>
        
        
        

    </body>
     <script src="assets/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  
          <?php include "template/scripts.php"; ?>
   
    <script>
  function load_table(search = null){
        $.ajax({
            url: "ajax/get_customer_list.php",
            type: "GET",
            data: {"cust_id":search},
            success: function (response, status, xhr, $form) {
                var response_parsed = JSON.parse(response);
                console.log(response_parsed);
                var customer_data =response_parsed.customer_data;
                var str=``;
                $.each(customer_data,function(i,v){
                    str+=`<tr>`;
                    str+=`<td>${v.cust_id}</td>`;
                    str+=`<td>${v.cust_name}</td>`;
                    str+=`<td>${v.cust_contact}</td>`;
                    str+=`<td>${v.cust_added_date}</td>`;
                    str+=`<td>${v.cust_updated_date}</td>`;
                    str+=`<td><button class="btn btn-sm btn-warning" onclick="edit_modal(${v.cust_id})">Edit</button> <button class="btn btn-sm btn-danger" onclick="delete_customer(${v.cust_id})">Delete</button></td>`;
                    str+=`</tr>`;
                });
                
                
                $("#customer_table_tbody").html(str);
              
            },
            error: function (jqXHR, exception) {
                if (jqXHR.status === 0) {
                    alert('Not connect.\n Verify Network.');
                } else if (jqXHR.status == 404) {
                    alert('Requested page not found. [404]');
                } else if (jqXHR.status == 500) {
                    alert('Internal Server Error [500].');
                } else if (exception === 'parsererror') {
                    alert('Requested JSON parse failed.');
                } else if (exception === 'timeout') {
                    alert('Time out error.');
                } else if (exception === 'abort') {
                    alert('Ajax request aborted.');
                } else {
                    alert('Uncaught Error.\n' + jqXHR.responseText);
                }
            }
        });
      
  }
  
  load_table();
  
  $("#search").on("keyup",function(){
    var keyword =   $("#search").val();
    
    load_table(keyword);
      
  });
  
  
    $('#add_customer-form_submit').click(function (e) {
                                  e.preventDefault();

                                  var btn = $(this);
                                  var form = $(this).closest('form');
                                


                                 var fd = ""+form.serialize();
                              
                                 
                                 console.log(fd);
                                  form.validate();

                                  if (!form.valid()) {
                                      return;
                                  }


                                  btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);

                                  $.ajax({
                                      url: 'ajax/add_customer.php',
                                      type: 'GET',
                                      data: fd,
                                      success: function (response, status, xhr, $form) {

                                          
                                          // similate 2s delay
                                          try{
                                             var response_obj = JSON.parse(response); 
                                          }catch(e){
                                                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                                               
                                                toastr.warning("Incorrect JSON");
                                              return;
                                          }  
                                              if (response_obj.status == "ok") {
                                                  btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                                                  // showErrorMsg(form, response_obj.color, response_obj.message);


                                              
                                                      toastr.success("Customer  Added");
                                                      form.trigger("reset");
                                                
                                                       if($("#search").val()){
                                                             load_table($("#search").val()); 
                                                              }       
    
                                             
                                              
                                              
                                                      $('#add_customer_modal').modal('hide');

                                              

                                              } else {
                                                  btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                                                   toastr.error(response_obj.message);
                                              }

                                         
                                      },
                                      error: function (jqXHR, exception) {
                                          btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                                          if (jqXHR.status === 0) {
                                              alert('Not connect.\n Verify Network.');
                                          } else if (jqXHR.status == 404) {
                                              alert('Requested page not found. [404]');
                                          } else if (jqXHR.status == 500) {
                                              alert('Internal Server Error [500].');
                                          } else if (exception === 'parsererror') {
                                              alert('Requested JSON parse failed.');
                                          } else if (exception === 'timeout') {
                                              alert('Time out error.');
                                          } else if (exception === 'abort') {
                                              alert('Ajax request aborted.');
                                          } else {
                                              alert('Uncaught Error.\n' + jqXHR.responseText);
                                          }
                                      }
                                  });
                              });
    $('#edit_customer-form_submit').click(function (e) {
                                  e.preventDefault();

                                  var btn = $(this);
                                  var form = $(this).closest('form');
                                


                                 var fd = ""+form.serialize();
                              
                                 
                                 console.log(fd);
                                  form.validate();

                                  if (!form.valid()) {
                                      return;
                                  }


                                  btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);

                                  $.ajax({
                                      url: 'ajax/edit_customer.php',
                                      type: 'GET',
                                      data: fd,
                                      success: function (response, status, xhr, $form) {

                                          
                                          // similate 2s delay
                                          try{
                                             var response_obj = JSON.parse(response); 
                                          }catch(e){
                                                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                                               
                                                toastr.warning("Incorrect JSON");
                                              return;
                                          }  
                                              if (response_obj.status == "ok") {
                                                  btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                                                  // showErrorMsg(form, response_obj.color, response_obj.message);


                                              
                                                      toastr.success("Customer  Edited");
                                                      form.trigger("reset");
                                                
                                                       if($("#search").val()){
                                                             load_table($("#search").val()); 
                                                              }       
    
                                             
                                              
                                              
                                                      $('#edit_customer_modal').modal('hide');

                                              

                                              } else {
                                                  btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                                                   toastr.error(response_obj.message);
                                              }

                                         
                                      },
                                      error: function (jqXHR, exception) {
                                          btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                                          if (jqXHR.status === 0) {
                                              alert('Not connect.\n Verify Network.');
                                          } else if (jqXHR.status == 404) {
                                              alert('Requested page not found. [404]');
                                          } else if (jqXHR.status == 500) {
                                              alert('Internal Server Error [500].');
                                          } else if (exception === 'parsererror') {
                                              alert('Requested JSON parse failed.');
                                          } else if (exception === 'timeout') {
                                              alert('Time out error.');
                                          } else if (exception === 'abort') {
                                              alert('Ajax request aborted.');
                                          } else {
                                              alert('Uncaught Error.\n' + jqXHR.responseText);
                                          }
                                      }
                                  });
                              });




function edit_modal(id){
    
    doAjax("ajax/get_customer_details.php",{"cust_id":id},"GET").then(data=>{
       
       
       try{
               var response_parsed = JSON.parse(data); 
            }catch(e){
                   toastr.warning("Incorrect JSON");
                   return;
            }
  
       
       
       
       
       if(response_parsed.status=="ok"){
           
       var customer_data = response_parsed.customer_data;
       console.log(data);
        $("#edit_customer-cust_name").val(customer_data.cust_name);
        $("#edit_customer-cust_contact").val(customer_data.cust_contact);
        $("#edit_customer-cust_id").val(customer_data.cust_id);
       
         $("#edit_customer_modal").modal("show");
   }else{
       toastr.warning(response_parsed.message);
            }
       
              
       
       
     
    });
    
}



function delete_customer(id){
    
    Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Delete Customer!"
            }).then(function (result) {
                if (result.value) {

           
                       doAjax("ajax/delete_customer.php", {"cust_id": id}).then(data => {
                    try{
                       var response = JSON.parse(data); 
                   }catch(e){
                         toastr.warning("JSON ERROR");
                         return;
                    }
                    
                    
                    
                    if (response.status == "ok") {
                        toastr.warning("Customer Deleted");
                        
                          if($("#search").val()){
                                                             load_table($("#search").val()); 
                                                              }      
                    } else {
                        toastr.error(response.message);
                    }
                    
                });




                }
            });   
    
}







async function doAjax(url, data, type = "POST") {
    $(".load_data").addClass("blurry");
    $(".load_data").fadeIn(300);
    let result;
    try {
        result = await $.ajax({
            url: url,
            type: type,
            async: true,
            data: data,
            success: function (response, status, xhr, $form) {

                $(".load_data").removeClass("blurry");
            },
            error: function (jqXHR, exception) {
                if (jqXHR.status === 0) {
                    alert('Not connect.\n Verify Network.');
                } else if (jqXHR.status == 404) {
                    alert('Requested page not found. [404]');
                } else if (jqXHR.status == 500) {
                    alert('Internal Server Error [500].');
                } else if (exception === 'parsererror') {
                    alert('Requested JSON parse failed.');
                } else if (exception === 'timeout') {
                    alert('Time out error.');
                } else if (exception === 'abort') {
                    alert('Ajax request aborted.');
                } else {
                    alert('Uncaught Error.\n' + jqXHR.responseText);
                }
            }
        });
        return result;
    } catch (error) {
        console.log(error);
}

}





    </script>
</html>
