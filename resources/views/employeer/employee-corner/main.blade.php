<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
    <head>
        <head>
            <title>@yield('title', 'Dashboard - HRMS admin template')</title>
            @include('employeer.layout.title-meta')
            @include('employeer.layout.head-css')
            @yield('css')
        </head>
		
		 
    </head>
    <body>
		<!-- Main Wrapper -->
        <div class="main-wrapper">
		
			@include('employeer.include.topbar')
			
			@include('employeer.employee-corner.sidebar')

            <!-- Page Wrapper -->
            <div class="page-wrapper">
                @yield('content')
            </div>
            <!-- /Page Wrapper -->
        </div>
		<!-- /Main Wrapper -->

		@include('employeer.layout.customizer')
		@include('employeer.layout.script')
        @yield('script')
		
    </body>
</html>


