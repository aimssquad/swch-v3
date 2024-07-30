<div class="sidebar sidebar-style-2">
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img src="{{ asset('assets/img/profile.png')}}" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									Organisation Status

									<span class="caret"></span>
								</span>
							</a>
							<div class="clearfix"></div>

							<div class="collapse in" id="collapseExample">
								<ul class="nav">

									<li>
									 @if(Session::get('admin_userp_user_type')=='user')
										<a href="{{url('mainuesrLogout')}}">
										@else
										<a href="{{url('mainLogout')}}">
										    	@endif
											<span class="link-collapse">Logout</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<ul class="nav nav-primary">
						<li class="nav-item active">
							<a href="{{url('organisationdashboard')}}">
								<i class="fas fa-home"></i>
								<p>Dashboard</p>
								<span class="caret"></span>
							</a>

						</li>
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>

						</li>
						<?php
$email = Session::get('emp_email');
$ggRoledata = DB::table('registration')

    ->where('email', '=', $email)
    ->first();
$member = Session::get('admin_userpp_member');

$Roles_hhauth = DB::table('tareq_app')->where('ref_id', '=', $member)->where('emid', '=', $ggRoledata->reg)->first();

$Roles_auth = DB::table('role_authorization_admin_emp')->where('member_id', '=', $member)->get();
$arrrole = array();
foreach ($Roles_auth as $valrol) {
    $arrrole[] = $valrol->module_name;
}

$ggnewvisasta = DB::table('visa_apply')

    ->where('emid', '=', $ggRoledata->reg)
    ->where('employee_id', '=', $member)
    ->first();

?>
						<!--<li class="nav-item">
							<a href="company.php">
								<i class="fas fa-layer-group"></i>
								<p>Company</p>

							</a>

						</li>-->
							<?php
if (in_array('8', $arrrole)) {

    ?>
							<li class="nav-item">
							<a href="{{url('organisation-status/view-application')}}">
								<i class="fas fa-layer-group"></i>
								<p> Application Status</p>

							</a>

						</li>
							<?php
} else {
    ?>

				<?php
}
?>
						<?php

if (!empty($Roles_hhauth->invoice) && $Roles_hhauth->invoice == 'Yes') {
    ?>
						<li class="nav-item">
							<a href="{{url('organisation-status/view-reminder')}}">
								<i class="fas fa-layer-group"></i>
								<p> Invoice Reminder</p>

							</a>

						</li>
							<?php
} else {
    ?>


         <?php
}
?>

							<?php
if (in_array('2', $arrrole)) {

    ?>
							<li class="nav-item">
							<a href="{{url('organisation-status/view-hr')}}">
								<i class="fas fa-layer-group"></i>
								<p> HR File</p>

							</a>

						</li>
								<?php
} else {
    ?>


         <?php
}
?>

<?php
if (in_array('2', $arrrole)) {

    ?>
							<li class="nav-item">
							<a href="{{url('organisation-status/view-recruitment-file')}}">
								<i class="fas fa-layer-group"></i>
								<p> Recruitment File</p>

							</a>

						</li>
								<?php
} else {
    ?>


         <?php
}
?>

		<?php
if (in_array('2', $arrrole)) {

    ?>
							<li class="nav-item">
							<a href="{{url('organisation-status/view-cos')}}">
								<i class="fas fa-layer-group"></i>
								<p> Cos File</p>

							</a>

						</li>
								<?php
} else {
    ?>


         <?php
}
?>
		<?php
if (in_array('2', $arrrole)) {

    ?>
							<li class="nav-item">
							<a href="{{url('organisation-status/view-visa-file')}}">
								<i class="fas fa-layer-group"></i>
								<p> Visa File</p>

							</a>

						</li>
								<?php
} else {
    ?>


         <?php
}
?>

				<li class="nav-item">
							<a href="{{url('organisation-status/change-password')}}">
								<i class="fas fa-layer-group"></i>
								<p> Change Password</p>

							</a>

						</li>


					<?php if (!empty($ggnewvisasta)) {
    ?>
					    	<li class="nav-item">
							<a href="{{url('organisation-status/view-visa')}}">
								<i class="fas fa-layer-group"></i>
								<p> Visa File</p>

							</a>

						</li>

					    <?php
}?>
					</ul>
				</div>
			</div>
		</div>