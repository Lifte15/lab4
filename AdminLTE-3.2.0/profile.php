<?php
session_start();

include "db_conn.php";
if (
  isset($_SESSION['user_id'])
){
  // Redirect to login page if user is not logged in
if (!isset($_SESSION["email"])) {
  header("Location: login-v2.php");
  exit();
}

// Logout functionality
if (isset($_POST['logout'])) {
  session_unset(); // Unset all session variables
  session_destroy(); // Destroy the session
  header("Location: login-v2.php");
  exit();
} 

  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | User Profile</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-black navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index2.php" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index2.php" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
        <div class="image">
            <img src="upload/<?=$_SESSION['pp']?>" class="rounded-circle elevation-2 img-fluid" alt="User Image" style="width: 45px; height: 45px;">
        </div>
        <div class="info align-self-center">
            <a href="profile.php" class="d-block"><?php echo $_SESSION['username']; ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                <img src="upload/<?=$_SESSION['pp']?>" 
                  class="rounded-circle elevation-2 img-fluid" 
                  alt="User Profile Picture" 
                  style="width: 145px; height: 145px;">
                </div>

                <h3 class="profile-username text-center"><?php echo $_SESSION['username']; ?></h3>

                <p class="text-muted text-center"><?php echo $_SESSION['email']; ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Given Name</b> <a class="float-right"><?php echo $_SESSION['first_name']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Middle Name</b> <a class="float-right"><?php echo $_SESSION['middle_name']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Last Name</b> <a class="float-right"><?php echo $_SESSION['lastname']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Status</b> <a class="float-right"><?php echo $_SESSION['status']; ?></a>
                  </li>
                </ul>
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <button type="submit" name="logout" class="btn btn-primary btn-block">Shift na(logout)</button>
                  </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-phone-alt mr-1"></i> Phone Number</strong>

                <p class="text-muted">
                <?php echo empty($_SESSION['phone_number']) ? '' : "0" . $_SESSION['phone_number']; ?>
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong><br>

                <p class="text-muted">
                  <?php echo empty($_SESSION['barangay']) ? '' : "Brgy. " . $_SESSION['barangay'] . ","; ?>
                  <?php echo empty($_SESSION['city']) ? '' : $_SESSION['city'] . " City"; ?><br>
                  <?php echo empty($_SESSION['province']) ? '' : $_SESSION['province'] . ","; ?>
                  <?php echo empty($_SESSION['region']) ? '' : "Region " . $_SESSION['region']; ?><br>
                  <?php echo empty($_SESSION['zip_code']) ? '' : $_SESSION['zip_code']; ?></p>

                <hr>

                <strong><i class="fas fa-mars mr-1"></i> Gender</strong>

                <p class="text-muted">
                  <?php echo empty($_SESSION['gender']) ? '' : $_SESSION['gender']; ?></p>
                </p>

                <hr>

                <strong><i class="fas fa-birthday-cake mr-1"></i> Birthday</strong>

                <p class="text-muted">
                <?php echo ($_SESSION['birthday'] == '0000-00-00') ? '' : date('F d, Y', strtotime($_SESSION['birthday'])); ?>
                </p>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
                  <li class="nav-item"><a class="nav-link" href="#user" data-toggle="tab">User</a></li>
                  <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">Profile</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane" id="activity">
                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="dist/img/user1-128x128.jpg" alt="user image">
                        <span class="username">
                          <a href="#">Jonathan Burke Jr.</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description">Shared publicly - 7:30 PM today</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        Lorem ipsum represents a long-held tradition for designers,
                        typographers and the like. Some people hate it and argue for
                        its demise, but others ignore the hate as they create awesome
                        tools to help create filler text for everyone from bacon lovers
                        to Charlie Sheen fans.
                      </p>

                      <p>
                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (5)
                          </a>
                        </span>
                      </p>

                      <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                    </div>
                    <!-- /.post -->

                    <!-- Post -->
                    <div class="post clearfix">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="dist/img/user7-128x128.jpg" alt="User Image">
                        <span class="username">
                          <a href="#">Sarah Ross</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description">Sent you a message - 3 days ago</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        Lorem ipsum represents a long-held tradition for designers,
                        typographers and the like. Some people hate it and argue for
                        its demise, but others ignore the hate as they create awesome
                        tools to help create filler text for everyone from bacon lovers
                        to Charlie Sheen fans.
                      </p>

                      <form class="form-horizontal">
                        <div class="input-group input-group-sm mb-0">
                          <input class="form-control form-control-sm" placeholder="Response">
                          <div class="input-group-append">
                            <button type="submit" class="btn btn-danger">Send</button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <!-- /.post -->

                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="dist/img/user6-128x128.jpg" alt="User Image">
                        <span class="username">
                          <a href="#">Adam Jones</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description">Posted 5 photos - 5 days ago</span>
                      </div>
                      <!-- /.user-block -->
                      <div class="row mb-3">
                        <div class="col-sm-6">
                          <img class="img-fluid" src="dist/img/photo1.png" alt="Photo">
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-6">
                              <img class="img-fluid mb-3" src="dist/img/photo2.png" alt="Photo">
                              <img class="img-fluid" src="dist/img/photo3.jpg" alt="Photo">
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                              <img class="img-fluid mb-3" src="dist/img/photo4.jpg" alt="Photo">
                              <img class="img-fluid" src="dist/img/photo1.png" alt="Photo">
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      <p>
                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (5)
                          </a>
                        </span>
                      </p>

                      <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                    </div>
                    <!-- /.post -->
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="user">
                  
                  </div>
                  <!-- /.tab-pane -->

                  <div class="active tab-pane" id="profile">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-title">Profile Update</h5>
                    </div>
                    <div class="card-body">
                      <form action="user_update_index.php" method="post">
                      <?php if (isset($_GET['erroruu'])) { ?>
                          <!-- Paragraph with error styling and text from GET parameter -->
                          <div class="text-center">
                            <p class="error text-danger"><?php echo $_GET['erroruu']; ?></p>
                          </div>
                        <?php } ?>
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10" style="display: flex; gap: 10px;">
                              <input type="text" class="form-control" name="uname" placeholder="Username*">
                            </div>
                          </div>
                          <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Full name</label>
                            <div class="col-sm-10" style="display: flex; gap: 10px;">
                              <input type="text" class="form-control" class="placeholder" style="width: 33%;" name="fname" placeholder=" First*" pattern="[A-Za-z\s]+" title="don't input a number and special character">                                
                              <input type="text" class="form-control" class="placeholder" style="width: 33%;" name="mname" placeholder=" Middle" pattern="[A-Za-z\s]+" title="don't input a number and special character">
                              <input type="text" class="form-control" class="placeholder" style="width: 33%;" name="lname" placeholder=" Last*" pattern="[A-Za-z\s]+" title="don't input a number and special character">
                            </div>
                          </div>
                            <div class="form-group row">
                              <label class="col-sm-2 col-form-label">Relationship Status</label>
                              <div class="col-sm-10" style="display: flex; gap: 10px;">
                                  <select class="form-control" name="status">
                                      <option value="" disabled selected class="text-secondary">Select status*</option>
                                      <option value="Single">Single</option>
                                      <option value="In a relationship">In a relationship</option>
                                      <option value="Engaged">Engaged</option>
                                      <option value="Married">Married</option>
                                      <option value="Divorced">Divorced</option>
                                      <option value="Widowed">Widowed</option>
                                      <option value="It's complicated">It's complicated</option>
                                  </select>
                              </div>
                            </div>
                            <div class="row">
                              <div class="offset-sm-2 col-6">
                                <div class="checkbox">
                                  <label>
                                    <input name="terms" type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                  </label>
                                </div>
                              </div>
                              <div class="col-4 text-right pr-2">
                                  <button type="submit" class="btn btn-primary">Update</button>
                                </form>  
                              </div>
                            </div>
                        </form>
                      </div>  
                    </div> 
                    <div class="card">
                      <div class="card-header">
                          <h5 class="card-title">Profile Update 2</h5>
                      </div>
                      <div class="card-body">
                        <form action="profile_index.php" method="post">
                          <?php if (isset($_GET['errorpi'])) { ?>
                            <!-- Paragraph with error styling and text from GET parameter -->
                            <div class="text-center">
                              <p class="error text-danger"><?php echo $_GET['errorpi']; ?></p>
                            </div>
                          <?php } ?>
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Phone Number</label>
                            <div class="col-sm-10" style="display: flex; gap: 10px;">
                              <input type="text" class="form-control" name="p_num" placeholder="09876543210*">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Gender</label>
                            <div class="col-sm-10" style="display: flex; gap: 10px;">
                                <select class="form-control" name="gender">
                                    <option value="" disabled selected class="text-secondary">Select gender*</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Prefer not to say">Prefer not to say</option>
                                </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Birthday</label>
                            <div class="col-sm-10" style="display: flex; gap: 10px;">
                              <input type="date" class="form-control" name="birthday">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Address</label>
                              <div class="col-sm-10" style="display: flex; gap: 10px;">
                                <input type="text" class="form-control" class="placeholder" style="width: 50%;" name="province" placeholder=" Province*">                                
                                <input type="text" class="form-control" class="placeholder" style="width: 50%;" name="city" placeholder=" City*">
                            </div><br>
                            <br><label class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10" style="display: flex; gap: 10px;">
                                <input type="text" class="form-control" class="placeholder" style="width: 34%;" name="brgy" placeholder=" Barangay*">                                
                                <input type="text" class="form-control" class="placeholder" style="width: 33%;" name="region" placeholder=" Region*">
                                <input type="text" class="form-control" class="placeholder" style="width: 33%;" name="zip_code" placeholder=" Zip code*">
                            </div>
                          </div>
                          <div class="row">
                            <div class="offset-sm-2 col-6">
                              <div class="checkbox">
                                <label>
                                  <input name="terms" type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                </label>
                              </div>
                            </div>
                            <div class="col-4 text-right pr-2">
                              <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                        </form>  
                      </div>
                    </div>
                      <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title">Profile Picture Update</h5>
                        </div>
                        <div class="card-body">
                        <?php if (isset($_GET['errorpp'])) { ?>
                          <!-- Paragraph with error styling and text from GET parameter -->
                          <div class="text-center">
                            <p class="error text-danger"><?php echo $_GET['errorpp']; ?></p>
                          </div>
                        <?php } ?>
                            <form action="pp_update_index.php" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Profile Picture</label>
                                    <div class="col-sm-10" style="display: flex; gap: 10px;">
                                      <input type="file" class="custom-file-input" aria-describedby="inputGroupFileAddon01" name="pp" onchange="updateLabel(this)">
                                      <label class="custom-file-label form-control" for="inputGroupFile01">Choose a Profile Picture</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-2 col-form-label">Current Password</label>
                                  <div class="col-sm-10" style="display: flex; gap: 10px;">
                                    <input type="password" class="form-control" name="password" placeholder="Your Current Password*">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="offset-sm-2 col-6">
                                    <div class="checkbox">
                                      <label>
                                        <input name="terms" type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-4 text-right pr-2">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                  </div>
                                </div>
                            </form>
                        </div>
                      </div> 
                    <div class="card">
                      <div class="card-header">
                          <h5 class="card-title">Change Password</h5>
                      </div>
                      <div class="card-body">
                        <form action="change_password_index.php" method="post">
                        <?php if (isset($_GET['errorpa'])) { ?>
                          <!-- Paragraph with error styling and text from GET parameter -->
                          <div class="text-center">
                            <p class="error text-danger"><?php echo $_GET['errorpa']; ?></p>
                          </div>
                        <?php } ?>
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Current Password</label>
                            <div class="col-sm-10" style="display: flex; gap: 10px;">
                              <input type="password" class="form-control" name="cupass" placeholder="Your Current Password*">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label">New Password</label>
                            <div class="col-sm-10" style="display: flex; gap: 10px;">
                              <input type="password" class="form-control" name="npass" placeholder="Your New Password*">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Confirm Password</label>
                            <div class="col-sm-10" style="display: flex; gap: 10px;">
                              <input type="password" class="form-control" name="copass" placeholder="Confirm Password*">
                            </div>
                          </div>
                          <div class="row">
                            <div class="offset-sm-2 col-6">
                              <div class="checkbox">
                                <label>
                                  <input name="terms" type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                </label>
                              </div>
                            </div>
                            <div class="col-4 text-right pr-2">
                              <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                        </form>  
                      </div>
                    </div>
                    <?php
                    $email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
                    ?>
                    <div class="card">
                      <div class="card-header">
                          <h5 class="card-title">Change Email Address</h5>
                      </div>
                      <div class="card-body">
                        <form action="change_email_index.php" method="post">
                        <?php if (isset($_GET['errorem'])) { ?>
                          <!-- Paragraph with error styling and text from GET parameter -->
                          <div class="text-center">
                            <p class="error text-danger"><?php echo $_GET['errorem']; ?></p>
                          </div>
                        <?php } ?>
                        <?php if (isset($_GET['successem'])) { ?>
                              <!-- Paragraph with error styling and text from GET parameter -->
                              <p class="success text-success text-center"><?php echo $_GET['successem']; ?></p>
                        <?php } ?>
                        <div class="form-group row">
                              <label class="col-sm-2 col-form-label">New Email Address</label>
                              <div class="col-sm-10" style="display: flex; gap: 10px;">
                                  <input type="email" class="form-control" name="nemail" placeholder="Email Address*" value="<?php echo $email; ?>">
                                  <!-- Adjust the column size to make the button wider -->
                                  <div class="col-sm-4"> <!-- Adjust the size as needed -->
                                      <button type="submit" class="btn btn-success btn-block">Send OTP</button>
                                  </div>
                              </div>
                          </div>
                          </form>
                          <form action="change_email_otp_index.php" method="post">
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label">OTP</label>
                            <div class="col-sm-10" style="display: flex; gap: 10px;">
                              <input type="text" class="form-control" name="nuser_otp" placeholder="Verification Code*">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Current Password</label>
                            <div class="col-sm-10" style="display: flex; gap: 10px;">
                              <input type="password" class="form-control" name="password" placeholder="Current Password*">
                            </div>
                          </div>
                          <div class="row">
                            <div class="offset-sm-2 col-6">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                </label>
                              </div>
                            </div>
                            <div class="col-4 text-right pr-2">
                              <button type="submit" class="btn btn-primary">Verify</button>
                            </div>
                        </div>
                        </form>  
                      </div>
                    </div>
                  </div>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
    function updateLabel(input) {
        const label = input.nextElementSibling;
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            label.textContent = fileName;
        } else {
            label.textContent = 'Choose file';
        }
    }
  </script>
</body>
</html>
<?php
} else {
  header("Location: index2.php");
  exit();
}
?>