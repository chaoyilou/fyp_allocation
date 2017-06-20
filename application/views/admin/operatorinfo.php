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
  .form-group-last{
    text-align: center;
  }
  .error{
    color: red;
    margin-bottom: 10px;
  }
</style>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Personal Information</h1>
        </div>
    </div>
    <div class="form-group has-success">
        <label>Account Name</label>
        <input class="form-control" readonly name="account" value="<?php echo $operatorDetail['account']; ?>">
    </div>
    <div class="form-group has-success">
        <label>Account Nickname</label>
        <input class="form-control" readonly name="account" value="<?php echo $operatorDetail['nickname']; ?>">
    </div>
    <div class="form-group has-success">
        <label>输入旧密码</label>
        <input type="password" class="form-control old_password" name="old_password" placeholder="请输入旧密码" value="">
    </div>
    <div class="form-group has-success">
        <label>新密码</label>
        <input type="password" class="form-control password" name="password" placeholder="请输入学生账号登陆密码" value="">
    </div>
    <div class="form-group has-success">
        <label>新密码确认</label>
        <input type="password" class="form-control password_confirm" name="password_confirm" placeholder="请再次输入登陆密码" value="">
    </div>
    <div class="form-group form-group-last">
        <button type="submit" class="btn btn-default">确认修改</button>
        <button type="reset" class="btn btn-default">重置</button>
    </div>
</div>

<script type="text/javascript">
  $(function(){
    $('.btn-default').click(function(){
      var old_password = $('.old_password').val();
      var password = $('.password').val();
      var password_confirm = $('.password_confirm').val();

      if( old_password == '' ){
        alert('旧密码不能为空');
        return false;
      }

      if( password == '' || password_confirm == '' ){
        alert('新密码不能为空');
        return false;
      }

      if( password != password_confirm ){
        alert('密码确认不一致');
        return false;
      }

      var url = '<?php echo site_url('admin/operators/passwordChange'); ?>';
      $.ajax({
        url:url,
        type:"POST",
        data:{
          old_password:old_password,
          password:password,
          password_confirm:password_confirm
        },
        success:function(e){
          console.log(e);
          var obj = JSON.parse(e);
          if( obj.code == '0' ){
              alert(obj.msg);
              window.location.href = '<?php echo site_url('admin/login'); ?>';
          }else{
            alert(obj.msg);
          }
        },
        error:function(e){
          alert(e.status);
        }
      })
    });
  });
</script>