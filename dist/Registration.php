<?php
  
  $servername = "localhost";
  $userName= "root";
  $password = "";
  $database = "dms";

  // Create Connection
  $con = new mysqli($servername, $userName, $password, $database);

  

  
  $maxres ="empty";

  $name ="";
  $sname = "";
  $gender ="";
  $age = "";
  $phone = "";
  $address = "";
  $note = "";
  $treatmentName ="....";
  $total ="0";
  $recevid = "0";

  $errormessage ="";
  $success="";
  
 
  $sqlId = "SELECT MAX(P_ID) AS maxid FROM tbl_patient;";
  $max = $con->query($sqlId);



  // Check if a value has been clicked
  if (isset($_GET['value'])) {
    $treatmentName = $_GET['value'];
    if($treatmentName == 'CBC'){
      $clicked_value = 1 ;
      $total = 1000 ;
    }
    if($treatmentName == 'BBD'){
      $clicked_value = 2 ;
      $total = 1500;
    }
    if($treatmentName == 'ADS'){
      $clicked_value = 3 ;
      $total = 500 ; 
    }
    if($treatmentName == 'CLN'){
      $clicked_value = 4 ;
      $total = 600;
    }
  }

  
  
  if ($max->num_rows > 0) {
    // Get the maximum ID from the result set
    $row = $max->fetch_assoc();
    $maxres = $row["maxid"];
    $maxres = $maxres+1;
    } else {
        echo "Max ID not Selected";
    }

  // Using POST server request method 
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST["name"];
    $sname = $_POST["sname"];
    $gender = $_POST["gender"];
    $age = $_POST["age"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $note = $_POST["note"];
    $recevid = $_POST["recevid"];

  

      do {
        if(empty($name) || empty($phone) || empty($treatmentName) ){
          $errormessage="All the field are Required";
          break;
        }

        // INSERT INTO Patient Table 
        $sql = "INSERT INTO `tbl_patient`( `P_Name`, `P_SName`,  `P_Gender`, `P_Age`, `P_Phone`, `P_Address`,  `P_Note`, `U_ID`, `PT_ID`) VALUES
        ('$name', '$sname', '$gender','$age','$phone','$address','$note', 1 , '$clicked_value' );";
        $res = $con->query($sql);

        $newsql = "INSERT INTO `tbl_patient_balance`(`PB_Total`, `PB_Receive`, `U_ID`, `P_ID`) 
        VALUES ('$total','$recevid','1','$maxres');";
        $res2 = $con->query($newsql);

        if(!$res){
          $errormessage = "invalid Query: ". $con->error;
          break;
        }
          $name ="";
          $sname ="";
          $gender ="";
          $age = "";
          $phone = "";
          $address = "";
          $note = "";
          $treatmentName ="";
          $total ="";
          $recevid = "";

          $success = "patient Registed";

          header("location: /DMS/dist/index.php");

      } while (false);

    }

?>


