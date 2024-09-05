@extends('employeer.include.app')
@section('title', 'Add Folder')
@section('content')
<div class="content container-fluid pb-0">
    <div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title">Add Folder</h3>
			</div>
			<div class="col-auto float-end ms-auto">
				<a href="{{ url('fileManagment/fileManagment-add') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add File Division</a>
			</div>
		</div>
	</div>
    <div class="row">
        <div class="col-md-12">
            <div class="card custom-card">
                <div class="card-header">
                    <h4 class="card-title"><i class="far fa-folder" aria-hidden="true"
                            style="color:#10277f;"></i>&nbsp;Add Folder<span>
                    </h4>
                </div>
                <div class="card-body">
                    @foreach($file_image as $item)
                    <a href="{{url('fileManagment/file-add/'.$item->id)}}" class="mb-2"><img src="{{asset('filemanagment/folder.png')}}" style="width:50px; border-radius:10px">
                    <p><?php echo $item->folder_name ?> </p>
                       </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection