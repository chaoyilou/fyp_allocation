<style type="text/css">
  .btn_submit{
    margin-left: 62%;
    margin-top: 20px;
  }
  .form-group{
    margin-left: 25%;
    width: 50%;
  }
  .notice{
    display: inline-block;
    width: 100px;
  }
  .readonly_input{
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #eee;
    width: 64%;
    display: inline-block;
  }
  .memo_notice{
    vertical-align: top;
  }
  .memo{
    width: 64%;
  }
  .error{
    color: red;
    margin-bottom: 10px;
    padding-left: 100px;
  }
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Meeting Reservation</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <?php echo form_open('web/meetings/appointmentSubmission/'); ?>
        <div class="row">
            <div class="form-group">
                <p class="supervisor_notice notice">Supervisor Name：</p>
                <input type="input" class="readonly_input supervisor" readonly name="appointSupervisor" value="<?php echo $supervisorInfo['name']; ?>">
                <?php echo form_error('appointSupervisor', '<div class="error">', '</div>'); ?>
            </div>
            <div class="form-group">
                <p class="datetime_notice notice">Office：</p>
                <input type="input" class="readonly_input room" readonly name="appointRoom" value="<?php echo $supervisorInfo['room']; ?>">
                <?php echo form_error('appointRoom', '<div class="error">', '</div>'); ?>
            </div>
            <div class="form-group">
                <p class="datetime_notice notice">Meeting Preference：</p>
                <input type="input" class="readonly_input type" readonly name="appointType" value="<?php echo $supervisorInfo['appointment_preference']; ?>">
                <?php echo form_error('appointType', '<div class="error">', '</div>'); ?>
            </div>
            <div class="form-group">
                <p class="datetime_notice notice">Date：</p>
                <input type="date" class="date" min="<?php echo date( 'Y-m-d', time() ); ?>" name="appointDate">
                <?php echo form_error('appointDate', '<div class="error">', '</div>'); ?>
            </div>
            <div class="form-group">
                <p class="datetime_notice notice">Time：</p>
                <input type="time" class="time" name="appointTime">
                <?php echo form_error('appointTime', '<div class="error">', '</div>'); ?>
            </div>
            <div class="form-group">
                <p class="memo_notice notice">Comments：</p>
                <textarea class="memo" rows="5" name="appointMemo"></textarea>
            </div>
            <input type="hidden" name="hidden_supervisor_id" value="<?php echo $supervisorInfo['id']; ?>">
            <div class="form-group">
                <button type="submit" class="btn btn-info btn_submit">Submit</button>
            </div>
        </div>
    </form>
</div>