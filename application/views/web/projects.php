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
  .panel-heading{
    font-size: 20px;
    font-weight: bold;
  }
  .panel_heading_content{
    color:#f00;
  }
  .nav_pills{
    width: 80%;
    margin-left: 9%;
  }
  .nav-pills>li{
    float:right;
  }
  .sign{
    display: inline-block;
    float: right;
  }
  .star_img, .read_img{
    width: 7%;
    float: right;
    margin-right: 20px;
  }
  .empty_notice{
    text-align: center;
    font-size: 25px;
    margin-top: 10%;
    color: #CC5015;
  }
</style>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Projects List</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- Nav tabs -->
    <ul class="nav nav-pills nav_pills">
        <li class="tab_mywishes"><a href="<?php echo site_url('/') . 'web/projects?tab=mywishes' ?>">Wish List</a>
        </li>
        <li class="tab_unread"><a href="<?php echo site_url('/') . 'web/projects?tab=unread' ?>">Unread</a>
        </li>
        <li class="tab_all"><a href="<?php echo site_url('/') . 'web/projects?tab=all' ?>">All Projects</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
      <?php $tab = isset( $_GET['tab'] )?$_GET['tab']:'' ; ?>
      <?php $tab_class = isset( $_GET['tab'] )?('.tab_' . $_GET['tab']):'.tab_all' ; ?>


      <!-- All projects -->
      <?php if( $tab == 'all' || $tab == '' ): ?>
        <div class="tab-pane fade in active" id="all">
          <?php foreach ($projects as $key => $value): ?>
            <!-- /.col-lg-4 -->
            <div class="col-lg-10 page_content">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        PID (Project ID)：<span class="panel_heading_content"><?php echo $value['PID']; ?></span>
                        <div class="sign">
                          <?php if( $value['is_wish'] == true ): ?>
                            <img class="star_img star_show" wish-mark='1' data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/star_like.png'; ?>">
                            <img class="star_img star_hide" wish-mark='0' style="display: none;" data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/star_empty.png'; ?>">
                          <?php else: ?>
                              <img class="star_img star_show" wish-mark='1' style="display: none;" data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/star_like.png'; ?>">
                              <img class="star_img star_hide" wish-mark='0' data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/star_empty.png'; ?>">
                          <?php endif; ?>

                          <?php if( $value['is_read'] == true ): ?>
                            <img class="read_img read_show" read-mark='1' data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/had_read.png'; ?>">
                            <img class="read_img read_hide" read-mark='0' style="display: none;" data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/unread.png'; ?>">
                          <?php else: ?>
                             <img class="read_img read_show" read-mark='1' style="display: none;" data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/had_read.png'; ?>">
                            <img class="read_img read_hide" read-mark='0' data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/unread.png'; ?>">
                          <?php endif; ?>

                        </div>
                    </div>
                    <div class="panel-body">
                      <h4>Supervisor</h4>
                      <blockquote>
                          <p>
                            <a><span><?php echo ($value['supervisor']['name']); ?></span></a>
                            &nbsp;&nbsp;
                            <span>Room:<?php echo ($value['supervisor']['room']); ?></span>
                            &nbsp;&nbsp;
                            <span>Email:<?php echo ($value['supervisor']['email']); ?></span>
                          </p>
                      </blockquote>
                        <h4>Title</h4>
                        <blockquote>
                            <p><?php echo $value['title']; ?></p>
                        </blockquote>
                        <h4>Description</h4>
                        <blockquote>
                            <p><?php echo $value['desc']; ?></p>
                        </blockquote>
                        <h4>Possible Range (Difficulty)</h4>
                        <blockquote>


                            <p><?php echo $value['difficulty_min'], '%', '-', $value['difficulty_max'], '%'; ?></p>


                        </blockquote>
                        <h4>Popularity (Number of students)</h4>
                        <blockquote>
                            <p><?php echo $value['hadSelectedNo']; ?></p>
                        </blockquote>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
          <?php endforeach; ?>
        </div>



      <!-- unread -->
      <?php elseif( $tab == 'unread' ): ?>
        <div class="tab-pane fade in active" id="unread">
          <?php if( !empty( $projectsReads ) ): ?>
            <?php foreach ($projectsReads as $key => $value): ?>
              <!-- /.col-lg-4 -->
              <div class="col-lg-10 page_content">
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          PID (Project ID)：<span class="panel_heading_content"><?php echo $value['PID']; ?></span>
                          <div class="sign">

                            <?php if( $value['is_wish'] == true ): ?>
                              <img class="star_img star_show" wish-mark='1' data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/star_like.png'; ?>">
                              <img class="star_img star_hide"  wish-mark='0' style="display: none;" data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/star_empty.png'; ?>">
                            <?php else: ?>
                                <img class="star_img star_show" wish-mark='1' style="display: none;" data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/star_like.png'; ?>">
                                <img class="star_img star_hide" wish-mark='0' data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/star_empty.png'; ?>">
                            <?php endif; ?>

                            <?php if( $value['is_read'] == true ): ?>
                              <img class="read_img read_show" read-mark='1' data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/had_read.png'; ?>">
                              <img class="read_img read_hide" read-mark='0' style="display: none;" data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/unread.png'; ?>">
                            <?php else: ?>
                               <img class="read_img read_show" read-mark='1' style="display: none;" data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/had_read.png'; ?>">
                              <img class="read_img read_hide" read-mark='0' data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/unread.png'; ?>">
                            <?php endif; ?>

                          </div>
                      </div>
                      <div class="panel-body">
                        <h4>Supervisor</h4>
                        <blockquote>
                            <p>
                              <a><span><?php echo ($value['supervisor']['name']); ?></span></a>
                              &nbsp;&nbsp;
                              <span>Room:<?php echo ($value['supervisor']['room']); ?></span>
                              &nbsp;&nbsp;
                              <span>Email:<?php echo ($value['supervisor']['email']); ?></span>
                            </p>
                        </blockquote>
                          <h4>Title</h4>
                          <blockquote>
                              <p><?php echo $value['title']; ?></p>
                          </blockquote>
                          <h4>Descripetion</h4>
                          <blockquote>
                              <p><?php echo $value['desc']; ?></p>
                          </blockquote>
                          <h4>Possible Range (Difficulty)</h4>
                          <blockquote>


                              <p><?php echo $value['difficulty_min'], '%', '-', $value['difficulty_max'], '%'; ?></p>


                          </blockquote>
                          <h4>Popularity (Number of students)</h4>
                          <blockquote>
                          </blockquote>
                      </div>
                      <!-- /.panel-body -->
                  </div>
                  <!-- /.panel -->
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="empty_notice">No Unread Project.</div>
          <?php endif; ?>
        </div>



      <!-- Wish List -->
      <?php elseif( $tab == 'mywishes' ): ?>
        <div class="tab-pane fade in active" id="mywishes">
          <?php if( !empty( $projectsWishes ) ): ?>
            <?php foreach ($projectsWishes as $key => $value): ?>
              <!-- /.col-lg-4 -->
              <div class="col-lg-10 page_content">
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          PID (Project ID)：<span class="panel_heading_content"><?php echo $value['PID']; ?></span>
                          <div class="sign">

                            <?php if( $value['is_wish'] == true ): ?>
                              <img class="star_img star_show" wish-mark='1' data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/star_like.png'; ?>">
                              <img class="star_img star_hide" style="display: none;"  wish-mark='0' data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/star_empty.png'; ?>">
                            <?php else: ?>
                                <img class="star_img star_show" wish-mark='1' style="display: none;" data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/star_like.png'; ?>">
                                <img class="star_img star_hide" wish-mark='0' data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/star_empty.png'; ?>">
                            <?php endif; ?>

                            <?php if( $value['is_read'] == true ): ?>
                              <img class="read_img read_show" read-mark='1' data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/had_read.png'; ?>">
                              <img class="read_img read_hide" read-mark='0' style="display: none;" data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/unread.png'; ?>">
                            <?php else: ?>
                               <img class="read_img read_show" read-mark='1' style="display: none;" data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/had_read.png'; ?>">
                              <img class="read_img read_hide" read-mark='0' data-id='<?php echo $value['id']; ?>' src="<?php echo base_url() . 'assets/images/web/unread.png'; ?>">
                            <?php endif; ?>

                          </div>
                      </div>
                      <div class="panel-body">
                        <h4>Supervisor</h4>
                        <blockquote>
                            <p>
                              <a><span><?php echo ($value['supervisor']['name']); ?></span></a>
                              &nbsp;&nbsp;
                              <span>Room:<?php echo ($value['supervisor']['room']); ?></span>
                              &nbsp;&nbsp;
                              <span>Email:<?php echo ($value['supervisor']['email']); ?></span>
                            </p>
                        </blockquote>
                          <h4>Title</h4>
                          <blockquote>
                              <p><?php echo $value['title']; ?></p>
                          </blockquote>
                          <h4>Descripetion</h4>
                          <blockquote>
                              <p><?php echo $value['desc']; ?></p>
                          </blockquote>
                          <h4>Possible Range (Difficulty)</h4>
                          <blockquote>


                              <p><?php echo $value['difficulty_min'], '%', '-', $value['difficulty_max'], '%'; ?></p>

                              
                          </blockquote>
                          <h4>Popularity (Number of students)</h4>
                          <blockquote>
                          </blockquote>
                      </div>
                      <!-- /.panel-body -->
                  </div>
                  <!-- /.panel -->
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="empty_notice">No Project in Wish List.</div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>

    <script type="text/javascript">
      $(function(){
        $('.star_img').click(function(){
          var wish_mark = $(this).attr( 'wish-mark' );
          var id = $(this).attr( 'data-id' );
          var url = '<?php echo site_url('/') . 'web/projects/myWishListChange'; ?>';
          var this_obj = $(this);
          $.ajax({
            url:url,
            type:"GET",
            data:{
              wish_mark:wish_mark,
              id:id
            },
            success:function(e){
              console.log(e);
              var obj = JSON.parse(e);
              if( obj.code == '0' ){
                if( obj.data == '1' ){
                  this_obj.hide();
                  this_obj.parent().find( '.star_hide' ).show();
                }else{
                  this_obj.hide();
                  this_obj.parent().find( '.star_show' ).show();
                }
              }else{
                alert(obj.msg);
              }
              // console.log(e);
              // alert('ajax success');
            },
            error:function(e){
              alert(e.status);
            }
          })
        })

        $('.read_img').click(function(){
          var read_mark = $(this).attr( 'read-mark' );
          var id = $(this).attr( 'data-id' );
          var url = '<?php echo site_url('/') . 'web/projects/myReadListChange'; ?>';
          var this_obj = $(this);
          $.ajax({
            url:url,
            type:"GET",
            data:{
              read_mark:read_mark,
              id:id
            },
            success:function(e){
              console.log(e);
              var obj = JSON.parse(e);
              if( obj.code == '0' ){
                if( obj.data == '1' ){
                  this_obj.hide();
                  this_obj.parent().find( '.read_hide' ).show();
                }else{
                  this_obj.hide();
                  this_obj.parent().find( '.read_show' ).show();
                }
              }else{
                alert(obj.msg);
              }
              // console.log(e);
              // alert('ajax success');
            },
            error:function(e){
              alert(e.status);
            }
          })
        })
      });
    </script>

    <script type="text/javascript">
      $(function(){
        $('.nav-pills li').removeClass( 'active' );
        $('<?php echo $tab_class; ?>').addClass('active');
      });
    </script>
</div>