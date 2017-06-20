<style type="text/css">
  .error{
    color: red;
    margin-bottom: 10px;
  }
  .form-group{
    width: 80%;
    margin-left: 10%;
  }
  .form-group-last{
    text-align: center;
  }
  .checkbox{
    display: inline-block;
  }
  .required_star{
    color: red;
  }
  .previews_img_div{
    width: 100px;
    height: 100px;
    display: inline-block;
    vertical-align: middle;
  }
  .previews_img{
    width:100%;
    height: 100%;
  }
  .photo{
    display: inline-block !important;
  }
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">

            <?php if( isset($_GET['id']) && !empty($_GET['id']) ): ?>
                <h1 class="page-header">Edit the Supervisor</h1>
            <?php else: ?>
                <h1 class="page-header">Add a New Supervisor</h1>
            <?php endif; ?>

        </div>
        <!-- /.col-lg-12 -->
    </div>

    <?php echo form_open_multipart('admin/supervisors/supervisorAddValidate'); ?>
        <div class="form-group has-success">
            <label>Supervisor Name</label><label class="required_star">*</label>
            <input type="text" class="form-control" name="name" placeholder="Please enter supervisor's name" value="<?php echo isset( $supervisorDetail['name'] )?$supervisorDetail['name']:set_value('name'); ?>">
            <?php echo form_error('name', '<div class="error">', '</div>'); ?>
        </div>
        <div class="form-group has-success">
            <label>Username</label><label class="required_star">*</label>
            <input type="text" class="form-control" name="account" placeholder="Please enter supervisor's username" value="<?php echo isset( $supervisorDetail['operatorInfo']['account'] )?$supervisorDetail['operatorInfo']['account']:set_value('account'); ?>">
            <?php echo form_error('account', '<div class="error">', '</div>'); ?>
        </div>
        <?php if( !isset( $supervisor_hidden_id ) && ( !isset( $_GET['id'] ) || empty( $_GET['id'] ) ) ): ?>
            <div class="form-group has-success">
                <label>Password</label><label class="required_star">*</label>
                <input type="password" class="form-control" name="password" placeholder="Please enter supervisor's password" value="<?php echo isset( $supervisorDetail['password'] )?$supervisorDetail['password']:set_value('password'); ?>">
                <?php echo form_error('password', '<div class="error">', '</div>'); ?>
            </div>
            <div class="form-group has-success">
                <label>Confirm Password</label><label class="required_star">*</label>
                <input type="password" class="form-control" name="password_confirm" placeholder="Please enter the password again" value="<?php echo isset( $supervisorDetail['password'] )?$supervisorDetail['password']:set_value('password'); ?>">
                <?php echo form_error('password_confirm', '<div class="error">', '</div>'); ?>
            </div>
        <?php endif; ?>
        <div class="form-group has-success">
            <label>Photo</label>
            <input type="file" name="headimgurl" accept="image/*" class="photo">
            <div class="previews_img_div"><img src="<?php echo isset( $supervisorDetail['headimgurl'] )?(base_url('uploads/supervisors/') . $supervisorDetail['headimgurl']):'';  ?>" class="previews_img"></div>
        </div>
        <div class="form-group has-success">
            <label>Email</label><label class="required_star">*</label>
            <input type="email" class="form-control" name="email" placeholder="Please enter supervisor's email address" value="<?php echo isset( $supervisorDetail['email'] )?$supervisorDetail['email']:set_value('email'); ?>">
            <?php echo form_error('email', '<div class="error">', '</div>'); ?>
        </div>
        <div class="form-group has-success">
            <label>Room</label><label class="required_star">*</label>
            <input type="text" class="form-control" name="room" placeholder="Please enter supervisor's office room" value="<?php echo isset( $supervisorDetail['room'] )?$supervisorDetail['room']:set_value('room'); ?>">
            <?php echo form_error('room', '<div class="error">', '</div>'); ?>
        </div>
        <div class="form-group has-success">
            <label>Homepage</label>
            <input type="text" class="form-control" name="homepage" placeholder="Please enter supervisor's homepage address" value="<?php echo isset( $supervisorDetail['homepage'] )?$supervisorDetail['homepage']:set_value('homepage'); ?>">
            <?php echo form_error('homepage', '<div class="error">', '</div>'); ?>
        </div>
        <div class="form-group has-success">
            <label>Meeting Preference</label><label class="required_star">*</label>
            <select class="form-control" name="appointment_preference">
                <?php if( isset( $supervisorDetail['appointment_preference'] ) ): ?>
                    <option value="<?php echo $supervisorDetail['appointment_preference']; ?>"><?php echo $supervisorDetail['appointment_preference']; ?></option>
                <?php endif; ?>
                <option value="1">individual meeting</option>
                <option value="2">group meeting</option>
                <option value="3">both</option>
            </select>
            <?php echo form_error('appointment_preference', '<div class="error">', '</div>'); ?>
        </div>
        <div class="form-group form-group-last">
            <?php if( (isset($_GET['id']) && !empty($_GET['id'])) || ( isset( $supervisor_hidden_id ) ) ): ?>
                <input type="hidden" name="id" value="<?php echo isset($_GET['id'])?$_GET['id']:$supervisor_hidden_id; ?>">
                <button type="submit" class="btn btn-default">Save Change</button>
            <?php else: ?>
                <button type="submit" class="btn btn-default">Submit</button>
                <button type="reset" class="btn btn-default">Default</button>
            <?php endif; ?>
        </div>
    </form>
</div>

<script type="text/javascript">
jQuery(function(){
    jQuery('.photo').change(function(){
        var file = this.files[0]; //选择上传的文件
        var reader = new FileReader();
        reader.onload = function(e) {
            jQuery('.previews_img_div').children('.previews_img').attr('src',this.result);
        };
        reader.readAsDataURL(file);
    });
});
</script>