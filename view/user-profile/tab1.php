<h2 class="c-heading">
  Agent Profile
</h2>
<div class="accordion c-userProfileAccord" id="accordionExample">
  <!-- ** Accord 1 ** -->
  <div class="card">
    <div class="card-header" id="headingProfileOverview">
      <button class="btnShow" type="button" data-toggle="collapse"
        data-target="#collapseProfileOverview" aria-expanded="true"
        aria-controls="collapseProfileOverview">
        <span>BASIC INFORMATION</span>
      </button>
    </div>
    <div id="collapseProfileOverview" class="collapse show" aria-labelledby="headingProfileOverview"
      data-parent="#accordionExample">
      <div class="card-body">
        <form id="basic_info">
          <input type="hidden" id="register_id" value="<?= $sq_query['register_id'] ?>" />
          <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>*Company Name</label>
                <input type="text" class="txtBox" id="company_name" value="<?= $sq_query['company_name'] ?>" required readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Accounting Name</label>
                <input type="text" class="txtBox" id="acc_name" value="<?= $sq_query['accounting_name'] ?>" readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>IATA Status</label>
                <select class="form-control txtBox" id='iata_status' title='IATA Status' data-toggle="tooltip" name='iata_status' disabled>
                  <?php if($sq_query['iata_status']!=''){?>
                  <option value="<?=$sq_query['iata_status'] ?>"><?=$sq_query['iata_status'] ?></option><?php } ?>
                  <option value=''>IATA Status</option>
                  <option value='Approved'>Approved</option>
                  <option value='Not Approved'>Not Approved</option>
                </select>
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>IATA Reg.Number</label>
                <input type="text" class="txtBox" id="iata_no" value="<?=$sq_query['iata_reg_no'] ?>" readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Nature of Business</label>
                <input type="text" class="txtBox" id="nature" value="<?=$sq_query['nature_of_business'] ?>" readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Preferred Currency</label>
                <select class="form-control txtBox" id='currency_id' title='Preferred Currency' name='currency' style='width:100%;' data-toggle="tooltip" disabled>
                  <?php if($sq_query['currency']!=0){ $sq_cur = mysqli_fetch_assoc(mysqlQuery("select id,currency_code from currency_name_master where id='$sq_query[currency]'"));?>
                  <option value="<?= $sq_cur['id'] ?>"><?= $sq_cur['currency_code'] ?></option>
                  <?php } ?>
                  <option value=''>Preferred Currency</option>
                  <?php
                  $sq_currency = mysqlQuery("select id,currency_code from currency_name_master where 1");
                  while($row_currency = mysqli_fetch_assoc($sq_currency)){ ?>
                    <option value="<?= $row_currency['id'] ?>"><?= $row_currency['currency_code'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Telephone</label>
                <input type="text" class="txtBox" id="telephone" value="<?= $sq_query['telephone'] ?>" readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Latitude</label>
                <input type="text" class="txtBox" id="latitude" value="<?= $sq_query['latitude'] ?>" readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Turnover Slab</label>
                <input type="text" class="txtBox" id="turnover" value="<?= $sq_query['turnover'] ?>" readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Skype ID</label>
                <input type="text" class="txtBox" id="skype_id" value="<?= $sq_query['skype_id'] ?>" readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Website</label>
                <input type="text" class="txtBox" id="website" value="<?= $sq_query['website'] ?>" readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>*Upload Company Logo</label>
                <div class="div-upload" title="Upload Company Logo">
                  <?php $company_logo = ($sq_query['company_logo'] == "")?'Company Logo':'Uploaded'; ?>
                  <div id="logo_upload_btn1" class="upload-button1"><span><?= $company_logo ?></span></div>
                  <span id="logo_proof_status" ></span>
                  <ul id="files" ></ul>
                  <input type="hidden" id="logo_upload_url" value="<?= $sq_query['company_logo'] ?>" name="logo_upload_url" required>
                </div>
              </div>
              <label class="alert-danger">Note : Upload Image size below 100KB, resolution : 220X85.</label>
            </div>
            <div class="col-12 text-center">
              <a class="c-button st-editProfile">Edit</a>
              <button class="c-button colGrn saveProfile" class="saveprofile">Save</button>
              <a class="c-button st-editProfile st-cancleEdit">Cancel</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- ** Accord 1 ** -->

  <!-- ** Accord 2 ** -->
  <div class="card">
    <div class="card-header" id="headingAddressInformation">
      <button class="btnShow collapsed" type="button" data-toggle="collapse"
        data-target="#collapseAddressInformation" aria-expanded="false"
        aria-controls="collapseAddressInformation">
        <span>Address Information</span>
      </button>
    </div>
    <div id="collapseAddressInformation" class="collapse" aria-labelledby="headingAddressInformation"
      data-parent="#accordionExample">
      <div class="card-body">
        <form id="address_info">
          <input type="hidden" id="register_id" value="<?= $sq_query['register_id'] ?>" />
          <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>City</label>
                <select id='city' name='city' class='form-control txtBox' style='width:100%;' title="City Name" required disabled>
                  <?php $sq_city = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$sq_query[city]'"));?>
                  <option value="<?= $sq_city['city_id'] ?>" selected="selected"><?= $sq_city['city_name'] ?></option>
                </select>
              </div>
            </div>
            <div class="col-md-4 col-12">
              <div class="formField">
                <label>Address-1</label>
                <input type="text" class="txtBox" id="address1" value="<?= $sq_query['address1'] ?>" readonly />
              </div>
            </div>
            <div class="col-md-4 col-12">
              <div class="formField">
                <label>Address-2</label>
                <input type="text" class="txtBox" id="address2" value="<?= $sq_query['address2'] ?>" readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Pincode</label>
                <input type="text" class="txtBox" id="pincode" value="<?= $sq_query['pincode'] ?>" readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Country</label>
                <select class="form-control txtBox" id='country' title='Country' name='country' style='width:100%;' disabled>
                  <?php if($sq_query['country']!=0){ $sq_coun = mysqli_fetch_assoc(mysqlQuery("select * from country_list_master where country_id='$sq_query[country]'"));?>
                      <option value="<?= $sq_coun['country_id'] ?>"><?= $sq_coun['country_name'].'('.$sq_coun['country_code'].')' ?></option>
                  <?php } ?>
                    <option value=''>Country</option>
                    <?php
                    $sq_country = mysqlQuery("select * from country_list_master where 1");
                    while($row_country = mysqli_fetch_assoc($sq_country)){ ?>
                      <option value="<?= $row_country['country_id'] ?>"><?= $row_country['country_name'].'('.$row_country['country_code'].')' ?></option>
                    <?php } ?>
                  </select>
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Timezone</label>
                <input type="text" class="txtBox" id="timezone" value="<?= $sq_query['timezone'] ?>" readonly />
              </div>
            </div>
            <div class="col-md-6 col-sm-6 col-12">
              <div class="formField">
                <label>Upload Address Proof</label>
                  <div class="div-upload" role='button' title="Upload Address Proof" data-toggle="tooltip">
                  <?php $address_proof = ($sq_query['address_proof_url'] == "")?'Address Proof':'Uploaded'; ?>
                    <div id="address_upload_btn1" class="upload-button1"><span><?= $address_proof ?></span></div>
                    <span id="id_proof_status" ></span>
                    <ul id="files" ></ul>
                    <input type="hidden" id="address_upload_url" value="<?=$sq_query['address_proof_url'] ?>" name="address_upload_url">
                  </div>
              </div>
                <label class="alert-danger error">Note : Only PDF,JPG or PNG files are allowed.</label>
            </div>
            <div class="col-12 text-center">
              <a class="c-button st-editProfile">Edit</a>
              <button class="c-button colGrn saveProfile">Save</button>
              <a class="c-button st-editProfile st-cancleEdit">Cancel</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- ** Accord 2 End ** -->

  <!-- ** Accord 3 ** -->
  <div class="card">
    <div class="card-header" id="headingPersonalInformaiton">
      <button class="btnShow collapsed" type="button" data-toggle="collapse"
        data-target="#collapsePersonalInformaiton" aria-expanded="false"
        aria-controls="collapsePersonalInformaiton">
        <span>Contact Person Information</span>
      </button>
    </div>
    <div id="collapsePersonalInformaiton" class="collapse" aria-labelledby="headingPersonalInformaiton"
      data-parent="#accordionExample">
      <div class="card-body">
        <form id="pcontact_info">
          <input type="hidden" id="register_id" value="<?= $sq_query['register_id'] ?>" />
          <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>First Name</label>
                <input type="text" class="txtBox" id="contact_personf" placeholder="First Name" value="<?= $sq_query['cp_first_name'] ?>" required readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Last Name</label>
                <input type="text" class="txtBox" id="contact_personl" placeholder="Last Name" value="<?= $sq_query['cp_last_name'] ?>" required readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Email ID</label>
                <input type="email" class="txtBox" id="email_id" placeholder="Email ID" value="<?= $sq_query['email_id'] ?>" required readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Mobile Number</label>
                <input type="number" class="txtBox" id="mobile_no" placeholder="Mobile Number" value="<?= $sq_query['mobile_no'] ?>" required readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Whatsapp Number</label>
                <input type="number" class="txtBox" id="whatsapp_no" placeholder="Whatsapp Number" value="<?= $sq_query['whatsapp_no'] ?>" readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Designation</label>
                <input type="text" class="txtBox" id="designation" value="<?= $sq_query['designation'] ?>" placeholder="Designation" readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>PAN Card No.</label>
                <input type="text" class="txtBox" id="pan_card" placeholder="PAN Card No." value="<?= $sq_query['pan_card'] ?>" readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Upload ID Proof</label>
                <div class="div-upload" role='button' title="Upload ID Proof" data-toggle="tooltip">
                  <?php $id_proof = ($sq_query['id_proof_url'] == "")?'ID Proof':'Uploaded'; ?>
                  <div id="photo_upload_btn_p" class="upload-button1"><span><?= $id_proof ?></span></div>
                  <span id="photo_status" ></span>
                  <ul id="files" ></ul>
                  <input type="hidden" id="photo_upload_url" value="<?= $sq_query['id_proof_url'] ?>" name="photo_upload_url">
                </div>
              </div>
              <label class="alert-danger error">Note : Only PDF,JPG or PNG files are allowed.</label>
            </div>
            <div class="col-12 text-center">
              <a class="c-button st-editProfile">Edit</a>
              <button class="c-button colGrn saveProfile">Save</button>
              <a class="c-button st-editProfile st-cancleEdit">Cancel</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- ** Accord 3 End ** -->

  <!-- ** Accord 4 ** -->
  <div class="card">
    <div class="card-header" id="headingAccountInformaiton">
      <button class="btnShow collapsed" type="button" data-toggle="collapse"
        data-target="#collapseAccountInformaiton" aria-expanded="false"
        aria-controls="collapseAccountInformaiton">
        <span>Account Information</span>
      </button>
    </div>
    <div id="collapseAccountInformaiton" class="collapse" aria-labelledby="headingAccountInformaiton"
      data-parent="#accordionExample">
      <div class="card-body">
        <form id="account_info">
          <input type="hidden" id="register_id" value="<?= $sq_query['register_id'] ?>" />
          <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Bank Name</label>
                <input type="text" class="txtBox" placeholder="Bank Name" id="b_bank_name" value="<?= $sq_query['b_bank_name'] ?>" readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Bank Account Name</label>
                <input type="text" class="txtBox" placeholder="Bank Account Name" id="b_acc_name"
                  value="<?= $sq_query['b_acc_name'] ?>" readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Bank Account Number</label>
                <input type="text" class="txtBox" placeholder="Bank Account Number" id="b_acc_no"
                  value="<?= $sq_query['b_acc_no'] ?>" readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Branch Name</label>
                <input type="text" class="txtBox" placeholder="Branch Name" id="b_branch_name" value="<?= $sq_query['b_branch_name'] ?>"
                  readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>IFSC Code</label>
                <input type="text" class="txtBox" placeholder="IFSC Code" id="b_ifsc_code" value="<?= $sq_query['b_ifsc_code'] ?>" readonly />
              </div>
            </div>
            <div class="col-12 text-center">
              <a class="c-button st-editProfile">Edit</a>
              <button class="c-button colGrn saveProfile">Save</button>
              <a class="c-button st-editProfile st-cancleEdit">Cancel</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- ** Accord 4 End ** -->

  <!-- ** Accord 4 ** -->
  <div class="card">
    <div class="card-header" id="headingChangePassword">
      <button class="btnShow collapsed" type="button" data-toggle="collapse"
        data-target="#collapseChangePassword" aria-expanded="false"
        aria-controls="collapseChangePassword">
        <span>Change Password</span>
      </button>
    </div>
    <div id="collapseChangePassword" class="collapse" aria-labelledby="headingChangePassword"
      data-parent="#accordionExample">
      <div class="card-body">
        <form id="password_info">
          <input type="hidden" id="register_id" value="<?= $sq_query['register_id'] ?>" />
          <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>User Name</label>
                <input type="text" class="txtBox" id="username" placeholder="Username" value="<?= $username ?>" required readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Enter New Password</label>
                <input type="Password" class="txtBox" id="password" value="<?= $password ?>" placeholder="New Password" required readonly />
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="formField">
                <label>Retype New Password</label>
                <input type="Password" class="txtBox" id="repassword" placeholder="Retype Password" required readonly />
              </div>
            </div>
            <div class="col-12 text-center">
              <a class="c-button st-editProfile">Edit</a>
              <button class="c-button colGrn saveProfile">Save</button>
              <a class="c-button st-editProfile st-cancleEdit">Cancel</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- ** Accord 4 End ** -->

</div>