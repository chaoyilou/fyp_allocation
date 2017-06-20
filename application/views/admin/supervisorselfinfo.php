<style type="text/css">
  #page-wrapper h4{
    font-weight: bold;
    margin-top: 5px;
    margin-bottom: 5px;
  }
  #page-wrapper a{
    cursor: pointer;
  }
  .page_content{
    margin-left: 7%;
    float:none;
  }
  blockquote{
    font-size: 16px;
    margin-bottom: 0px;
    padding-top:5px !important;
    border-left:none;
  }
  #page-wrapper{
    min-height: 1000px;
  }
  .tab-content{
    width: 90%;
    margin-left: 5%;
  }
  .headimgurl{
    width: 5%;
    border-radius: 50%;
    margin-left: 3%;
  }
  .detail{
    text-decoration: underline;
  }
  .panel-heading,.panel-body{
    text-align: center;
  }
  .panel-default{
    font-size: 28px;
  }
</style>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Personal Information</h1>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade in active">
            <!-- /.col-lg-4 -->
            <div class="col-lg-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <img class="headimgurl" src="<?php echo base_url() . $supervisordetail['headimgurl']; ?>">
                        <?php echo $supervisordetail['name']; ?>
                    </div>
                    <div class="panel-body">
                        <h4>Homepage</h4>
                        <blockquote>
                            <a href="<?php echo $supervisordetail['homepage']; ?>"><p><?php echo $supervisordetail['homepage']; ?></p></a>
                        </blockquote>
                        <h4>Email</h4>
                        <blockquote>
                            <p><?php echo $supervisordetail['email']; ?></p>
                        </blockquote>
                        <h4>Room</h4>
                        <blockquote>
                            <p><?php echo $supervisordetail['room']; ?></p>
                        </blockquote>
                        <h4>Meeting Preference</h4>
                        <blockquote>
                            <p><?php echo $supervisordetail['appointment_preference']; ?></p>
                        </blockquote>
                        <button type="button" class="btn btn-warning modify_meeting_preference">Change Meeting Preference</button>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </div>
    </div>

</div>