<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>DMS</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="NewStyle.css">

  <!-- Boots strap-->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="app-container">
  <div class="sidebar">
    <div class="sidebar-header">
      <div class="app-icon">
        <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M507.606 371.054a187.217 187.217 0 00-23.051-19.606c-17.316 19.999-37.648 36.808-60.572 50.041-35.508 20.505-75.893 31.452-116.875 31.711 21.762 8.776 45.224 13.38 69.396 13.38 49.524 0 96.084-19.286 131.103-54.305a15 15 0 004.394-10.606 15.028 15.028 0 00-4.395-10.615zM27.445 351.448a187.392 187.392 0 00-23.051 19.606C1.581 373.868 0 377.691 0 381.669s1.581 7.793 4.394 10.606c35.019 35.019 81.579 54.305 131.103 54.305 24.172 0 47.634-4.604 69.396-13.38-40.985-.259-81.367-11.206-116.879-31.713-22.922-13.231-43.254-30.04-60.569-50.039zM103.015 375.508c24.937 14.4 53.928 24.056 84.837 26.854-53.409-29.561-82.274-70.602-95.861-94.135-14.942-25.878-25.041-53.917-30.063-83.421-14.921.64-29.775 2.868-44.227 6.709-6.6 1.576-11.507 7.517-11.507 14.599 0 1.312.172 2.618.512 3.885 15.32 57.142 52.726 100.35 96.309 125.509zM324.148 402.362c30.908-2.799 59.9-12.454 84.837-26.854 43.583-25.159 80.989-68.367 96.31-125.508.34-1.267.512-2.573.512-3.885 0-7.082-4.907-13.023-11.507-14.599-14.452-3.841-29.306-6.07-44.227-6.709-5.022 29.504-15.121 57.543-30.063 83.421-13.588 23.533-42.419 64.554-95.862 94.134zM187.301 366.948c-15.157-24.483-38.696-71.48-38.696-135.903 0-32.646 6.043-64.401 17.945-94.529-16.394-9.351-33.972-16.623-52.273-21.525-8.004-2.142-16.225 2.604-18.37 10.605-16.372 61.078-4.825 121.063 22.064 167.631 16.325 28.275 39.769 54.111 69.33 73.721zM324.684 366.957c29.568-19.611 53.017-45.451 69.344-73.73 26.889-46.569 38.436-106.553 22.064-167.631-2.145-8.001-10.366-12.748-18.37-10.605-18.304 4.902-35.883 12.176-52.279 21.529 11.9 30.126 17.943 61.88 17.943 94.525.001 64.478-23.58 111.488-38.702 135.912zM266.606 69.813c-2.813-2.813-6.637-4.394-10.615-4.394a15 15 0 00-10.606 4.394c-39.289 39.289-66.78 96.005-66.78 161.231 0 65.256 27.522 121.974 66.78 161.231 2.813 2.813 6.637 4.394 10.615 4.394s7.793-1.581 10.606-4.394c39.248-39.247 66.78-95.96 66.78-161.231.001-65.256-27.511-121.964-66.78-161.231z"/></svg>
      </div>
    </div>

    <!-- Left Links -->
    <ul class="sidebar-list">
      <li class="sidebar-list-item">
        <a href="Dashboard.php">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="sidebar-list-item active">
        <a href="index.php">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
          <span>Patients </span>
        </a>
      </li>
      <li class="sidebar-list-item">
        <a href="#">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>
          <span>Report</span>
        </a>
      </li>
      <li class="sidebar-list-item">
        <a href="#">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
          <span>Expances</span>
        </a>
      </li>
      <li class="sidebar-list-item">
        <a href="#">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
          <span>Add User</span>
        </a>
      </li>
    </ul>



    <!--User Profile -->
    <div class="account-info">

      <div class="account-info-name">Monica G.</div>
      <button class="account-info-more">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
      </button>
    </div>


  </div>
  <div class="app-content">

    <!-- Header Product with add product-->
    <div class="app-content-header">
      <h1 class="app-content-headerText">Patient Registration</h1>
      <button class="mode-switch" title="Switch Theme">
          <defs></defs>
          <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
        </svg>
      </button>
      <a href="Dashboard.php"><button class="app-content-headerButton">Back</button></a>
    </div>
    <section class="Registarion">
      <div class="container">
        <br><br>
      <form method="post">
        
        <div class="row">
          <div class="col-md-6">

            <div class="row">
              <div class="col-md-4">
                <h4>Name </h4>
              </div>
              <div class="col-md-8">
                <input type="text" name="name" value="<?php echo $name?>">
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <h4>S/Name </h4>
              </div>
              <div class="col-md-8">
                <input type="text" name="sname" value="<?php echo $sname?>">
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <h4>Gender </h4>
              </div>
              <div class="col-md-8">
                <input type="text" name = "gender" value="<?php echo $gender; ?>">
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <h4>Age </h4>
              </div>
              <div class="col-md-8">
                <input type="text" name ="age" value="<?php echo $age?>">
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <h4>Phone </h4>
              </div>
              <div class="col-md-8">
                <input type="text" name="phone" value="<?php echo $phone?>">
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <h4>Address </h4>
              </div>
              <div class="col-md-8">
                <input type="text" name="address" value="<?php echo $address?>">
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <h4>Treatment </h4>
              </div>
              <div class="col-md-8">
                <h4> <?php echo '<p> ' . $treatmentName . ' </p>'?> </h4>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <h4>Note</h4>
              </div>
              <div class="col-md-8">
                <input type="text" name = "note" value="<?php echo $note?>">
              </div>
            </div>

          </div>
          <div class="col-md-6">
            <h3>Treatments</h3>
            <ul id="UI">
              <?php
                // Example data
                $data = array('CBC', 'BBD', 'ADS', 'CLN');

                // Loop through the data and create a list item for each value
                foreach ($data as $value) {
                  echo '<li Class="list"><a href="?value=' . $value . '">' . $value . '</a></li>';
                }
              ?>
              
            </ul>

          
          </div>

        </div>
     
        <div class="row">
          <div class="col-md-7">
            <div class="row">
              <?php 
              if(!empty($errormessage)){
                echo"
                <h2>$errormessage </h2>
                ";
              }
              ?>
            </div>
            <div class="row">
               <?php 
              if(!empty($success)){
                echo"
                <h2> $success </h2>
              </div>
                ";
              }
              ?>
            </div>
          </div>
          <div class="col-md-5">
            <div class="row"><?php echo '<h5> Total: '.$total. '</h5>' ?></div>
            <div class="row"><h5> Recived:   </h5> <input style="margin-left: 15px; padding: 0; " type="text" name="recevid"> </div>

            <div class="row">
              <div class="col-md-6">
                <a href="index.php"><button class="app-content-headerButton" type="button" id="btn3" role="button">Cancel</button></a>
              </div>
              <div class="col-md-6">
                <button class="app-content-headerButton" type="submit" id="btn2">Submit</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      </form>
    </section>


    
  </div>
</div>
<!-- partial -->
  <script  src="./script.js"></script>

</body>
</html>
