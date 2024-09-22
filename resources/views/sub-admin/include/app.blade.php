<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
    <head>
        <head>
            <title>@yield('title', 'Dashboard - HRMS admin template')</title>
            @include('sub-admin.layout.title-meta')
            @include('sub-admin.layout.head-css')
            @yield('css')
        </head>
		
		 
    </head>
    <body>
		<!-- Main Wrapper -->
        <div class="main-wrapper">
		
			@include('sub-admin.include.topbar')
			
			@include('sub-admin.include.sidebar')

            <!-- Page Wrapper -->
            <div class="page-wrapper">
                @yield('content')
            </div>
            <!-- /Page Wrapper -->
        </div>
		<!-- /Main Wrapper -->

		@include('sub-admin.layout.customizer')
		@include('sub-admin.layout.script')
        @yield('script')
		
    </body>
</html>


