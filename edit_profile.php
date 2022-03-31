<!DOCTYPE html>
<?php
session_start();
include('include/header.php');
if(!isset($_SESSION['email'])){
  header("location: index.php");
}
 ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Edit Account</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="row">
      <div class="col-sm-2">
      </div>
      <div class="col-sm-8">
        <form enctype="multipart/form-data" action="" method="post">
          <table class="table table-bordered table-hover">
            <tr align="center">
              <td colspan="6" class="active"><h2>Edit Your Profile</h2></td>
            </tr>
            <tr>
              <td style="font-weight:bold;">Firstname</td>
              <td><input class="form-control" type="text" name="fname" required value="<?php echo "$user_fname"; ?>"></td>
            </tr>
            <tr>
              <td style="font-weight:bold;">Lastname</td>
              <td><input class="form-control" type="text" name="lname" required value="<?php echo "$user_lname"; ?>"></td>
            </tr>
            <tr>
              <td style="font-weight:bold;">About</td>
              <td><input class="form-control" type="text" name="about" value="<?php echo "$user_about"; ?>"></td>
            </tr>
            <tr>
              <td style="font-weight: bold;">Marital Status</td>
              <td>
                <select class="form-control" name="Relationship">
                  <option><?php echo $user_mstatus; ?></option>
                  <option>Engaged</option>
                  <option>Single</option>
                  <option>Married</option>
                  <option>In a Relationship</option>
                  <option>It's Complicated</option>
                  <option>Seperated</option>
                  <option>Divorced</option>
                  <option>Widowed</option>
                </select>
              </td>
            </tr>
            <tr>
              <td style="font-weight:bold;">Email</td>
              <td><input class="form-control" type="email" name="email" required value="<?php echo "$user_email"; ?>"></td>
            </tr>
            <tr>
              <td style="font-weight:bold;">Phone Number</td>
              <td><input class="form-control" type="text" name="phone_number" required value="<?php echo "$user_phone"; ?>"></td>
            </tr>
            <tr>
              <td style="font-weight: bold;">Privacy</td>
              <td>
                <select class="form-control" name="privacy">
                  <option><?php echo $user_privacy; ?></option>
                  <option>Public</option>
                  <option>Private</option>
                </select>
              </td>
            </tr>
            <tr>
              <td style="font-weight: bold;">Gender</td>
              <td>
                <select class="form-control" name="Gender">
                  <option><?php echo $user_gender; ?></option>
                  <option>Male</option>
                  <option>Female</option>
                  <option>Other</option>
                </select>
              </td>
            </tr>
            <tr>
              <td style="font-weight:bold;">Birthday</td>
              <td><input class="form-control input-md" type="date" name="birthday" required value="<?php echo "$user_birthday"; ?>"></td>
            </tr>
            <tr>
              <td style="font-weight: bold;">Country</td>

              <td>
                <select class="form-control" name="country">
              					<option selected><?php echo $user_country; ?></option>
           				      <option value="afghan">Afghan</option>
            					  <option value="albanian">Albanian</option>
           					    <option value="algerian">Algerian</option>
              					<option value="american">American</option>
              					<option value="andorran">Andorran</option>
              					<option value="angolan">Angolan</option>
              					<option value="antiguans">Antiguans</option>
              					<option value="argentinean">Argentinean</option>
              					<option value="armenian">Armenian</option>
              					<option value="australian">Australian</option>
              					<option value="austrian">Austrian</option>
                        <option value="azerbaijani">Azerbaijani</option>
                        <option value="bahamian">Bahamian</option>
                        <option value="bahraini">Bahraini</option>
                        <option value="bangladeshi">Bangladeshi</option>
                        <option value="barbadian">Barbadian</option>
                        <option value="barbudans">Barbudans</option>
                        <option value="batswana">Batswana</option>
                        <option value="belarusian">Belarusian</option>
                        <option value="belgian">Belgian</option>
                        <option value="belizean">Belizean</option>
                        <option value="beninese">Beninese</option>
                        <option value="bhutanese">Bhutanese</option>
                        <option value="bolivian">Bolivian</option>
                        <option value="bosnian">Bosnian</option>
                        <option value="brazilian">Brazilian</option>
                        <option value="british">British</option>
                        <option value="bruneian">Bruneian</option>
                        <option value="bulgarian">Bulgarian</option>
                        <option value="burkinabe">Burkinabe</option>
                        <option value="burmese">Burmese</option>
                        <option value="burundian">Burundian</option>
                        <option value="cambodian">Cambodian</option>
                        <option value="cameroonian">Cameroonian</option>
                        <option value="canadian">Canadian</option>
                        <option value="cape verdean">Cape Verdean</option>
                        <option value="central african">Central African</option>
                        <option value="chadian">Chadian</option>
                        <option value="chilean">Chilean</option>
                        <option value="chinese">Chinese</option>
                        <option value="colombian">Colombian</option>
                        <option value="comoran">Comoran</option>
                        <option value="congolese">Congolese</option>
                        <option value="costa rican">Costa Rican</option>
                        <option value="croatian">Croatian</option>
                        <option value="cuban">Cuban</option>
                        <option value="cypriot">Cypriot</option>
                        <option value="czech">Czech</option>
                        <option value="danish">Danish</option>
                        <option value="djibouti">Djibouti</option>
                        <option value="dominican">Dominican</option>
                        <option value="dutch">Dutch</option>
                        <option value="east timorese">East Timorese</option>
                        <option value="ecuadorean">Ecuadorean</option>
                        <option value="egyptian">Egyptian</option>
                        <option value="emirian">Emirian</option>
                        <option value="equatorial guinean">Equatorial Guinean</option>
                        <option value="eritrean">Eritrean</option>
                        <option value="estonian">Estonian</option>
                        <option value="ethiopian">Ethiopian</option>
                        <option value="fijian">Fijian</option>
                        <option value="filipino">Filipino</option>
                        <option value="finnish">Finnish</option>
                        <option value="french">French</option>
                        <option value="gabonese">Gabonese</option>
                        <option value="gambian">Gambian</option>
                        <option value="georgian">Georgian</option>
                        <option value="german">German</option>
                        <option value="ghanaian">Ghanaian</option>
                        <option value="greek">Greek</option>
                        <option value="grenadian">Grenadian</option>
                        <option value="guatemalan">Guatemalan</option>
                        <option value="guinea-bissauan">Guinea-Bissauan</option>
                        <option value="guinean">Guinean</option>
                        <option value="guyanese">Guyanese</option>
                        <option value="haitian">Haitian</option>
                        <option value="herzegovinian">Herzegovinian</option>
                        <option value="honduran">Honduran</option>
                        <option value="hungarian">Hungarian</option>
                        <option value="icelander">Icelander</option>
                        <option value="indian">Indian</option>
                        <option value="indonesian">Indonesian</option>
                        <option value="iranian">Iranian</option>
                        <option value="iraqi">Iraqi</option>
                        <option value="irish">Irish</option>
                        <option value="israeli">Israeli</option>
                        <option value="italian">Italian</option>
                        <option value="ivorian">Ivorian</option>
                        <option value="jamaican">Jamaican</option>
                        <option value="japanese">Japanese</option>
                        <option value="jordanian">Jordanian</option>
                        <option value="kazakhstani">Kazakhstani</option>
                        <option value="kenyan">Kenyan</option>
                        <option value="kittian and nevisian">Kittian and Nevisian</option>
                        <option value="kuwaiti">Kuwaiti</option>
                        <option value="kyrgyz">Kyrgyz</option>
                        <option value="laotian">Laotian</option>
                        <option value="latvian">Latvian</option>
                        <option value="lebanese">Lebanese</option>
                        <option value="liberian">Liberian</option>
                        <option value="libyan">Libyan</option>
                        <option value="liechtensteiner">Liechtensteiner</option>
                        <option value="lithuanian">Lithuanian</option>
                        <option value="luxembourger">Luxembourger</option>
                        <option value="macedonian">Macedonian</option>
                        <option value="malagasy">Malagasy</option>
                        <option value="malawian">Malawian</option>
                        <option value="malaysian">Malaysian</option>
                        <option value="maldivan">Maldivan</option>
                        <option value="malian">Malian</option>
                        <option value="maltese">Maltese</option>
                        <option value="marshallese">Marshallese</option>
                        <option value="mauritanian">Mauritanian</option>
                        <option value="mauritian">Mauritian</option>
                        <option value="mexican">Mexican</option>
                        <option value="micronesian">Micronesian</option>
                        <option value="moldovan">Moldovan</option>
                        <option value="monacan">Monacan</option>
                        <option value="mongolian">Mongolian</option>
                        <option value="moroccan">Moroccan</option>
                        <option value="mosotho">Mosotho</option>
                        <option value="motswana">Motswana</option>
                        <option value="mozambican">Mozambican</option>
                        <option value="namibian">Namibian</option>
                        <option value="nauruan">Nauruan</option>
                        <option value="nepalese">Nepalese</option>
                        <option value="new zealander">New Zealander</option>
                        <option value="ni-vanuatu">Ni-Vanuatu</option>
                        <option value="nicaraguan">Nicaraguan</option>
                        <option value="nigerien">Nigerien</option>
                        <option value="north korean">North Korean</option>
                        <option value="northern irish">Northern Irish</option>
                        <option value="norwegian">Norwegian</option>
                        <option value="omani">Omani</option>
                        <option value="pakistani">Pakistani</option>
                        <option value="palauan">Palauan</option>
                        <option value="panamanian">Panamanian</option>
                        <option value="papua new guinean">Papua New Guinean</option>
                        <option value="paraguayan">Paraguayan</option>
                        <option value="peruvian">Peruvian</option>
                        <option value="polish">Polish</option>
                        <option value="portuguese">Portuguese</option>
                        <option value="qatari">Qatari</option>
                        <option value="romanian">Romanian</option>
                        <option value="russian">Russian</option>
                        <option value="rwandan">Rwandan</option>
                        <option value="saint lucian">Saint Lucian</option>
                        <option value="salvadoran">Salvadoran</option>
                        <option value="samoan">Samoan</option>
                        <option value="san marinese">San Marinese</option>
                        <option value="sao tomean">Sao Tomean</option>
                        <option value="saudi">Saudi</option>
                        <option value="scottish">Scottish</option>
                        <option value="senegalese">Senegalese</option>
                        <option value="serbian">Serbian</option>
                        <option value="seychellois">Seychellois</option>
                        <option value="sierra leonean">Sierra Leonean</option>
                        <option value="singaporean">Singaporean</option>
                        <option value="slovakian">Slovakian</option>
                        <option value="slovenian">Slovenian</option>
                        <option value="solomon islander">Solomon Islander</option>
                        <option value="somali">Somali</option>
                        <option value="south african">South African</option>
                        <option value="south korean">South Korean</option>
                        <option value="spanish">Spanish</option>
                        <option value="sri lankan">Sri Lankan</option>
                        <option value="sudanese">Sudanese</option>
                        <option value="surinamer">Surinamer</option>
                        <option value="swazi">Swazi</option>
                        <option value="swedish">Swedish</option>
                        <option value="swiss">Swiss</option>
                        <option value="syrian">Syrian</option>
                        <option value="taiwanese">Taiwanese</option>
                        <option value="tajik">Tajik</option>
                        <option value="tanzanian">Tanzanian</option>
                        <option value="thai">Thai</option>
                        <option value="togolese">Togolese</option>
                        <option value="tongan">Tongan</option>
                        <option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
                        <option value="tunisian">Tunisian</option>
                        <option value="turkish">Turkish</option>
                        <option value="tuvaluan">Tuvaluan</option>
                        <option value="ugandan">Ugandan</option>
                        <option value="ukrainian">Ukrainian</option>
                        <option value="uruguayan">Uruguayan</option>
                        <option value="uzbekistani">Uzbekistani</option>
                        <option value="venezuelan">Venezuelan</option>
            		        <option value="vietnamese">Vietnamese</option>
           		 	        <option value="welsh">Welsh</option>
            		        <option value="yemenite">Yemenite</option>
            		        <option value="zambian">Zambian</option>
           	  		      <option value="zimbabwean">Zimbabwean</option>
    						</select>
              </td>
            </tr>
            <tr>
              <td style="font-weight:bold;">Recovery Question</td>
              <td><input class="form-control" type="text" name="recovery_question" value="<?php echo "$recovery_question"; ?>"></td>
            </tr>
            <tr>
              <td style="font-weight:bold;">Recovery Answer</td>
              <td><input class="form-control" type="password" name="recovery_answer" value=""></td>
            </tr>
            <tr>
              <td style="font-weight: bold">Forgetten Password</td>
              <td>
                <!-- <input type="submit" class="btn btn-default" name="button" data-toggle="modal" data-target="#myModal" value="Turn On"> -->
                <button type="button" class="btn btn-default" name="button" data-toggle="modal" data-target="#myModal">Turn On</button>
                <div id="myModal" class="modal" role="dialog" data-backdrop="static">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Modal Header</h4>
                      </div>
                      <div class="modal-body">
                        <form class="" action="recovery.php?id=<?php echo $uid; ?>" id="f" method="post">
                          <strong><?php echo "$recovery_question"; ?></strong>
                          <textarea name="answer" rows="4" cols="70" placeholder="Answer"></textarea><br>
                          <button class="btn btn-default" type="submit" name="sub"  data-toggle="modal" value="<?php echo $uid; ?>" style="width:100px;">Submit</button><br><br>
                          <pre>Answer the above question. We will ask this question if you forgot <br> password. </pre><br><br>
                        </form>
                        <?php
                            if(isset($_GET['uid'])){
                              $uid = $_GET['uid'];
                            }
                            if(isset($_POST['sub'])){
                              $answer = htmlentities($_POST['answer']);
                              if($answer==""){
                                echo"<script>alert('please enter something')</script>";
                                echo"<script>wiindow.open('edit_profile.php?uid='$uid','_self')</script>";
                                exit();
                              }
                              else {
                                $answer = sha1($answer);
                                if($answer == $recovery_answer){
                                  echo "string";
                                  // echo"<script>window.open('include/PasswordModal.php/#PasswordModal?uid=$uid','_self')</script>";
                                  echo"<script>window.open('include/PasswordModal.php?uid=$uid','_self')</script>";
                                }
                                else{
                                  echo"<script>alert('Error while uploading the information!')</script>";
                                  echo"<script>window.open('edit_profile.php?uid='$uid','_self')</script>";
                                }
                              }
                            }
                         ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <tr align="center">
              <td colspan="6">
                <input class="btn btn-info" type="submit" name="update" style="width:250px;" value="Update">
              </td>
            </tr>
          </table>
        </form>
      </div>
      <div class="col-sm-2">
      </div>
    </div>
  </body>
