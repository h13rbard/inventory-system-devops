<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
	
			<div class="col-md-6 col-lg-6 col-sm-6"><h1><?php echo lang('edit_user_heading');?></h1>
<p><?php echo lang('edit_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(uri_string());?>

      <p>
            <?php echo lang('edit_user_fname_label', 'first_name');?> <br />
            <?php echo form_input($first_name);?>
      </p>

      <p>
            <?php echo lang('edit_user_lname_label', 'last_name');?> <br />
            <?php echo form_input($last_name);?>
      </p>

      <p>
            <?php echo lang('edit_user_company_label', 'company');?> <br />
            <?php echo form_input($company);?>
      </p>

      <p>
            <?php echo lang('edit_user_phone_label', 'phone');?> <br />
            <?php echo form_input($phone);?>
      </p>

      <p>
            <?php echo lang('edit_user_password_label', 'password');?> <br />
            <?php echo form_input($password);?>
      </p>

      <p>
            <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?><br />
            <?php echo form_input($password_confirm);?>
      </p>

      <?php if ($this->ion_auth->is_admin()): ?>

          <p><?php echo lang('edit_user_groups_heading');?><br>
		<select name="groups[]" id="groups" class="form-control">
		<?php foreach($groups as $group) : ?>
<option value="<?php echo $group['id'];?>" <?=$currentGroups[0]->id==$group['id'] ? 'selected' : ''?>>
<?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8'); ?></option>
		<?php endforeach; ?>
		</select>
		</p>

      <?php endif ?>

      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?>

      <p><?php echo form_submit('submit', lang('edit_user_submit_btn'));?></p>

<?php echo form_close();?>
</div>

		</div>
	</div>
</section>
