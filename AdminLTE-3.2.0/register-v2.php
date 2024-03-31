<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration Page (v2)</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
  <?php
    $euname = isset($_GET['euname']) ? htmlspecialchars($_GET['euname']) : '';
    $efname = isset($_GET['efname']) ? htmlspecialchars($_GET['efname']) : '';
    $emname = isset($_GET['emname']) ? htmlspecialchars($_GET['emname']) : '';
    $elname = isset($_GET['elname']) ? htmlspecialchars($_GET['elname']) : '';
    $eemail = isset($_GET['eemail']) ? htmlspecialchars($_GET['eemail']) : '';
    ?>
  <div class="register-box" style="width: 650px">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="otp-v2.php" class="h1"><b>Admin</b>LTE</a>
      </div>
      <div class="card-body">
        <?php if (isset($_GET['error'])) { ?>
          <!-- Paragraph with error styling and text from GET parameter -->
          <div class="text-center">
            <p class="error text-danger"><?php echo $_GET['error']; ?></p>
          </div>
        <?php } ?>
        <form action="register.php" method="post" enctype="multipart/form-data">
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email*" value="<?php echo $eemail; ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" name="uname" class="form-control" placeholder="Username*" value="<?php echo $euname; ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <div style="display: flex; gap: 10px;">
              <input type="text" class="form-control" class="placeholder" style="width: 33%;" name="fname" placeholder=" First*" pattern="[A-Za-z\s]+"  title="don't input a number and special character" value="<?php echo $efname; ?>">                                
              <input type="text" class="form-control" class="placeholder" style="width: 33%;" name="mname" placeholder=" Middle" pattern="[A-Za-z\s]+"  title="don't input a number and special character" value="<?php echo $emname; ?>">
              <input type="text" class="form-control" class="placeholder" style="width: 33%;" name="lname" placeholder=" Last*" pattern="[A-Za-z\s]+"  title="don't input a number and special character" value="<?php echo $elname; ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
          </div>  
          <div class="input-group mb-3 bg-outline-secondary">
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
            <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-heart-broken"></span>
                </div>
              </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password*">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="cpassword" class="form-control" placeholder="Confirm Password*">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
              <div class="custom-file">
                  <input type="file" class="custom-file-input" aria-describedby="inputGroupFileAddon01" name="pp" onchange="updateLabel(this)">
                  <label class="custom-file-label form-control" for="inputGroupFile01">Choose a Profile Picture</label>
              </div>
              <div class="input-group-append">
                  <span class="input-group-text"><span class="fas fa-user-circle"></span></span>
              </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                <label for="agreeTerms">
                I agree to the <a href="#">terms and conditions</a>
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <div class="social-auth-links text-center">
          <a href="#" class="btn btn-block btn-primary">
            <i class="fab fa-facebook mr-2"></i>
            Sign up using Facebook
          </a>
          <a href="#" class="btn btn-block btn-danger">
            <i class="fab fa-google-plus mr-2"></i>
            Sign up using Google+
          </a>
        </div>

        <a href="login-v2.php" class="text-center">I already have a membership</a>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
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
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
</body>
</html>
