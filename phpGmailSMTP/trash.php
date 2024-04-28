<?php 
require_once '../controllerUserData.php';
$email = $_SESSION['email'];
$password = $_SESSION['password'];
if($email != false && $password != false){
    $sql = "SELECT * FROM usertable WHERE email = '$email'";
    $run_Sql = mysqli_query($con, $sql);
    if($run_Sql){
        $fetch_info = mysqli_fetch_assoc($run_Sql);
        $status = $fetch_info['status'];
        $code = $fetch_info['code'];
        if($status == "verified"){
            if($code != 0){
                header('Location: ../reset-code.php');
                exit(); // Add exit to prevent further execution
            }
        }else{
            header('Location: ../user-otp.php');
            exit(); // Add exit to prevent further execution
        }
    }
}else{
    header('Location: ../login-user.php');
    exit(); // Add exit to prevent further execution
}
?>

<?php
require_once "../controllerUserData.php";
error_reporting(0);
include('database.inc');
$msg ="";

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($con,$_POST['name']);
    $mobile = mysqli_real_escape_string($con,$_POST['mobile']);
    $checkbox1=$_POST['wastetype'];  
    $chk="";  
    foreach($checkbox1 as $chk1)  
    {  
        $chk .= $chk1.",";  
    } 

    $email = mysqli_real_escape_string($con,$_POST['email']);
    $status = mysqli_real_escape_string($con,$_POST['status']);
    $location = mysqli_real_escape_string($con,$_POST['location']);    
    $locationdescription = mysqli_real_escape_string($con,$_POST['locationdescription']);
    $date = $_POST['date'];
    
    $file = $_FILES['file']['name'];
    $target_dir = "upload/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
  
    // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
    // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif","tif", "tiff");
  
    // Check extension
    if( in_array($imageFileType,$extensions_arr) ){
        // Upload file
        move_uploaded_file($image = $_FILES['file']['tmp_name'],$target_dir.$file);
    }

    $sql = "insert into garbageinfo(name,mobile,email,wastetype,location,locationdescription,file,date,status)values('$name','$mobile','$email','$chk','$location','$locationdescription','$file','$date','$status')";
        
    if(mysqli_query($con,$sql)){
        $msg = '<div class = "alert alert-success"><span class="fa fa-check"> "Complaint Registered Successfully!"</span><a href="http://localhost/EmailVerification/adminlogin/welcome.php"> view Complaint </a></div>';
        header('Location: confirmation_page.php'); // Redirect to connection.php after registering the complaint
        exit(); // Add exit to prevent further execution
    } else {
        $msg= '<div class = "alert alert-warning"><span class="fa fa-times"> Failed to Register !"</span></div>';
    }

    $html = "<table><tr><td>FirstName: $name</td></tr><tr><td>Mobile: $mobile</td></tr><tr><td>Email: $email</td></tr><tr><td>Type Of Waste: $chk</td></tr><tr><td>Area: $location</td></tr><tr><td>Area description: $locationdescription</td></tr><tr><td>Images: $file  </td></tr><tr><td>Date: $date</td></tr></table>";
    include('PHPMailerAutoload.php');
    require_once('PHPMailerAutoload.php');
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure='tls';
    $mail->Host='smtp.gmail.com';
    $mail->Port= '587';
    $mail->isHTML(true);
    $mail->Username='janak.bista@sagarmatha.edu.np';
    $mail->Password='your email passsword';
    $mail->SetFrom('no-reply@howcode.org');     
    $mail->Subject='Hello sir!';
    $mail->Body=$html;     
    $mail->AddAddress('francis@howcode.org');
    $mail->SMTPOptions=array('ssl'=>array(
        'verify_peer'=>false,
        'verify_peer_name'=>false,
        'allow_self_signed'=>false
    ));
    $mail->send();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Complaint</title>
</head>
<body>
<div>
    <a href="http://localhost/EmailVerification/index.html"  class="fa fa-home"> Home </a>
</div>
<?php 
$error ='';   
?>
<form method="post" action="trash.php" enctype="multipart/form-data">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="contact-info">
                    <img src="images.jfif" alt="image"/>
                    <h2>Register Your Complaint</h2>
                    <h4>Nature Nexus would love to hear from you !</h4>
                </div>
            </div>
            <div class="col-md-9">
                <div class="contact-form">
                    <div class="form-group">
                        <div id="error"></div>
                        <span style="color:red"><?php echo "<b>$msg</b>"?></span>
                        <label class="control-label col-sm-2" for="fname"> Name:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" placeholder="Enter Your Name" name="name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="lname">Mobile:</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="mobile" placeholder="Enter Your Mobile Number" name="mobile" required min="6000000000" max="100000000000">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="email" placeholder="Enter Your email" name="email" value="<?php echo $_SESSION['email'];?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="option">Category:</label>
                        <div class="col-sm-10">
                            <input type="checkbox" name="wastetype[]" value="organic"> Organic
                            <input type="checkbox" name="wastetype[]" value="inorganic"> Inorganic
                            <input type="checkbox" name="wastetype[]" value="Household"> Household
                            <input type="checkbox" name="wastetype[]" value="mixed" id="mycheck" checked> All
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="lname">Location:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="location" name="location" required>
                                <option class="form-control" >Ktm</option>
                                <option class="form-control" >Bktpur</option>
                                <option class="form-control" >lalitpur</option>
                                <option class="form-control" >sanepa</option>
                                <option class="form-control" >Kalanki</option>
                            
                                
                                <option class="form-control">Agra</option>
