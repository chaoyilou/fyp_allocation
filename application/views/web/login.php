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
    <body class="login">

        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <?php echo form_open('web/login/validate'); ?>
                <h3 class="form-title font-green">Students Login</h3>
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

        <!--<div class="copyright" ><span id="copyright"></span> © 帝国理工大学 </div> -->

        <script type="text/javascript">
            function login_change(){
                $('.loging').html('Login...');
            }
        </script>
    </body>