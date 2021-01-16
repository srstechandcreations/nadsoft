<form class="form-horizontal m-t-30" action='javascript:;' name="newMemberForm" id="newMemberForm"  method="post">
	<div class="modal-body">
			<div class="form-group">
				<label for="example-user-name">Parent</label>
				<select id="memparentid" name="memparentid" class="form-control">
					<option value="0">Select Parent</option>
					<?php if(!empty($memberData)):
							foreach($memberData as $memkey => $memvalue): ?>
								<option value="<?= $memvalue['id'] ?>"><?= $memvalue['name'] ?></option>
					<?php endforeach; endif; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="example-user-name">Name <span style="color:red">*</span></label>
				<input type="text" id="memname" name="memname" class="form-control" placeholder="Enter Name">
				<span id="memnamemsg" style="color:red" ></span>
			</div>

	</div>
	<div class="modal-footer">
	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  <input type="submit" class="btn btn-primary" onclick="addMember()" value="Save Changes"/>
	</div>
</form>