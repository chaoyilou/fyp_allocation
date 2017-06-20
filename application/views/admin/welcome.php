

    <div id="wrapper">

        <!-- Navigation -->

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">FYP Information Management</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Login Detail
                        </div>
                        <div class="panel-body">
                            <li>Login Account：<span><?php echo $loginInfo['account']; ?></span></li>
                            <!-- <li>登录次数：<span><?php //echo $loginInfo['logined_count']; ?></span></li> -->
                            <li>Latest Login Time：<span><?php echo $loginInfo['update_time']; ?></span></li>
                        </div>
                        <div class="panel-footer">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
