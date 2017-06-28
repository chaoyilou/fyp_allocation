<style type="text/css">
  .btn-warning{
    margin-bottom: 15px;
  }
  .img{
    width: 50px;
    border-radius: 50%;
  }
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Student Management</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <a href="<?php echo site_url('admin/students/studentadd'); ?>"><button type="button" class="btn btn-warning">Add a New Student</button></a>

    <ul id="myTabs" class="nav nav-pills" role="tablist">
      <li role="presentation" class="active"><a href="#effective" id="effective-tab" role="tab" data-toggle="tab" aria-controls="effective" aria-expanded="true">Active</a></li>
      <li role="presentation"><a href="#deleted" id="deleted-tab" role="tab" data-toggle="tab" aria-controls="deleted" aria-expanded="true">Deleted</a></li>
      <!-- <li role="presentation"><a href="#all" id="all-tab" role="tab" data-toggle="tab" aria-controls="all" aria-expanded="true">全部</a></li> -->
    </ul>


    <!-- tab内容域 -->
    <div id="myTabContent" class="tab-content">

      <div role="tabpanel" class="tab-pane fade active in" id="effective" aria-labelledby="effective-tab">
        <table id="effective_students" class="table table-striped table-bordered table-hover" border="1" width="100%" >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Photo</th>
                    <th>Email</th>
                    <th>stream</th>
                    <th>Status</th>
                    <th>Operation</th>
                </tr>
            </thead>
          </table>
      </div>

      <div role="tabpanel" class="tab-pane fade" id="deleted" aria-labelledby="deleted-tab">
        <table id="deleted_students" class="table table-striped table-bordered table-hover" border="1" width="100%" >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Photo</th>
                    <th>Email</th>
                    <th>stream</th>
                    <th>Status</th>
                    <th>Operation</th>
                </tr>
           </thead>
        </table>
      </div>

      <div role="tabpanel" class="tab-pane fade" id="all" aria-labelledby="all-tab">
        <table id="all_students" class="table table-striped table-bordered table-hover" border="1" width="100%" >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Photo</th>
                    <th>Email</th>
                    <th>stream</th>
                    <th>Status</th>
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
        <h4 class="modal-title">Delete Student<span class="modal_title_extend">Student Name：</span> <span class="extentd_id student_name"></span></h4>
      </div>
      <div class="modal-body">
          <h4 style="color:red;">Are you sure you want to delete this student?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary btn_sure_delete">Confirm Deletion</button>
        <input type="hidden" class="hidden_student_id" value="" >
      </div>
    </div>
  </div>
</div>


<!-- bootstrap modal框 -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalTwo" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Restore Student<span class="modal_title_extend">Student Name：</span> <span class="extentd_id student_name"></span></h4>
      </div>
      <div class="modal-body">
          <h4 style="color:red;">Are you sure you want to restore this student?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary btn_sure_recover">Confirm Restore</button>
        <input type="hidden" class="hidden_student_id" value="" >
      </div>
    </div>
  </div>
</div>

