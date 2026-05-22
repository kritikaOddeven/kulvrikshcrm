 <div class="accordion-item">
     <h2 class="accordion-header">
         <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSeven" aria-expanded="false" aria-controls="panelsStayOpen-collapseSeven">
            Children Information
     </h2>
     <div id="panelsStayOpen-collapseSeven" class="accordion-collapse collapse">
         <div class="accordion-body">
                 {{-- add brother's sister's  --}}
                 <div class="row">
                     <div class="col-lg-4 col-md-6 mb-2">
                         <label for="validationDefault01" class="form-label">Gender</label>
                         <select class="form-select" id="child_gender" name="child_gender[]">
                             <option selected disabled>Select Gender</option>
                             <option value="male">Male</option>
                             <option value="female">Female</option>
                         </select>
                     </div>
                     <div class="col-lg-4 col-md-6 mb-2">
                         <label for="validationDefault01" class="form-label">Children Name</label>
                         <input type="text" class="form-control" id="validationDefault01" name="child_name[]">
                     </div>
                     <div class="col-lg-4 col-md-6 mb-2">
                         <label for="validationDefault01" class="form-label">Birth Date</label>
                         <div class="position-relative">
                             <input type="text" class="form-control basic-datepicker pe-5" name="child_dob[]" placeholder="dd-mm-yyyy">
                             <i class="ri-calendar-2-line calendar-icon"></i>
                         </div>
                     </div>
                 </div>

                 {{-- Dynamic row will be added here for brother sister details  --}}

                 <div id="childContainer">
                     <!-- Dynamic form rows will be added here -->
                 </div>
                 <!-- Buttons -->
                 <div class="row justify-content-between mt-1">
                     <div class="col-auto mb-2">
                         <button id="addChildRow" class="btn btn-primary">+ Add More</button>
                     </div>
                     <div class="col-auto mb-2">
                         <button id="deleteChildRow" class="btn btn-danger" style="display: none"><i class="ri-delete-bin-line"></i> Delete</button>
                     </div>
                 </div>
         </div>

     </div>
 </div>
