@include('admin.include.head')
<body>
    <div class="wrapper">
        @include('admin.include.header')
        <!-- Sidebar -->
        @include('admin.include.sidebar')
        <!-- End Sidebar -->
        <div class="main-panel">
            <div class="page-header">
                <!-- <h4 class="page-title">Employee Management</h4> -->
            </div>
            <div class="content">
                <div class="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card custom-card">
                                <div class="card-header">
                                    @if(isset($user) && !empty($user->id))
                                    <h4 class="card-title"><i class="far fa-user"></i> Edit Hr Support File </h4>
                                    @else
                                    <h4 class="card-title"><i class="far fa-user"></i> Add Hr Support File </h4>
                                    @endif
                                    @include('layout/message')
                                </div>
                                <div class="card-body">
                                    <form action="{{ url('superadmin/add-hr-support-file') }}" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        @if(isset($user) && !empty($user->id))
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        @endif
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="selectFloatingLabel" class="placeholder">Type</label>
                                                    <select name="type_id" class="form-control" id="" required>
                                                        <option value="">Choose..</option>
                                                        @foreach ($type as $types)
                                                            <option value="{{ $types->id }}" @if(isset($user) && $user->type_id == $types->id) selected @endif>{{$types->type}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="selectFloatingLabel" class="placeholder">Title</label>
                                                    <input type="text" name="title" class="form-control input-border-bottom" id="selectFloatingLabel" required value="{{ isset($user) ? $user->title : '' }}">
                                                </div>
                                            </div>

                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="description" class="placeholder">Short Description</label>
                                                    <textarea id="description" name="description" class="form-control input-border-bottom" required>{{ isset($user) ? $user->small_description : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="description" class="placeholder">Long Description</label>
                                                    <textarea id="description" name="smalldescription" rows="30" class="form-control input-border-bottom" required>{{ isset($user) ? $user->description : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="status" class="placeholder">Upload Pdf</label>
                                                    <input type="file" class="form-control" name="pdf" accept=".pdf">
                                                    @if(isset($user) && $user->pdf)
                                                        <p>Current PDF: <a href="{{ asset('storage/app/public/hrsupport/pdf/' . $user->pdf) }}" target="_blank">{{ $user->pdf }}</a></p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="status" class="placeholder">Upload Doc</label>
                                                    <input type="file" class="form-control" name="doc" accept=".doc,.docx">
                                                    @if(isset($user) && $user->doc)
                                                         <p>Current DOC: <a href="{{ asset('storage/app/public/hrsupport/doc/' . $user->doc) }}" target="_blank">{{ $user->doc }}</a></p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="status" class="placeholder">Status</label>
                                                    <select id="status" name="status" class="form-control input-border-bottom" required>
                                                        <option value="active" {{ (isset($user) && $user->status == 'active') ? 'selected' : '' }}>Active</option>
                                                        <option value="inactive" {{ (isset($user) && $user->status == 'inactive') ? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-default">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.include.footer')
        </div>
    </div>
    <!--   Core JS Files   -->
    @include('admin.include.script')
    <script>
        CKEDITOR.replace('description');
        CKEDITOR.replace('smalldescription');
    </script>
</body>
</html>