<!-- datatable 控制 -->
<script type="text/javascript">
   $(function(){
  		dtTable_one =  jQuery('#effective_students').DataTable({
          "initComplete": function( settings, json ) {
              init_base_modal();
            },
          ajax: {
                  type: 'POST',
                  url: "<?php echo site_url('admin/students/studentsList'); ?>",
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
                      { data:'account'},
                      { data: 'name'},
                      { data: 'headimgurl',
                        'render':function( data, type, full, meta ){
                          return '<img class="img" src="' + full.headimgurlfull + '">';
                        }
                      },
                      { data: 'email'},
                      { data: 'stream',
                        'render':function( data, type, full, meta ){
                            if( data == '1' ){
                              data = 'EEE Beng'
                            }else if( data == '2' ){
                              data = 'EIE Beng';
                            }else if( data == '3' ){
                              data = 'EEE Meng';
                            }else if( data == '4' ){
                              data = 'EIE Meng';
                            }else{
                              data = 'other';
                            }
                            return "<p style='color:red'>" + data + "</p>";
                        }
                      },
                      { data: 'status',
                          'render':function( data, type, full, meta ){
                              if( data == '1' ){
                                data = 'Active'
                              }else if( data == '0' ){
                                data = 'Deleted';
                              }else{
                                data = 'Others';
                              }
                              return "<p style='color:red'>" + data + "</p>";
                          }
                      },
                      { data: 'id',
  			                  'render':function( data, type, full, meta ){
                            var detail_url = "<?php echo site_url('admin/students/studentadd/'); ?>" + "?id=" + data;
                            return '<div class="btn-group"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Operate <span class="caret"></span> </button> <ul class="dropdown-menu"><li class="detail" data-order-id=' + data + ' data-order-name=' + full.title + '><a href="' + detail_url + '">Edit</a></li><li class="delete_student_class" data-order-id=' + data + ' data-order-name=' + full.name + ' data-toggle="modal" data-target="#modalOne"><a href="#">Delete</a></li></ul></div>';
                          }
                      }
                   ],
          "order": [
                      [ 0, 'desc' ]
                   ]
  	    });
  		dtTable_one.on( 'draw.dt', function () {
        init_base_modal();
  		});

      dtTable_two =  jQuery('#deleted_students').DataTable({
          "initComplete": function( settings, json ) {
              init_base_modal();
            },
          ajax: {
                  type: 'POST',
                  url: "<?php echo site_url('admin/students/studentsList'); ?>",
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
                      { data:'account'},
                      { data: 'name'},
                      { data: 'headimgurl',
                        'render':function( data, type, full, meta ){
                          return '<img class="img" src="' + full.headimgurlfull + '">';
                        }
                      },
                      { data: 'email'},
                      { data: 'stream',
                        'render':function( data, type, full, meta ){
                            if( data == '1' ){
                              data = 'EEE Beng'
                            }else if( data == '2' ){
                              data = 'EIE Beng';
                            }else if( data == '3' ){
                              data = 'EEE Meng';
                            }else if( data == '4' ){
                              data = 'EIE Meng';
                            }else{
                              data = 'other';
                            }
                            return "<p style='color:red'>" + data + "</p>";
                        }
                      },
                      { data: 'status',
                          'render':function( data, type, full, meta ){
                              if( data == '1' ){
                                data = 'Active'
                              }else if( data == '0' ){
                                data = 'Deleted';
                              }else{
                                data = 'Others';
                              }
                              return "<p style='color:red'>" + data + "</p>";
                          }
                      },
                      { data: 'id',
                          'render':function( data, type, full, meta ){
                            var detail_url = "<?php echo site_url('admin/students/studentadd/'); ?>" + "?id=" + data;
                            return '<div class="btn-group"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Operate <span class="caret"></span> </button> <ul class="dropdown-menu"><li class="recover_student_class" data-order-id=' + data + ' data-order-name=' + full.name + ' data-toggle="modal" data-target="#modalTwo"><a href="#">Restore</a></li></ul></div>';
                          }
                      }
                   ],
          "order": [
                      [ 0, 'desc' ]
                   ]
        });
      dtTable_two.on( 'draw.dt', function () {
        init_base_modal();
      });

      dtTable_three =  jQuery('#all_students').DataTable({
          "initComplete": function( settings, json ) {
              init_base_modal();
            },
          ajax: {
                  type: 'POST',
                  url: "<?php echo site_url('admin/students/studentsList'); ?>",
                  dataSrc: 'items',
                  data: {
                      status:'-1'
                      },
                  // success:function(data){
                  //   console.log(data);
                  // }
          },
          "columns": [
                      { data:'id'},
                      { data:'account'},
                      { data: 'name'},
                      { data: 'headimgurl',
                        'render':function( data, type, full, meta ){
                          return '<img class="img" src="' + full.headimgurlfull + '">';
                        }
                      },
                      { data: 'email'},
                      { data: 'stream',
                        'render':function( data, type, full, meta ){
                            if( data == '1' ){
                              data = 'EEE Beng'
                            }else if( data == '2' ){
                              data = 'EIE Beng';
                            }else if( data == '3' ){
                              data = 'EEE Meng';
                            }else if( data == '4' ){
                              data = 'EIE Meng';
                            }else{
                              data = 'other';
                            }
                            return "<p style='color:red'>" + data + "</p>";
                        }
                      },
                      { data: 'status',
                          'render':function( data, type, full, meta ){
                              if( data == '1' ){
                                data = 'Active'
                              }else if( data == '0' ){
                                data = 'Deleted';
                              }else{
                                data = 'Others';
                              }
                              return "<p style='color:red'>" + data + "</p>";
                          }
                      },
                      { data: 'id',
                          'render':function( data, type, full, meta ){
                            var detail_url = "<?php echo site_url('admin/students/studentadd/'); ?>" + "?id=" + data;
                            return '<div class="btn-group"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Operate <span class="caret"></span> </button> <ul class="dropdown-menu"><li class="detail" data-order-id=' + data + ' data-order-name=' + full.title + '><a href="' + detail_url + '">Edit</a></li><li class="delete_student_class" data-order-id=' + data + ' data-order-name=' + full.name + ' data-toggle="modal" data-target="#modalOne"><a href="#">Delete</a></li></ul></div>';
                          }
                      }
                   ],
          "order": [
                      [ 0, 'desc' ]
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
    $('.delete_student_class').unbind().click(function(){
      var name = $(this).attr('data-order-name');
      var student_id = $(this).attr('data-order-id');
      $('#modalOne').find('.student_name').text(name);
      $('#modalOne').find('.hidden_student_id').val(student_id);
    });

    $('.recover_student_class').unbind().click(function(){
      var name = $(this).attr('data-order-name');
      var student_id = $(this).attr('data-order-id');
      $('#modalTwo').find('.student_name').text(name);
      $('#modalTwo').find('.hidden_student_id').val(student_id);
    });
  }

  function delete_student(){
    $('.btn_sure_delete').click(function(){
      var data = new Array();
      data['student_id'] = $('#modalOne').find('.hidden_student_id').val();
      delete_student_ajax( data );
    });
  }

  function recover_student(){
    $('.btn_sure_recover').click(function(){
      var data = new Array();
      data['student_id'] = $('#modalTwo').find('.hidden_student_id').val();
      recover_student_ajax( data );
    });
  }

  function delete_student_ajax( data ){
    var url = "<?php echo site_url('/') . 'admin/students/deleteStudent' ?>";
    $.ajax({
      url:url,
      type:'POST',
      data:{
        student_id:data['student_id'],
      },
      success:function(e){
        var obj = JSON.parse(e);
        if( obj.code == '0' ){
          alert('Update Succeeded');
          window.location.reload();
          // layer.alert(obj.msg,function(){
          //     window.location.reload();
          // });
        }else{
          alert('Update Failed');
          // layer.alert(obj.msg);
        }
      },
      error:function(e){
        alert(e.status);
        // layer.alert(e.status);
      }
    });
  }

  function recover_student_ajax( data ){
    var url = "<?php echo site_url('/') . 'admin/students/recoverStudent' ?>";
    $.ajax({
      url:url,
      type:'POST',
      data:{
        student_id:data['student_id'],
      },
      success:function(e){
        var obj = JSON.parse(e);
        if( obj.code == '0' ){
          alert('Update Succeeded');
          window.location.reload();
          // layer.alert(obj.msg,function(){
          //     window.location.reload();
          // });
        }else{
          alert('Update Failed');
          // layer.alert(obj.msg);
        }
      },
      error:function(e){
        alert(e.status);
        // layer.alert(e.status);
      }
    });
  }
</script>

<!-- 函数执行 -->
<script type="text/javascript">
  $(function(){
      delete_student();
      recover_student();
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

