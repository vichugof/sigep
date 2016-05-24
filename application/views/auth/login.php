<!-- <h1><?php //echo lang('login_heading');?></h1>
<p><?php //echo lang('login_subheading');?></p>
 -->
<!-- <div id="infoMessage"><?php //echo $message;?></div> -->

<?php //echo form_open("auth/login");?>

 <!--  <p>
    <?php //echo lang('login_identity_label', 'identity');?>
    <?php//echo form_input($identity);?>
  </p>

  <p>
    <?php //echo lang('login_password_label', 'password');?>
    <?php //echo form_input($password);?>
  </p>

  <p>
    <?php //echo lang('login_remember_label', 'remember');?>
    <?php //echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
  </p>


  <p><?php //echo form_submit('submit', lang('login_submit_btn'));?></p> -->

<?php //echo form_close();?>

<!-- <p><a href="forgot_password"><?php //echo lang('login_forgot_password');?></a></p> -->


  <head>
    <!-- Bootstrap core CSS -->
    <link href="http://localhost/~vichugof/sigep/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <style type="text/css">
      body {
      padding-top: 40px;
      padding-bottom: 40px;
      background-color: #eee;
    }

    .form-signin {
      max-width: 330px;
      padding: 15px;
      margin: 0 auto;
    }
    .form-signin .form-signin-heading,
    .form-signin .checkbox {
      margin-bottom: 10px;
    }
    .form-signin .checkbox {
      font-weight: normal;
    }
    .form-signin .form-control {
      position: relative;
      height: auto;
      -webkit-box-sizing: border-box;
         -moz-box-sizing: border-box;
              box-sizing: border-box;
      padding: 10px;
      font-size: 16px;
    }
    .form-signin .form-control:focus {
      z-index: 2;
    }
    .form-signin input[type="text"] {
      margin-bottom: -1px;
      border-bottom-right-radius: 0;
      border-bottom-left-radius: 0;
    }
    .form-signin input[type="password"] {
      margin-bottom: 10px;
      border-top-left-radius: 0;
      border-top-right-radius: 0;
    }

    </style>
  </head>

    <div class="container">

      <?php echo form_open("index.php/auth/login", array('class' => 'form-signin')); ?>
      <!-- <form class="form-signin" action="auth/login"> -->
        <!-- <h2 class="form-signin-heading">Please sign in</h2> -->
        <h1><?php echo lang('login_heading');?></h1>
        <p><?php echo lang('login_subheading');?></p>
        <h2 id="infoMessage" class="form-signin-heading"><?php echo $message;?></h2>

        <p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>
        <!-- <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus> -->
        <?php echo lang('login_identity_label', 'identity', array('class' => 'sr-only'));?>
        <?php echo form_input($identity, '', 'class="form-control" placeholder="'.lang('login_identity_label').'"');?>
        <!-- <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required> -->
        <?php echo lang('login_password_label', 'password', array('class' => 'sr-only'));?>
        <?php echo form_input($password, '', 'class="form-control" placeholder="'.lang('login_password_label').'"');?>
        <div class="checkbox">
          <label>
            <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
            <?php echo lang('login_remember_label');?>
            <!-- <input type="checkbox" value="remember-me"> -->
          </label>
          <?php //echo lang('login_remember_label', 'remember');?>
          <?php //  echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
        </div>
        <!-- <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button> -->
        <?php echo form_submit('submit', lang('login_submit_btn'), 'class="btn btn-lg btn-primary btn-block"');?>
      </form>

    </div> <!-- /container -->
