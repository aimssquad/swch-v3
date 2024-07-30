<!-- Left Panel -->
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="{{ url('task-management/dashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}" alt="" />Dashboard </a>
                </li>
                <!--<li class="menu-title">UI elements</li>--><!-- /.menu-title -->
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/module.png') }}" alt="" /> Project Management</a>
                    <ul class="sub-menu children dropdown-menu">

                        <li><a href="{{ url('task-management/'.request()->route('id').'/project-members') }}"><img src="{{ asset('images/hand.png') }}" alt="" /> Members</a></li>
                        <li><a href="{{ url('task-management/'.request()->route('id').'/tasks') }}"><img src="{{ asset('images/hand.png') }}" alt="" /> Tasks</a></li>
                    </ul>
                </li>



            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
<!-- /#left-panel -->