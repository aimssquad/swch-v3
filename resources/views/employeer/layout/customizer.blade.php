<div class="settings-icon">
    <span data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas"><i class="las la-cog"></i></span>
</div>
<div class="offcanvas offcanvas-end border-0 " tabindex="-1" id="theme-settings-offcanvas">
    <div class="sidebar-headerset">
        <div class="sidebar-headersets">
            <h2>Customizer</h2>
            <h3>Customize your overview Page layout</h3>
        </div>
        <div class="sidebar-headerclose">
            <a data-bs-dismiss="offcanvas" aria-label="Close"><img src="{{asset('frontend/assets/img/close.png')}}" alt="Close Icon"></a>
        </div>
    </div>
    <div class="offcanvas-body p-0">
        <div data-simplebar class="h-100">
            <div class="settings-mains">
                <div class="layout-head">
                    <h5>Layout</h5>
                    <h6>Choose your layout</h6>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-check card-radio p-0">
                            <input id="customizer-layout01" name="data-layout" type="radio" value="vertical" class="form-check-input">
                            <label class="form-check-label avatar-md w-100" for="customizer-layout01">
                                <img src="{{asset('frontend/assets/img/vertical.png')}}" alt="Layout Image">
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Vertical</h5>
                    </div>
                    <div class="col-4">
                        <div class="form-check card-radio p-0">
                        <input id="customizer-layout02" name="data-layout" type="radio" value="horizontal" class="form-check-input">
                            <label class="form-check-label  avatar-md w-100" for="customizer-layout02">
                                <img src="{{asset('frontend/assets/img/horizontal.png')}}" alt="Layout Image">
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Horizontal</h5>
                    </div>
                    <div class="col-4">
                        <div class="form-check card-radio p-0">
                            <input id="customizer-layout03" name="data-layout" type="radio" value="twocolumn" class="form-check-input">
                            <label class="form-check-label  avatar-md w-100" for="customizer-layout03">
                                <img src="{{asset('frontend/assets/img/two-col.png')}}" alt="Layout Image">
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Two Column</h5>
                        </div>
                    </div>
                    <div class="layout-head pt-3">
                        <h5>Color Scheme</h5>
                        <h6>Choose Light or Dark Scheme.</h6>
                    </div>
                    <div class="colorscheme-cardradio">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-check card-radio p-0">
                                    <input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-orange" value="orange">
                                    <label class="form-check-label  avatar-md w-100 " for="layout-mode-orange">
                                        <img src="{{asset('frontend/assets/img/vertical.png')}}" alt="Layout Image">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Orange</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check card-radio p-0">
                                <input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-light" value="light">
                                <label class="form-check-label  avatar-md w-100" for="layout-mode-light">
                                    <img src="{{asset('frontend/assets/img/vertical.png')}}" alt="Layout Image">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Light</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check card-radio dark  p-0 ">
                                <input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-dark" value="dark">
                                <label class="form-check-label avatar-md w-100 " for="layout-mode-dark">
                                    <img src="{{asset('frontend/assets/img/vertical.png')}}" alt="Layout Image">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Dark</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check card-radio blue  p-0 ">
                                <input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-blue" value="blue">
                                <label class="form-check-label  avatar-md w-100" for="layout-mode-blue">
                                    <img src="{{asset('frontend/assets/img/vertical.png')}}" alt="Layout Image">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Blue</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check card-radio maroon p-0">
                                <input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-maroon" value="maroon">
                                <label class="form-check-label  avatar-md w-100 " for="layout-mode-maroon">
                                    <img src="{{asset('frontend/assets/img/vertical.png')}}" alt="Layout Image">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Maroon</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check card-radio purple p-0">
                                <input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-purple" value="purple">
                                <label class="form-check-label  avatar-md w-100 " for="layout-mode-purple">
                                    <img src="{{asset('frontend/assets/img/vertical.png')}}" alt="Layout Image">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Purple</h5>
                        </div>
                    </div>
                </div>
                <div id="layout-width">
                    <div class="layout-head pt-3">
                        <h5>Layout Width</h5>
                        <h6>Choose Fluid or Boxed layout.</h6>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-check card-radio p-0">
                                <input class="form-check-input" type="radio" name="data-layout-width" id="layout-width-fluid" value="fluid">
                                <label class="form-check-label avatar-md w-100" for="layout-width-fluid">
                                    <img src="{{asset('frontend/assets/img/vertical.png')}}" alt="Layout Image">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Fluid</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check card-radio p-0 ">
                                <input class="form-check-input" type="radio" name="data-layout-width" id="layout-width-boxed" value="boxed">
                                <label class="form-check-label avatar-md w-100 px-2" for="layout-width-boxed">
                                    <img src="{{asset('frontend/assets/img/boxed.png')}}" alt="Layout Image">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Boxed</h5>
                        </div>
                    </div>
                </div>
                <div id="layout-position">
                    <div class="layout-head pt-3">
                        <h5>Layout Position</h5>
                        <h6>Choose Fixed or Scrollable Layout Position.</h6>
                    </div>
                    <div class="btn-group bor-rad-50 overflow-hidden radio" role="group">
                        <input type="radio" class="btn-check" name="data-layout-position" id="layout-position-fixed" value="fixed">
                        <label class="btn btn-light w-sm" for="layout-position-fixed">Fixed</label>

                        <input type="radio" class="btn-check" name="data-layout-position" id="layout-position-scrollable" value="scrollable">
                        <label class="btn btn-light w-sm ms-0" for="layout-position-scrollable">Scrollable</label>
                    </div>
                </div>
                <div class="layout-head pt-3">
                    <h5>Topbar Color</h5>
                    <h6>Choose Light or Dark Topbar Color.</h6>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-check card-radio  p-0">
                            <input class="form-check-input" type="radio" name="data-topbar" id="topbar-color-light" value="light">
                            <label class="form-check-label avatar-md w-100" for="topbar-color-light">
                                <img src="{{asset('frontend/assets/img/vertical.png')}}" alt="Layout Image">
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Light</h5>
                    </div>
                    <div class="col-4">
                        <div class="form-check card-radio p-0">
                            <input class="form-check-input" type="radio" name="data-topbar" id="topbar-color-dark" value="dark">
                            <label class="form-check-label  avatar-md w-100" for="topbar-color-dark">
                                <img src="{{asset('frontend/assets/img/dark.png')}}" alt="Layout Image">
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Dark</h5>
                    </div>
                </div>
                <div id="sidebar-size">
                    <div class="layout-head pt-3">
                        <h5>Sidebar Size</h5>
                        <h6>Choose a size of Sidebar.</h6>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio  p-0 ">
                                <input class="form-check-input" type="radio" name="data-sidebar-size" id="sidebar-size-default" value="lg" >
                                <label class="form-check-label avatar-md w-100" for="sidebar-size-default">
                                    <img src="{{asset('frontend/assets/img/vertical.png')}}" alt="Layout Image">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Default</h5>
                        </div>

                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio p-0">
                                <input class="form-check-input" type="radio" name="data-sidebar-size" id="sidebar-size-compact" value="md">
                                <label class="form-check-label  avatar-md w-100" for="sidebar-size-compact">
                                    <img src="{{asset('frontend/assets/img/compact.png')}}" alt="Layout Image">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Compact</h5>
                        </div>

                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio p-0 ">
                                <input class="form-check-input" type="radio" name="data-sidebar-size" id="sidebar-size-small-hover" value="sm-hover" >
                                <label class="form-check-label avatar-md w-100" for="sidebar-size-small-hover">
                                    <img src="{{asset('frontend/assets/img/small-hover.png')}}" alt="Layout Image">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Small Hover View</h5>
                        </div>
                    </div>
                </div>

                <div id="sidebar-view">
                    <div class="layout-head pt-3">
                        <h5>Sidebar View</h5>
                        <h6>Choose Default or Detached Sidebar view.</h6>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio  p-0">
                                <input class="form-check-input" type="radio" name="data-layout-style" id="sidebar-view-default" value="default">
                                <label class="form-check-label avatar-md w-100" for="sidebar-view-default">
                                    <img src="{{asset('frontend/assets/img/compact.png')}}" alt="Layout Image">
                                </label>
                                </div>
                            <h5 class="fs-13 text-center mt-2">Default</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio p-0">
                                <input class="form-check-input" type="radio" name="data-layout-style" id="sidebar-view-detached" value="detached">
                                <label class="form-check-label  avatar-md w-100" for="sidebar-view-detached">
                                    <img src="{{asset('frontend/assets/img/detached.png')}}" alt="Layout Image">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Detached</h5>
                        </div>
                    </div>
                </div>
                <div id="sidebar-color">
                    <div class="layout-head pt-3">
                        <h5>Sidebar Color</h5>
                        <h6>Choose a color of Sidebar.</h6>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio p-0" data-bs-toggle="collapse" data-bs-target="#collapseBgGradient.show">
                                <input class="form-check-input" type="radio" name="data-sidebar" id="sidebar-color-light" value="light">
                                <label class="form-check-label  avatar-md w-100" for="sidebar-color-light">
                                    <span class="bg-light bg-sidebarcolor"></span>
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Light</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio p-0" data-bs-toggle="collapse" data-bs-target="#collapseBgGradient.show">
                                <input class="form-check-input" type="radio" name="data-sidebar" id="sidebar-color-dark" value="dark">
                                <label class="form-check-label  avatar-md w-100" for="sidebar-color-dark">
                                    <span class="bg-darks bg-sidebarcolor"></span>
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Dark</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio p-0">
                                <input class="form-check-input" type="radio" name="data-sidebar" id="sidebar-color-gradient" value="gradient">
                                <label class="form-check-label avatar-md w-100" for="sidebar-color-gradient">
                                    <span class="bg-gradients bg-sidebarcolor"></span>
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Gradient</h5>
                        </div>
                        <div class="col-4 d-none">
                            <button class="btn btn-link avatar-md w-100 p-0 overflow-hidden border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBgGradient" aria-expanded="false">
                                <span class="d-flex gap-1 h-100">
                                    <span class="flex-shrink-0">
                                        <span class="bg-vertical-gradient d-flex h-100 flex-column gap-1 p-1">
                                            <span class="d-block p-1 px-2 bg-soft-light rounded mb-2"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
                                            </span>
                                        </span>
                                        <span class="flex-grow-1">
                                            <span class="d-flex h-100 flex-column">
                                                <span class="bg-light d-block p-1"></span>
                                                <span class="bg-light d-block p-1 mt-auto"></span>
                                            </span>
                                        </span>
                                    </span>
                                </button>
                                <h5 class="fs-13 text-center mt-2">Gradient</h5>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <div class="offcanvas-footer border-top p-3 text-center">
        <div class="row">
            <div class="col-6">
                <button type="button" class="btn btn-light w-100 bor-rad-50" id="reset-layout">Reset</button>
            </div>
            <div class="col-6">
                <a href="https://themeforest.net/item/smarthr-bootstrap-admin-panel-template/21153150" target="_blank" class="btn btn-primary w-100 bor-rad-50">Buy Now</a>
            </div>
        </div>
    </div>
</div>
