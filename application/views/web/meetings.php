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
  }
  #page-wrapper{
    min-height: 1000px;
  }
  .tab-content{
    width: 90%;
    margin-left: 5%;
  }
  .headimgurl{
    width: 8%;
    border-radius: 50%;
    margin-left: 4%;
  }
  .detail{
    text-decoration: underline;
  }
  .input-group{
    width: 12%;
    margin-left: 87%;
    margin-bottom: 2%;
    margin-top: 0px;
  }

  .input-group .form-control{
    float: right;
    width: 157%;
  }

  .appoint_now{
    display: inline-block;
    border-radius: 5px;
    background: #45abd4;
    padding: 4px 6px;
    float: right;
    color: #fff;
    margin-bottom: 0px;
    margin-top: 1%;
    cursor: pointer;
  }
  .paginations{
    font-size: 17px;
    padding-bottom: 40px;
    float: right;
    margin-left: 65%;
  }
  .paginations *{
    padding-left: 2px;
    padding: 5px 10px;
    border: 0.5px solid #aaa;
    border-right:none;
  }
  .paginations a:last-child{
    border-right:0.5px solid #aaa;
  }
  .paginations strong{
    background: #337ab7;
    color: #fff;
  }
  blockquote{
    padding: 0px 20px;
  }
</style>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Supervisors List</h1>
        </div>
    </div>

    <div class="tab-content">
        <form method="GET" action="<?php echo site_url('web/meetings/supervisorlist'); ?>" >
            <div class="input-group">
                <input id="btn-input" value="<?php echo isset( $_GET['searchKey'])?$_GET['searchKey']:''; ?>" type="text" name="searchKey" class="form-control input-sm" placeholder="Search Supervisor" />
                <span class="input-group-btn">
                    <button class="btn btn-warning btn-sm" id="btn-chat">
                        Search
                    </button>
                </span>
            </div>
        </form>

        <div class="tab-pane fade in active">
            <?php foreach ($supervisors as $key => $supervisor): ?>
                <!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $supervisor['name']; ?>
                            <img class="headimgurl" src="<?php echo base_url('uploads/supervisors/') . (!empty($supervisor['headimgurl'])?$supervisor['headimgurl']:'default_headimgurl.png'); ?>">
                            <a href="<?php echo site_url('web/meetings/appointment/') . '?id=' . $supervisor['id']; ?>"><p class="appoint_now">Reserve Meeting</p></a>
                        </div>
                        <div class="panel-body">
                            <h4>Homepage</h4>
                            <blockquote>
                                <a href="<?php echo $supervisor['homepage']; ?>"><p><?php echo $supervisor['homepage']; ?></p></a>
                            </blockquote>
                            <h4>Email</h4>
                            <blockquote>
                                <p><?php echo $supervisor['email']; ?></p>
                            </blockquote>
                            <h4>Room</h4>
                            <blockquote>
                                <p><?php echo $supervisor['room']; ?></p>
                            </blockquote>
                            <h4>Meeting Preference</h4>
                            <blockquote>
                                <p><?php echo $supervisor['appointment_preference']; ?></p>
                            </blockquote>
                            <blockquote class="pull-right">
                                <a href="<?php echo site_url('/') . 'web/supervisors/detail/?id=' . $supervisor['id']; ?>"><p class="detail">More Detail</p></a>
                            </blockquote>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            <?php endforeach; ?>

            <!-- 分页器 -->
            <div class="paginations">
                <?php echo $pagination; ?>
            </div>
        </div>
    </div>

</div>