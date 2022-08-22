<?php

include 'config.php';

$service = $_GET['service'];

//Include header

include 'layouts/header.php';

?>


<!-- ********** Component :: Page Title ********** -->

<div class="c-pageTitleSect ts-pageTitleSect">

<div class="container">

  <div class="row">

    <div class="col-md-7 col-12">



      <!-- *** Search Head **** -->

      <div class="searchHeading">

        <span class="pageTitle mb-0">Careers</span>

      </div>

      <!-- *** Search Head End **** -->

    </div>



    <div class="col-md-5 col-12 c-breadcrumbs">

      <ul>

        <li>

          <a href="<?= BASE_URL_B2C ?>">Home</a>

        </li>

        <li class="st-active">

          <a href="javascript:void(0)">Careers</a>

        </li>

      </ul>

    </div>



  </div>

</div>

</div>

<!-- ********** Component :: Page Title End ********** -->
<!-- Landing Section Start -->

<!-- <section class="ts-inner-landing-section ts-font-poppins">

    <img src="images/banner-2.jpg" alt="" class="img-fluid">

    <div class="ts-inner-landing-content">

        <div class="container">

            <h1 class="ts-section-title">Careers</h1>

        </div>

    </div>

</section> -->

<!-- Landing Section End -->



<!-- Contact Section Start -->

<section class="ts-contact-section">

    <div class="container">

        <div class="ts-section-subtitle-content">

            <h2 class="ts-section-subtitle">Careers</h2>

            <span class="ts-section-subtitle-icon"><img src="images/traveler.png" alt="traveler" classimg-fluid></span>

        </div>

        <h2 class="ts-section-title">CURRENT OPENINGS</h2>

        <div class="row">

            <div class="col col-12 col-md-6 col-lg-8">

                <div class="ts-careers-content">

                    <div id="accordion" class="ts-accordion">

                        <div class="card">

                            <div class="card-header" id="headingOne">

                            <h5 class="mb-0">

                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">

                                Collapsible Group Item #1

                                </button>

                            </h5>

                            </div>



                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">

                            <div class="card-body">

                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.

                            </div>

                            </div>

                        </div>

                        <div class="card">

                            <div class="card-header" id="headingTwo">

                            <h5 class="mb-0">

                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">

                                Collapsible Group Item #2

                                </button>

                            </h5>

                            </div>

                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">

                            <div class="card-body">

                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.

                            </div>

                            </div>

                        </div>

                        <div class="card">

                            <div class="card-header" id="headingThree">

                            <h5 class="mb-0">

                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">

                                Collapsible Group Item #3

                                </button>

                            </h5>

                            </div>

                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">

                            <div class="card-body">

                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.

                            </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col col-12 col-md-6 col-lg-4">

                <div class="ts-careers-apply-content">

                    <h3 class="ts-careers-apply-title">APPLY NOW</h3>

                    <form id="career_form" class="needs-validation" novalidate>

                        <div class="form-row">

                            <div class="form-group col-md-12">

                                <input type="text" class="form-control" id="inputName" name="inputName" placeholder="*Enter Name" onkeypress="return blockSpecialChar(event)" required>

                            </div>

                            <div class="form-group col-md-12">

                                <input type="number" class="form-control" id="inputPhone" name="inputPhone" placeholder="*Enter Phone" required>

                            </div>

                            <div class="form-group col-md-12">

                                <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="*Enter Email ID" required>

                            </div>

                            <div class="form-group col-md-12">

                                <input type="text" class="form-control" id="inputPos" name="inputPos" placeholder="*Enter Position" required>

                            </div>

                            <div class="form-group col-md-12">

                                <!-- <input type="file" class="form-control" id="inputFile" name="inputFile"> -->

                                <div class="div-upload">

                                        <div id="hotel_btn1" class="upload-button1"><span>Upload Resume</span></div>

                                        <span id="id_proof_status" ></span>

                                        <ul id="files" ></ul>

                                        <input type="hidden" id="inputFile_url" name="inputFile_url">

                                </div>

                            </div>

                        </div>

                        <div class="text-center">

                            <button type="submit" class="btn btn-primary" id="career_form_send">Submit</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- Contact Section End -->



