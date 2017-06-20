<style type="text/css">
  .btn-warning{
    margin-bottom: 15px;
  }
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Meeting Management</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>


    <ul id="myTabs" class="nav nav-pills" role="tablist">
      <li role="presentation" class="active"><a href="#effective" id="effective-tab" role="tab" data-toggle="tab" aria-controls="effective" aria-expanded="true">Suspending</a></li>
      <li role="presentation"><a href="#confirmed" id="confirmed-tab" role="tab" data-toggle="tab" aria-controls="confirmed" aria-expanded="true">Accepted</a></li>
      <li role="presentation"><a href="#refused" id="refused-tab" role="tab" data-toggle="tab" aria-controls="refused" aria-expanded="true">Rejected</a></li>
      <li role="presentation"><a href="#completed" id="completed-tab" role="tab" data-toggle="tab" aria-controls="completed" aria-expanded="true">Completed</a></li>
      <!-- <li role="presentation"><a href="#all" id="all-tab" role="tab" data-toggle="tab" aria-controls="all" aria-expanded="true">全部</a></li> -->
    </ul>

    <!-- tab内容域 -->
    <div id="myTabContent" class="tab-content">

      <div role="tabpanel" class="tab-pane fade active in" id="effective" aria-labelledby="effective-tab">
        <table id="effective_appointment" class="table table-striped table-bordered table-hover" border="1" width="100%" >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Supervisor's Name</th>
                    <th>Student's Name</th>
                    <th>Meeting Time</th>
                    <th>Meeting Room</th>
                    <th>Meeting Preference</th>
                    <!--<th>Main Topic</th>-->
                    <th>Comments</th>
                    <th>Status</th>
                    <th>Establish Time</th>
                    <th>Update Time</th>
                    <th>Operation</th>
                </tr>
            </thead>
          </table>
      </div>

      <div role="tabpanel" class="tab-pane fade" id="confirmed" aria-labelledby="confirmed-tab">
        <table id="confirmed_appointment" class="table table-striped table-bordered table-hover" border="1" width="100%" >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Supervisor's Name</th>
                    <th>Student's Name</th>
                    <th>Meeting Time</th>
                    <th>Meeting Room</th>
                    <th>Meeting Preference</th>
                    <!--<th>Main Topic</th>-->
                    <th>Comments</th>
                    <th>Status</th>
                    <th>Establish Time</th>
                    <th>Update Time</th>
                    <th>Operation</th>
                </tr>
           </thead>
        </table>
      </div>

      <div role="tabpanel" class="tab-pane fade" id="refused" aria-labelledby="refused-tab">
        <table id="refused_appointment" class="table table-striped table-bordered table-hover" border="1" width="100%" >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Supervisor's Name</th>
                    <th>Student's Name</th>
                    <th>Meeting Time</th>
                    <th>Meeting Room</th>
                    <th>Meeting Preference</th>
                    <!--<th>Main Topic</th>-->
                    <th>Comments</th>
                    <th>Status</th>
                    <th>Establish Time</th>
                    <th>Update Time</th>
                    <th>Operation</th>
                </tr>
           </thead>
        </table>
      </div>

      <div role="tabpanel" class="tab-pane fade" id="completed" aria-labelledby="completed-tab">
        <table id="completed_appointment" class="table table-striped table-bordered table-hover" border="1" width="100%" >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Supervisor's Name</th>
                    <th>Student's Name</th>
                    <th>Meeting Time</th>
                    <th>Meeting Room</th>
                    <th>Meeting Preference</th>
                    <!--<th>Main Topic</th>-->
                    <th>Comments</th>
                    <th>Status</th>
                    <th>Establish Time</th>
                    <th>Update Time</th>
                    <th>Operation</th>
                </tr>
           </thead>
        </table>
      </div>

    </div>
</div>

<!-- bootstrap modal框 -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalOne" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Status<span class="modal_title_extend">Change to：</span> <span class="extentd_id supervisor_name"></span></h4>
      </div>
      <div class="modal-body">
          <h4 style="color:red;">Are you sure you want to change the status？</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary btn_sure">Confirm Change</button>
        <input type="hidden" class="hidden_id" value="" >
        <input type="hidden" class="hidden_status" value="" >
      </div>
    </div>
  </div>
</div>

