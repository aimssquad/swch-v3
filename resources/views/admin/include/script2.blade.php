<script src="{{ asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{ asset('assets/js/core/popper.min.js')}}"></script>
	<script src="{{ asset('assets/js/core/bootstrap.min.js')}}"></script>

	<!-- jQuery UI -->
	<script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
	<!-- Datatables -->
	<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>
	<!-- Atlantis JS -->
	<script src="{{ asset('assets/js/atlantis.min.js')}}"></script>
	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{ asset('assets/js/setting-demo2.js')}}"></script>

	<script >
	$(document).ready(function() {
    // Initialize DataTable
    var table = $('#basic-datatables').DataTable({
        "drawCallback": function(settings) {
            console.log("DataTable drawCallback triggered");
            // Bind click event to the view-support-file class within the drawCallback
            $('.view-support-file').off('click').on('click', function() {
                var id = $(this).data('id');
                console.log("Clicked ID: " + id);
                // AJAX request to fetch HR Support File Type data by ID
                $.ajax({
                    url: '/hrms/superadmin/get-hr-support-file-type/' + id,
                    type: 'GET',
                    success: function(response) {
                        console.log("AJAX response: ", response);
                        // Update modal content with fetched data
                        $('#view-support-file-type').text(response.type);
                        $('#view-support-file-description').html(response.description); // Use .html() instead of .text()

                        // Show the modal
                        $('#viewSupportFileModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX error: ", error);
                    }
                });
            });
        }
    });

    // Initialize other DataTables
    $('#multi-filter-select').DataTable({
        "pageLength": 5,
        initComplete: function() {
            this.api().columns().every(function() {
                var column = this;
                var select = $('<select class="form-control"><option value=""></option></select>')
                    .appendTo($(column.footer()).empty())
                    .on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });

                column.data().unique().sort().each(function(d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
        }
    });

    $('#add-row').DataTable({
        "pageLength": 5,
    });
});

	</script>

