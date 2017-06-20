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
                <h1 class="page-header">Edit the Student</h1>
            <?php else: ?>
                <h1 class="page-header">Add a New Student</h1>
            <?php endif; ?>

        </div>
        <!-- /.col-lg-12 -->
    </div>

    <?php echo form_open_multipart('admin/students/studentAddValidate'); ?>
        <div class="form-group has-success">
            <label>Student Name</label><label class="required_star">*</label>
            <input type="text" class="form-control" name="name" placeholder="Please enter student's name" value="<?php echo isset( $studentDetail['name'] )?$studentDetail['name']:set_value('name'); ?>">
            <?php echo form_error('name', '<div class="error">', '</div>'); ?>
        </div>
        <div class="form-group has-success">
            <label>Username</label><label class="required_star">*</label>
            <input type="text" class="form-control" name="account" placeholder="Please enter student's username" value="<?php echo isset( $studentDetail['account'] )?$studentDetail['account']:set_value('account'); ?>">
            <?php echo form_error('account', '<div class="error">', '</div>'); ?>
        </div>
        <?php if( !isset( $student_hidden_id ) && ( !isset( $_GET['id'] ) || empty( $_GET['id'] ) ) ): ?>
            <div class="form-group has-success">
                <label>Password</label><label class="required_star">*</label>
                <input type="password" class="form-control" name="password" placeholder="Please enter student's password" value="<?php echo isset( $studentDetail['password'] )?$studentDetail['password']:set_value('password'); ?>">
                <?php echo form_error('password', '<div class="error">', '</div>'); ?>
            </div>
            <div class="form-group has-success">
                <label>Confirm Password</label><label class="required_star">*</label>
                <input type="password" class="form-control" name="password_confirm" placeholder="Please enter the password again" value="<?php echo isset( $studentDetail['password'] )?$studentDetail['password']:set_value('password'); ?>">
                <?php echo form_error('password_confirm', '<div class="error">', '</div>'); ?>
            </div>
        <?php endif; ?>
        <div class="form-group has-success">
            <label>Photo</label>
            <input type="file" name="headimgurl" accept="image/*" class="photo">
            <div class="previews_img_div"><img src="<?php echo isset( $studentDetail['headimgurl'] )?(base_url('uploads/supervisors/') . $studentDetail['headimgurl']):'';  ?>" class="previews_img"></div>
        </div>
        <div class="form-group has-success">
            <label>Email</label><label class="required_star">*</label>
            <input type="email" class="form-control" name="email" placeholder="Please enter student's email address" value="<?php echo isset( $studentDetail['email'] )?$studentDetail['email']:set_value('email'); ?>">
            <?php echo form_error('email', '<div class="error">', '</div>'); ?>
        </div>
        <div class="form-group has-success">
            <label>Stream</label><label class="required_star">*</label>
            <select class="form-control" name="stream">
                <?php if( isset( $studentDetail['stream'] ) ): ?>
                    <option value="<?php echo $studentDetail['stream']; ?>"><?php echo $studentDetail['stream']; ?></option>
                <?php endif; ?>
                <option value="1">EEE Beng</option>
                <option value="2">EIE Beng</option>
                <option value="3">EEE Meng</option>
                <option value="4">EIE Meng</option>
            </select>
            <?php echo form_error('stream', '<div class="error">', '</div>'); ?>
        </div>
        <div class="form-group has-success">
            <label>Comments</label>
            <textarea class="form-control" rows="3" name="memo"><?php echo isset( $studentDetail['memo'] )?$studentDetail['memo']:set_value('memo'); ?></textarea>
        </div>
        <div class="form-group form-group-last">
            <?php if( isset($_GET['id']) && !empty($_GET['id']) || isset( $student_hidden_id ) ): ?>
                <input type="hidden" name="id" value="<?php echo isset($_GET['id'])?$_GET['id']:$student_hidden_id; ?>">
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