<!-- datatable 控制 -->
<script type="text/javascript">
   $(function(){
  		dtTable_one =  jQuery('#effective_appointment').DataTable({
          "initComplete": function( settings, json ) {
              init_base_modal();
            },
          ajax: {
                  type: 'POST',
                  url: "<?php echo site_url('admin/meetings/meetingsList'); ?>",
                  dataSrc: 'items',
                  data: {
                      status:'0'
                      },
                  // success:function(data){
                  //   console.log(data);
                  // }
          },
          "columns": [
                      { data:'id'},
                      { data:'supervisor_name'},
                      { data: 'student_name'},
                      { data: 'appointment_time'},
                      { data: 'meeting_room'},
                      { data: 'appointment_preference'},
                      //{ data: 'meeting_content'},
                      { data: 'memo'},
                      { data: 'status',
                          'render':function( data, type, full, meta ){
                              if( data == '0' ){
                                data = 'Suspending'
                              }else if( data == '1' ){
                                data = 'Accepted';
                              }else if( data == '2' ){
                                data = 'Rejected';
                              }else if( data == '3' ){
                                data = 'Completed';
                              }else{
                                data = 'Others';
                              }
                              return "<p style='color:red'>" + data + "</p>";
                          }
                      },
                      { data: 'create_time'},
                      { data: 'update_time'},
                      { data: 'id',
                          'render':function( data, type, full, meta ){
                            return '<div class="btn-group"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Operate <span class="caret"></span> </button> <ul class="dropdown-menu"> <li class="change_status" data-order-id=' + data + ' data-order-status="1" data-order-name="Accepted" data-toggle="modal" data-target="#modalOne"><a href="#">Accept</a></li><li class="change_status" data-order-id=' + data + ' data-order-status="2" data-order-name="Rejected" data-toggle="modal" data-target="#modalOne"><a href="#">Reject</a></li><li class="change_status" data-order-id=' + data + ' data-order-status="3" data-toggle="modal" data-order-name="Completed" data-target="#modalOne"><a href="#">Complete</a></li></ul></div>';
                          }
                      }
                   ],
          "order": [
                      [ 8, 'desc' ]
                   ]
  	    });
  		dtTable_one.on( 'draw.dt', function () {
        init_base_modal();
  		});

      dtTable_two =  jQuery('#confirmed_appointment').DataTable({
          "initComplete": function( settings, json ) {
              init_base_modal();
            },
          ajax: {
                  type: 'POST',
                  url: "<?php echo site_url('admin/meetings/meetingsList'); ?>",
                  dataSrc: 'items',
                  data: {
                      status:'1'
                      },
                  // success:function(data){
                  //   console.log(data);
                  // }
          },
          "columns": [
                      { data:'id'},
                      { data:'supervisor_name'},
                      { data: 'student_name'},
                      { data: 'appointment_time'},
                      { data: 'meeting_room'},
                      { data: 'appointment_preference'},
                      //{ data: 'meeting_content'},
                      { data: 'memo'},
                      { data: 'status',
                          'render':function( data, type, full, meta ){
                              if( data == '0' ){
                                data = 'Suspending'
                              }else if( data == '1' ){
                                data = 'Accepted';
                              }else if( data == '2' ){
                                data = 'Rejected';
                              }else if( data == '3' ){
                                data = 'Completed';
                              }else{
                                data = 'Others';
                              }
                              return "<p style='color:red'>" + data + "</p>";
                          }
                      },
                      { data: 'create_time'},
                      { data: 'update_time'},
                      { data: 'id',
                          'render':function( data, type, full, meta ){
                            return '<div class="btn-group"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Operate <span class="caret"></span> </button> <ul class="dropdown-menu"> <li class="change_status" data-order-id=' + data + ' data-order-status="2" data-order-name="Rejected" data-toggle="modal" data-target="#modalOne"><a href="#"> Reject </a></li><li class="change_status" data-order-id=' + data + ' data-order-status="3" data-toggle="modal" data-order-name="Completed" data-target="#modalOne"><a href="#"> Complete </a></li></ul></div>';
                          }
                      }
                   ],
          "order": [
                      [ 8, 'desc' ]
                   ]
        });
      dtTable_two.on( 'draw.dt', function () {
        init_base_modal();
      });

      dtTable_three =  jQuery('#refused_appointment').DataTable({
          "initComplete": function( settings, json ) {
              init_base_modal();
            },
          ajax: {
                  type: 'POST',
                  url: "<?php echo site_url('admin/meetings/meetingsList'); ?>",
                  dataSrc: 'items',
                  data: {
                      status:'2'
                      },
                  // success:function(data){
                  //   console.log(data);
                  // }
          },
          "columns": [
                      { data:'id'},
                      { data:'supervisor_name'},
                      { data: 'student_name'},
                      { data: 'appointment_time'},
                      { data: 'meeting_room'},
                      { data: 'appointment_preference'},
                      //{ data: 'meeting_content'},
                      { data: 'memo'},
                      { data: 'status',
                          'render':function( data, type, full, meta ){
                              if( data == '0' ){
                                data = 'Suspending'
                              }else if( data == '1' ){
                                data = 'Accepted';
                              }else if( data == '2' ){
                                data = 'Rejected';
                              }else if( data == '3' ){
                                data = 'Completed';
                              }else{
                                data = 'Others';
                              }
                              return "<p style='color:red'>" + data + "</p>";
                          }
                      },
                      { data: 'create_time'},
                      { data: 'update_time'},
                      { data: 'id',
                          'render':function( data, type, full, meta ){
                            return '<div class="btn-group"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Operate <span class="caret"></span> </button> <ul class="dropdown-menu"> <li class="change_status" data-order-id=' + data + ' data-order-status="1" data-order-name="Accepted" data-toggle="modal" data-target="#modalOne"><a href="#"> Accept</a></li><li class="change_status" data-order-id=' + data + ' data-order-status="3" data-toggle="modal" data-order-name="Completed" data-target="#modalOne"><a href="#"> Complete </a></li></ul></div>';
                          }
                      }
                   ],
          "order": [
                      [ 8, 'desc' ]
                   ]
        });
      dtTable_three.on( 'draw.dt', function () {
        init_base_modal();
      });

      dtTable_three =  jQuery('#completed_appointment').DataTable({
          "initComplete": function( settings, json ) {
              init_base_modal();
            },
          ajax: {
                  type: 'POST',
                  url: "<?php echo site_url('admin/meetings/meetingsList'); ?>",
                  dataSrc: 'items',
                  data: {
                      status:'3'
                      },
                  // success:function(data){
                  //   console.log(data);
                  // }
          },
          "columns": [
                      { data:'id'},
                      { data:'supervisor_name'},
                      { data: 'student_name'},
                      { data: 'appointment_time'},
                      { data: 'meeting_room'},
                      { data: 'appointment_preference'},
                      //{ data: 'meeting_content'},
                      { data: 'memo'},
                      { data: 'status',
                          'render':function( data, type, full, meta ){
                              if( data == '0' ){
                                data = 'Suspending'
                              }else if( data == '1' ){
                                data = 'Accepted';
                              }else if( data == '2' ){
                                data = 'Rejected';
                              }else if( data == '3' ){
                                data = 'Completed';
                              }else{
                                data = 'Others';
                              }
                              return "<p style='color:red'>" + data + "</p>";
                          }
                      },
                      { data: 'create_time'},
                      { data: 'update_time'},
                      { data: 'id',
                          'render':function( data, type, full, meta ){
                            return '<div class="btn-group"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Operate <span class="caret"></span> </button> <ul class="dropdown-menu"> <li class="change_status" data-order-id=' + data + ' data-order-status="1" data-order-name="Accepted" data-toggle="modal" data-target="#modalOne"><a href="#"> Accept</a></li><li class="change_status" data-order-id=' + data + ' data-order-status="2" data-order-name="Rejected" data-toggle="modal" data-target="#modalOne"><a href="#"> Reject </a></li></ul></div>';
                          }
                      }
                   ],
          "order": [
                      [ 8, 'desc' ]
                   ]
        });
      dtTable_three.on( 'draw.dt', function () {
        init_base_modal();
      });
   });
