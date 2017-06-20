<style type="text/css">
  .col_form{
    float: none;
  }
  .btn_submit{
    margin-left: 32%;
  }
  .col_lg{
    float: none;
  }
  .col_lg_select{
    display: inline-block;
  }
  .select_title_one{
    margin-left: 1%;
  }
  .select_title_two{
    margin-left: 5.5%;
  }
  .error{
    color: red;
    margin-bottom: 10px;
    padding-left: 100px;
    display: inline-block;
  }
</style>

<div id="page-wrapper">
  <?php echo form_open('web/projects/selectionSubmission'); ?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Project Preference Entry Form</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <label class="select_title_one">Rank</label>
        <label class="select_title_two">Project (Title/PID/Supervisor)</label>
        <div class="error"><?php echo isset($repeat)?$repeat:''; ?></div>
        <?php for ($i=1; $i <= 10; $i++): ?>
            <?php echo form_error('project_rank_' . $i, '<div class="error">', '</div>'); ?>
        <?php endfor; ?>
        <!-- 总共十个选择框 -->
        <?php for ($i=1; $i <= 10; $i++): ?>
          <div>
            <div class="col-lg-1 col_lg col_lg_select" >
              <div class="form-group">
                  <select class="form-control" name="project_rank_<?php echo $i; ?>">
                    <option></option>
                    <!-- 如果有已选过的课题，在直接显示喜欢度选择在页面上 -->
                    <?php if( !empty( $projectsHadSelected[($i-1)] ) ): ?>
                      <option selected="selected" value="<?php echo $projectsHadSelected[($i-1)]['project_rank']; ?>"><?php echo $projectsHadSelected[($i-1)]['project_rank']; ?></option>
                    <?php else: ?>
                    <?php endif; ?>
                    <?php for ($k=1; $k <= 10; $k++): ?>
                      <option><?php echo $k ?></option>
                    <?php endfor; ?>
                  </select>
              </div>
            </div>
            <div class="col-lg-8 col_lg col_lg_select">
              <div class="form-group">
                  <select class="form-control" name="project_<?php echo $i; ?>">
                    <option></option>
                    <!-- 如果有已选过的课题，在直接显示课程选择在页面上 -->
                    <?php if( !empty( $projectsHadSelected[($i-1)] ) ): ?>
                      <option selected="selected" value="<?php echo $projectsHadSelected[($i-1)]['projectInfo']['id']; ?>"><?php echo ( $projectsHadSelected[($i-1)]['projectInfo']['title'] . '/' . $projectsHadSelected[($i-1)]['projectInfo']['PID'] . '/' . $projectsHadSelected[($i-1)]['supervisorInfo']['name'] ); ?></option>
                    <?php else: ?>
                    <?php endif; ?>
                    <?php foreach ($projectsAll as $key => $value):?>
                      <option value="<?php echo $value['id']; ?>"><?php echo ( $value['title'] . '/' . $value['PID'] . '/' . $value['supervisor']['name'] ); ?></option>
                  <?php endforeach; ?>
                  </select>
              </div>
            </div>
          </div>
        <?php endfor; ?>

        <div class="col-lg-9 col_lg col_form">
          <div class="form-group">
              <label>Comments</label>
              <textarea class="form-control" rows="4"></textarea>
          </div>
        </div>

        <button type="submit" class="btn btn-info btn_submit">Save Change</button>
    </div>
  </form>
</div>