</html>
<?php
    if(isset($_POST['update'])){
      $fname=htmlentities($_POST['fname']);
      $lname=htmlentities($_POST['lname']);
      $about=htmlentities($_POST['about']);
      $mstatus=htmlentities($_POST['Relationship']);
      $country=htmlentities($_POST['country']);
      $gender=htmlentities($_POST['Gender']);
      $email = htmlentities($_POST['email']);
      $privacy = htmlentities($_POST['privacy']);
      $phone_number = htmlentities($_POST['phone_number']);
      $birthday=htmlentities($_POST['birthday']);
      $recovery_question = htmlentities($_POST['recovery_question']);
      if($recovery_answer==""){
        $update= "update users set fname='$fname',lname='$lname',email='$email',about='$about',m_status='$mstatus',phone_number='$phone_number',hometown='$country',gender='$gender',privacy='$privacy',birthdate='$birthday',recovery_question='$recovery_question' where uid='$uid'";
        $run = mysqli_query($con,$update);
      }else{
        $update= "update users set fname='$fname',lname='$lname',email='$email',about='$about',m_status='$mstatus',phone_number='$phone_number',hometown='$country',gender='$gender',privacy='$privacy',birthdate='$birthday',recovery_question='$recovery_question',recovery_answer='$recovery_answer' where uid='$uid'";
        $run = mysqli_query($con,$update);
      }
      $update_post= "update posts set posterName='$fname $lname' where posterId='$uid'";
      $run_post = mysqli_query($con,$update_post);
      if($run_post){
      if($run){
        echo"<script>alert('Your Profile Updated')</script>";
        echo"<script>window.open('/Social_Network/user_profile.php?uid=$uid','_self')</script>";
      }
      else{
        echo"<script>alert('Error while uploading the information!')</script>";
        echo"<script>window.open('edit_profile.php?uid=$uid','_self')</script>";
      }
    }
  }
 ?>