<option class="form-control">Ahmedabad</option>
<option class="form-control">Ajmer</option>
<option class="form-control">Aligarh</option>
<option class="form-control">Allahabad</option>
<option class="form-control">Amravati</option>
<option class="form-control">Amritsar</option>
<option class="form-control">Asansol</option>
<option class="form-control">Aurangabad</option>
<option class="form-control">Bangalore</option>
<option class="form-control">Barasat</option>
<option class="form-control">Bardhaman</option>
<option class="form-control">Bareilly</option>
<option class="form-control">Belgaum</option>
<option class="form-control">Bhagalpur</option>
<option class="form-control">Bhilai</option>
<option class="form-control">Bhilwara</option>
<option class="form-control">Bhiwandi</option>
<option class="form-control">Bhopal</option>
<option class="form-control">Bhubaneswar</option>
<option class="form-control">Bhuj</option>
<option class="form-control">Bikaner</option>
<option class="form-control">Bilaspur</option>
<option class="form-control">Bokaro Steel City</option>
<option class="form-control">Brahmapur</option>
<option class="form-control">Burla</option>
<option class="form-control">Chandigarh</option>
<option class="form-control">Chennai</option>
<option class="form-control">Chittoor</option>
<option class="form-control">Coimbatore</option>
<option class="form-control">Cuttack</option>
<option class="form-control">Darbhanga</option>
<option class="form-control">Davanagere</option>
<option class="form-control">Dehradun</option>
<option class="form-control">Delhi</option>
<option class="form-control">Dewas</option>
<option class="form-control">Dhanbad</option>
<option class="form-control">Dharamsala</option>
<option class="form-control">Dharwad</option>
<option class="form-control">Durg</option>
<option class="form-control">Durgapur</option>
<option class="form-control">Eluru</option>
<option class="form-control">Erode</option>
<option class="form-control">Etawah</option>
<option class="form-control">Faizabad</option>
<option class="form-control">Faridabad</option>
<option class="form-control">Fatehpur</option>
<option class="form-control">Firozabad</option>
<option class="form-control">Gandhinagar</option>
<option class="form-control">Gangtok</option>
<option class="form-control">Gaya</option>
<option class="form-control">Ghaziabad</option>
<option class="form-control">Gopalpur</option>
<option class="form-control">Gorakhpur</option>
<option class="form-control">Gudivada</option>
<option class="form-control">Gulbarga</option>
<option class="form-control">Guntur</option>
<option class="form-control">Gurgaon</option>
<option class="form-control">Guwahati</option>
<option class="form-control">Gwalior</option>
<option class="form-control">Haldia</option>
<option class="form-control">Hapur</option>
<option class="form-control">Hardoi</option>
<option class="form-control">Haridwar</option>
<option class="form-control">Hosapete</option>
<option class="form-control">Hubballi-Dharwad</option>
<option class="form-control">Hyderabad</option>
<option class="form-control">Ichalkaranji</option>
<option class="form-control">Imphal</option>
<option class="form-control">Indore</option>
<option class="form-control">Jabalpur</option>
<option class="form-control">Jaipur</option>
<option class="form-control">Jalandhar</option>
<option class="form-control">Jammu</option>
<option class="form-control">Jamnagar</option>
<option class="form-control">Jamshedpur</option>
<option class="form-control">Jhansi</option>
<option class="form-control">Jodhpur</option>
<option class="form-control">Junagadh</option>
<option class="form-control">Kakinada</option>
<option class="form-control">Kalyan-Dombivali</option>
<option class="form-control">Kamarhati</option>
<option class="form-control">Kanpur</option>
<option class="form-control">Karnal</option>
<option class="form-control">Katihar</option>
<option class="form-control">Khammam</option>
<option class="form-control">Kochi</option>
<option class="form-control">Kolhapur</option>
<option class="form-control">Kolkata</option>
<option class="form-control">Kollam</option>
<option class="form-control">Korba</option>
<option class="form-control">Kota</option>
<option class="form-control">Kozhikode</option>
<option class="form-control">Kulti</option>
<option class="form-control">Kurnool</option>
<option class="form-control">Latur</option>
<option class="form-control">Loni</option>
<option class="form-control">Lucknow</option>
<option class="form-control">Ludhiana</option>
<option class="form-control">Madurai</option>
<option class="form-control">Maheshtala</option>
<option class="form-control">Malegaon</option>
<option class="form-control">Mangalore</option>
<option class="form-control">Mango</option>
<option class="form-control">Mathura</option>
<option class="form-control">Mau</option>
<option class="form-control">Meerut</option>
<option class="form-control">Mira-Bhayandar</option>
<option class="form-control">Mirzapur</option>
<option class="form-control">Moradabad</option>
<option class="form-control">Mumbai</option>
<option class="form-control">Muzaffarnagar</option>
<option class="form-control">Muzaffarpur</option>
<option class="form-control">Mysore</option>
<option class="form-control">Nagpur</option>
<option class="form-control">Nanded</option>
<option class="form-control">Nashik</option>
<option class="form-control">Navi Mumbai</option>
<option class="form-control">Nellore</option>
<option class="form-control">New Delhi</option>
<option class="form-control">Nizamabad</option>
<option class="form-control">Noida</option>
<option class="form-control">North Dumdum</option>
<option class="form-control">Ozhukarai</option>
<option class="form-control">Pali</option>
<option class="form-control">Panihati</option>
<option class="form-control">Panipat</option>
<option class="form-control">Panvel</option>
<option class="form-control">Parbhani</option>
<option class="form-control">Patiala</option>
<option class="form-control">Patna</option>
<option class="form-control">Pimpri-Chinchwad</option>
<option class="form-control">Port Blair</option>
<option class="form-control">Puducherry</option>
<option class="form-control">Pune</option>
<option class="form-control">Purnia</option>
<option class="form-control">Raebareli</option>
<option class="form-control">Raichur</option>
<option class="form-control">Raipur</option>
<option class="form-control">Rajahmundry</option>
<option class="form-control">Rajkot</option>
<option class="form-control">Rajpur Sonarpur</option>
<option class="form-control">Rampur</option>
<option class="form-control">Ranchi</option>
<option class="form-control">Ratlam</option>
<option class="form-control">Raurkela</option>
<option class="form-control">Rewa</option>
<option class="form-control">Rohtak</option>
<option class="form-control">Rourkela</option>
<option class="form-control">Sagar</option>
<option class="form-control">Saharanpur</option>
<option class="form-control">Salem</option>
<option class="form-control">Sambalpur</option>
<option class="form-control">Sangli-Miraj & Kupwad</option>
<option class="form-control">Satna</option>
<option class="form-control">Serampore</option>
<option class="form-control">Shahjahanpur</option>
<option class="form-control">Shimla</option>
<option class="form-control">Shivpuri</option>
<option class="form-control">Sikar</option>
<option class="form-control">Silchar</option>
<option class="form-control">Siliguri</option>
<option class="form-control">Singrauli</option>
<option class="form-control">Sirsa</option>
<option class="form-control">Solapur</option>
<option class="form-control">Sonipat</option>
<option class="form-control">South Dumdum</option>
<option class="form-control">Sri Ganganagar</option>
<option class="form-control">Srinagar</option>
<option class="form-control">Surat</option>
<option class="form-control">Surendranagar</option>
<option class="form-control">Tambaram</option>
<option class="form-control">Thane</option>
<option class="form-control">Thiruvananthapuram</option>
<option class="form-control">Thrissur</option>
<option class="form-control">Tiruchirappalli</option>
<option class="form-control">Tirunelveli</option>
<option class="form-control">Tirupati</option>
<option class="form-control">Tirupur</option>
<option class="form-control">Tiruvottiyur</option>
<option class="form-control">Tumkur</option>
<option class="form-control">Udaipur</option>
<option class="form-control">Ujjain</option>
<option class="form-control">Ulhasnagar</option>
<option class="form-control">Uluberia</option>
<option class="form-control">Unnao</option>
<option class="form-control">Vadodara</option>
<option class="form-control">Varanasi</option>
<option class="form-control">Vasai-Virar</option>
<option class="form-control">Vijayawada</option>
<option class="form-control">Visakhapatnam</option>
<option class="form-control">Warangal</option>
<option class="form-control">Yamunanagar</option>
<option class="form-control">Yavatmal</option>
<option class="form-control">Yamunanagar</option>
<option class="form-control">Yavatmal</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="5" id="locationdescription" placeholder="Enter Location details..." name="locationdescription" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="lname">Pictures:</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="file" name="file" required accept="image/*" capture="camera">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type='hidden' class="form-control" id="date" name="status" value="Pending">
                            <input type="hidden" class="form-control" id="date" name="date" value="<?php $timezone = date_default_timezone_set("Asia/Kathmandu"); echo date("g:ia ,\n l jS F Y");?>">
                            <button type="submit" class="btn btn-default" name="submit" >Register</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</body>
</html>