</script>

<!-- JS定义函数 -->
<script type="text/javascript">
  function init_base_modal(){
    $('.change_status').unbind().click(function(){
      var name = $(this).attr('data-order-name');
      var id = $(this).attr('data-order-id');
      var status = $(this).attr('data-order-status');
      $('#modalOne').find('.supervisor_name').text(name);
      $('#modalOne').find('.hidden_id').val(id);
      $('#modalOne').find('.hidden_status').val(status);
    });

  }

  function change_appointment_status(){
    $('.btn_sure').click(function(){
      var data = new Array();
      data['id'] = $('#modalOne').find('.hidden_id').val();
      data['status'] = $('#modalOne').find('.hidden_status').val();
      change_status_ajax( data );
    });
  }

  function change_status_ajax( data ){
    var url = "<?php echo site_url('/') . 'admin/meetings/changeStatus' ?>";
    $.ajax({
      url:url,
      type:'POST',
      data:{
        id:data['id'],
        status:data['status'],
      },
      success:function(e){
        var obj = JSON.parse(e);
        if( obj.code == '0' ){
          alert('Update Succeeded');
          window.location.reload();
        }else{
          alert('Update Failed');
        }
      },
      error:function(e){
        alert(e.status);
      }
    });
  }

</script>

<!-- 函数执行 -->
<script type="text/javascript">
  $(function(){
      change_appointment_status();
  });
</script>

<!-- tab 切换控制 -->
<script type="text/javascript">
  $(function(){
    $('#myTabs a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    });
  });
</script>

