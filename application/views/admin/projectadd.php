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
  .difficulty_label{
    display: block;
  }
  .difficulty{
    display: inline-block;
    width: 40%;
  }
  .required_star{
    color: red;
  }
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">

            <?php if( isset($_GET['id']) && !empty($_GET['id']) ): ?>
                <h1 class="page-header">Edit the Project</h1>
            <?php else: ?>
                <h1 class="page-header">Upload a New Project</h1>
            <?php endif; ?>

        </div>
        <!-- /.col-lg-12 -->
    </div>

    <?php echo form_open('admin/projects/projectAddValidate'); ?>
        <div class="form-group has-success">
            <label>Supervisor Name</label><label class="required_star">*</label>
            <select class="form-control" name="supervisor_id">
                <?php if( isset( $projectDetail['supervisorDetail'] ) ): ?>
                    <option value="<?php echo $projectDetail['supervisorDetail']['id']; ?>"><?php echo $projectDetail['supervisorDetail']['name']; ?></option>
                <?php endif; ?>
                <?php foreach ($supervisors as $key => $supervisor): ?>
                    <option value="<?php echo $supervisor['id']; ?>"><?php echo $supervisor['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <?php echo form_error('supervisor_id', '<div class="error">', '</div>'); ?>
        </div>
        <div class="form-group has-success">
            <label>Project ID (PID)</label><label class="required_star">*</label>
            <input class="form-control" readonly name="PID" value="<?php echo $projectDetail['PID']; ?>">
            <?php echo form_error('PID', '<div class="error">', '</div>'); ?>
        </div>
        <div class="form-group has-success">
            <label>Project Title</label><label class="required_star">*</label>
            <input type="text" class="form-control" name="title" placeholder="Please enter Project Title" value="<?php echo isset( $projectDetail['title'] )?$projectDetail['title']:set_value('title'); ?>">
            <?php echo form_error('title', '<div class="error">', '</div>'); ?>
        </div>
        <div class="form-group has-success">
            <label>Project Description</label><label class="required_star">*</label>
            <textarea class="form-control" rows="3" name="desc" placeholder="Please enter Project Description"><?php echo isset( $projectDetail['desc'] )?$projectDetail['desc']:set_value('desc'); ?></textarea>
            <?php echo form_error('desc', '<div class="error">', '</div>'); ?>
        </div>
        <div class="form-group has-error">
            <label>Required Abilities</label>
            <textarea class="form-control" rows="3" name="required_ability" placeholder="Please enter Required Abilities"><?php echo isset( $projectDetail['required_ability'] )?$projectDetail['required_ability']:set_value('required_ability'); ?></textarea>
            <?php echo form_error('required_ability', '<div class="error">', '</div>'); ?>
        </div>
        <div class="form-group">
            <label>Stream</label><label class="required_star">*</label>
            <div class="checkbox">
                <label>
                    <input <?php if( in_array('1', isset( $projectDetail['stream'] ) ? $projectDetail['stream']:array() ) ) echo 'checked'; ?> type="checkbox" name="stream[]" value="1" >EEE Beng
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input <?php if( in_array('2', isset( $projectDetail['stream'] )?$projectDetail['stream']:array() ) ) echo 'checked'; ?> type="checkbox" name="stream[]" value="2">EIE Beng
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input <?php if( in_array('3', isset( $projectDetail['stream'] )?$projectDetail['stream']:array() ) ) echo 'checked'; ?> type="checkbox" name="stream[]" value="3">EEE Meng
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input <?php if( in_array('4', isset( $projectDetail['stream'] )?$projectDetail['stream']:array() ) ) echo 'checked'; ?> type="checkbox" name="stream[]" value="4">EIE Meng
                </label>
            </div>
            <?php echo form_error('stream[]', '<div class="error">', '</div>'); ?>
        </div>
        <div class="form-group has-error">
            <label class="difficulty_label">Possible Range (Difficulty)<label class="required_star">*</label></label>
            <input type="number" class="form-control difficulty difficulty_min" name="difficulty_min" placeholder="Please enter approximate Lowest Mark" value="<?php echo isset( $projectDetail['difficulty_min'] )?$projectDetail['difficulty_min']:set_value('difficulty_min'); ?>">
            <label>To</label>
            <?php echo form_error('difficulty', '<div class="error">', '</div>'); ?>
            <input type="number" class="form-control difficulty difficulty_max" name="difficulty_max" placeholder="Please enter approximate Highest Mark" value="<?php echo isset( $projectDetail['difficulty_max'] )?$projectDetail['difficulty_max']:set_value('difficulty_max'); ?>">
            <?php echo form_error('difficulty_max', '<div class="error">', '</div>'); ?>
        </div>

        <div class="form-group form-group-last">
            <?php if( isset($_GET['id']) && !empty($_GET['id']) || isset( $project_hidden_id ) ): ?>
                <input type="hidden" name="id" value="<?php echo isset($_GET['id'])?$_GET['id']:$project_hidden_id; ?>">
                <button type="submit" class="btn btn-default">Save Change</button>
            <?php else: ?>
                <button type="submit" class="btn btn-default">Submit</button>
                <button type="reset" class="btn btn-default">Default</button>
            <?php endif; ?>
        </div>
    </form>
</div>