<?php include 'layouts/footer.php';?>

<script type="text/javascript" src="js/scripts.js"></script>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>

<script>

upload_pic_attch();

function upload_pic_attch()

{



    var base_url = $('#crm_base_url').val();

    var btnUpload=$('#hotel_btn1');

    $(btnUpload).find('span').text('Upload Resume');

    $("#inputFile_url").val('');

    new AjaxUpload(btnUpload, {



      action: 'upload_resume.php',

      name: 'uploadfile',

      onSubmit: function(file, ext){  



        if (! (ext && /^(txt|pdf|doc|docx)$/.test(ext))){ 

         error_msg_alert('Only Text,PDF or word files are allowed',base_url);

         return false;

        }

         

        $(btnUpload).find('span').text('Uploading...');



      },



      onComplete: function(file, response){



        if(response==="error"){          



          error_msg_alert("File is not uploaded.",base_url);           



          $(btnUpload).find('span').text('Upload Resume');



        }else



        { 



          if(response=="error1")



          {



            $(btnUpload).find('span').text('Upload Resume');



            error_msg_alert('Maximum size exceeds',base_url);



            return false;



          }else



          {



            $(btnUpload).find('span').text('Uploaded');

            $("#inputFile_url").val(response);



          }



        }



      }



    });



}

// Example starter JavaScript for disabling form submissions if there are invalid fields

(function() {

    'use strict';

    window.addEventListener('load', function() {

        // Fetch all the forms we want to apply custom Bootstrap validation styles to

        var forms = document.getElementsByClassName('needs-validation');

        // Loop over them and prevent submission

        var validation = Array.prototype.filter.call(forms, function(form) {

        form.addEventListener('submit', function(event) {

            if (form.checkValidity() === false) {

            event.preventDefault();

            event.stopPropagation();

            }

            form.classList.add('was-validated');

        }, false);

        });

    }, false);

})();



$(function () {

	$('#career_form').validate({

		rules         : {

            // inputName: { required: true },

            // inputEmail: { required: true },

            // inputPhone: { required: true },

            // inputFile_url: { required: true },

            // inputPos : { required: true }

        },

		submitHandler : function (form) {



			$('#career_form_send').prop('disabled',true);

			

			var crm_base_url = $('#crm_base_url').val();

			var base_url = $('#base_url').val();

			var name = $('#inputName').val();

			var email = $('#inputEmail').val();

			var phone = $('#inputPhone').val();

			var file = $('#inputFile_url').val();

			var pos = $('#inputPos').val();

            if(name==''||email==''||phone==''||file==''||pos==''){

                if(file==''){

                    error_msg_alert('Upload your resume please!',base_url);

                    $('#career_form_send').prop('disabled',false);

                    return false;

                }else{

                    $('#career_form_send').prop('disabled',false);

                    return false;   

                }

            }

            $('#career_form_send').button('loading');

			$.ajax({

				type  : 'post',

				url   : crm_base_url + 'controller/b2c_settings/b2c/career_form_mail.php',

				data  : {

					name : name,

					email : email,

					phone : phone,

					file : file,

                    pos:pos

				},

				success : function (result) {

                    $('#career_form_send').prop('disabled',false);

                    $('#career_form_send').button('reset');

                    success_msg_alert(result,base_url);

                    setTimeout(()=>{

                        $('#inputName').val('');

                        $('#inputEmail').val('');

                        $('#inputPhone').val('');

                        $('#inputFile_url').val('');

                        $('#inputPos').val('');

                        return false;

                    },1000);

                }

            });

        }

    });

});

</script>