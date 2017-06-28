<link href="<?php echo base_url() . 'assets/css/admin/login.min.css'; ?>" rel="stylesheet" type="text/css">
<style type="text/css">
	.error{
		color: red;
		margin-bottom: 10px;
	}
    .loging{
        font-weight: 600;
    }
    .login{
        background: url('<?php echo base_url() . 'assets/images/admin/login_bg_1.jpg' ?>') no-repeat !important;
        background-size: 100% !important;
    }
    .logo_img{
        width:8%;
    }
    .content{
        background:rgba(255, 255, 255, 0.34) !important;
    }
    .content input{
        background: #fff !important
    }
    .login .content{
        margin-right: 50px !important;
        margin-top:2%;
    }
    .form-actions button{
        margin-left: 30%;
        width: 31%;
    }
    .login .content h3{
        color: #337ABD;
    }
</style>

<?php //echo base_url(); ?>
<?php //echo site_url(); ?>
    <!-- <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">请登录</h3>
                    </div>
                    <div class="panel-body">
                        <?php //echo validation_errors(); ?>
                        <?php //echo form_open('admin/login/validate'); ?>
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" value="admin" autofocus>
                                </div>
                                <?php //echo form_error('username', '<div class="error">', '</div>'); ?>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="123456">
                                </div>
                                <?php //echo form_error('password', '<div class="error">', '</div>'); ?>
                                <p class="error"><?php //if( isset($msg) ) echo $msg; ?></p>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                Change this to a button or input when using this as a form
                                <button type="submit" onclick="login_change();" class="btn btn-lg btn-success btn-block loging">登录</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- <script type="text/javascript">
        function login_change(){
            $('.loging').html('登录中...');
        }
    </script> -->


    <body class="login">
        <!-- BEGIN LOGO -->
        <!-- <div class="logo">
                <img class="logo_img" src="<?php //echo base_url() . 'assets/images/admin/logo_1.jpg' ?>" alt="" />
        </div> -->
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <?php echo form_open('admin/login/validate'); ?>
                <h3 class="form-title font-green">Administrator Login</h3>
                <div class="form-group line">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">USERNAME</label>
                    <!-- <i class="iconfont user">&#xe659;</i> -->
                    <div>
                        <input class="form-control form-control-solid placeholder-no-fix" id="username" type="text" placeholder="USERNAME" name="username" /> 
                    </div>
                    <?php echo form_error('username', '<div class="error">', '</div>'); ?>
                </div>
                <div class="form-group line">
                    <label class="control-label visible-ie8 visible-ie9">PASSWORD</label>
                    <!-- <i class="iconfont user">&#xe658;</i> -->
                    <div>
                        <input class="form-control form-control-solid placeholder-no-fix" id="password" type="password" placeholder="PASSWORD" name="password" /> 
                    </div>
                    <?php echo form_error('password', '<div class="error">', '</div>'); ?>
                    <p class="error"><?php if( isset($msg) ) echo $msg; ?></p>
                </div>
                <div class="form-actions">
                    <label class="rememberme check mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" value="1" />Save Account
                        <span></span>
                    </label>
                    <button type="submit" class="btn btn-primary uppercase" onclick="login_change();">Login</button>
                </div>
            </form>
            <!-- END LOGIN FORM -->
        </div>

        <!--<div class="copyright" ><span id="copyright"></span> © Imperial College London </div> -->

        <script type="text/javascript">
            function login_change(){
                $('.loging').html('login...');
            }
        </script>
    </body>