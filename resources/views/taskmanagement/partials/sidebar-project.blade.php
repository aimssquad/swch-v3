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

                            Task Management

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
            </div><?php

                    use App\Models\TaskManagement\ProjectMembers;
                    use App\User;

                    $usetype = Session::get('user_type');
                    $project_id = decrypt(request()->route('id'));

                    if ($usetype == 'employee') {
                        $usemail = Session::get('user_email');
                        $users_id = Session::get('users_id');
                        $dtaem = DB::table('users')

                            ->where('id', '=', $users_id)
                            ->first();
                        $Roles_auth = DB::table('role_authorization')
                            ->where('emid', '=', $dtaem->emid)

                            ->where('member_id', '=', $dtaem->email)
                            ->get()->toArray();
                        $arrrole = array();
                        foreach ($Roles_auth as $valrol) {
                            $arrrole[] = $valrol->menu;
                        }
                    }


                    ?>
            <ul class="nav nav-primary">
                <li class="nav-item active">
                    <a href="{{url('task-management/dashboard')}}">
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
                <!--<li class="nav-item">
							<a href="company.php">
								<i class="fas fa-layer-group"></i>
								<p>Company</p>
								
							</a>
							
						</li>-->
                <li class="nav-item">
                    <a data-toggle="collapse" href="#sidebarLayouts">
                        <i class="fas fa-user"></i>
                        <p>Project Management </p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="sidebarLayouts">
                        <ul class="nav nav-collapse">
                            <?php
                            // echo $usetype;
                            // die;
                            if ($usetype == 'employee') {
                                // if (in_array('67', $arrrole)) {

                                $currentEmpDetails = User::select('users.*', 'e.id as emp_id')
                                    ->leftJoin('employee as e', 'e.emp_code', '=', 'users.employee_id')
                                    ->where('users.id', $users_id)->first();
                                $currentMember =  ProjectMembers::where(['project_id' => $project_id, 'user_id' => $currentEmpDetails->emp_id])->first();
                                // print_r($currentEmpDetails);
                                // die;
                                if (strtolower($currentMember->role) == 'manager' || strtolower($currentMember->role) == 'owner') {
                            ?> <li>
                                        <a href="{{ url('task-management/'.request()->route('id').'/project-members') }}">
                                            <span class="sub-item">Members</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('task-management/'.request()->route('id').'/tasks')}}">
                                            <span class="sub-item">Tasks</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('task-management/'.request()->route('id').'/labels')}}">
                                            <span class="sub-item">Master Labels</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('task-management/'.request()->route('id').'/roles')}}">
                                            <span class="sub-item">Master Roles</span>
                                        </a>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <!-- <li>
                                        <a href="{{ url('task-management/'.request()->route('id').'/project-members') }}">
                                            <span class="sub-item">Members</span>
                                        </a>
                                    </li> -->
                                    <li>
                                        <a href="{{ url('task-management/'.request()->route('id').'/tasks')}}">
                                            <span class="sub-item">Tasks</span>
                                        </a>
                                    </li>

                                <?php
                                }
                                ?>

                            <?php
                            } else {
                            ?>
                                <li>
                                    <a href="{{ url('task-management/'.request()->route('id').'/project-members') }}">
                                        <span class="sub-item">Members</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('task-management/'.request()->route('id').'/tasks')}}">
                                        <span class="sub-item">Tasks</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('task-management/'.request()->route('id').'/labels')}}">
                                        <span class="sub-item">Master Labels</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('task-management/'.request()->route('id').'/roles')}}">
                                        <span class="sub-item">Master Roles</span>
                                    </a>
                                </li>

                            <?php
                            }

                            ?>




                        </ul>
                    </div>
                </li>







            </ul>
        </div>
    </div>
</div>