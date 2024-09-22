<!-- jQuery -->
<script src="{{ asset('frontend/assets/js/jquery-3.7.1.min.js') }}"></script>

<!-- Bootstrap Core JS -->
<script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- Slimscroll JS -->
<script src="{{ asset('frontend/assets/js/jquery.slimscroll.min.js') }}"></script>

<!-- Feather Icon JS -->
<script src="{{ asset('frontend/assets/js/feather.min.js')}}"></script>

<!-- Chart JS -->
<script src="{{ asset('frontend/assets/plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('frontend/assets/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/chart.js') }}"></script>
<script src="{{ asset('frontend/assets/js/greedynav.js') }}"></script>
<script src="{{ asset('frontend/assets/plugins/chartjs/chart.min.js')}}"></script>
<script src="{{ asset('frontend/assets/plugins/peity/jquery.peity.min.js')}}"></script>
<script src="{{ asset('frontend/assets/plugins/chartjs/chart-data.js')}}"></script>
<script src="{{ asset('frontend/assets/plugins/peity/chart-data.js')}}"></script>




<!-- Select2 JS -->
<script src="{{ asset('frontend/assets/js/select2.min.js') }}"></script>
		
<!-- Datetimepicker JS -->
<script src="{{ asset('frontend/assets/js/moment.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/bootstrap-datetimepicker.min.js') }}"></script>

<!-- Owl Carousel JS -->
<script src="{{ asset('frontend/assets/js/owl.carousel.min.js') }}"></script>

 <!-- Theme Settings JS -->
<script src="{{ asset('frontend/assets/js/layout.js') }}"></script>
<script src="{{ asset('frontend/assets/js/theme-settings.js') }}"></script>
<script src="{{ asset('frontend/assets/js/greedynav.js') }}"></script>

<!-- Datatable JS -->
<script src="{{ asset('frontend/assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/dataTables.bootstrap4.min.js') }}"></script>

<!-- Custom JS -->
<script src="{{ asset('frontend/assets/js/app.js') }}"></script>

<script>
  $(document).ready(function() {
    $('#basic-datatables').DataTable({
        "pageLength": 100, 
        "lengthMenu": [[100, 200, 500, -1], [100, 200, 500, "All"]], 
    });

});

    $('#exportForm').on('submit', function(e) {
        e.preventDefault();

        let tableData = [];
        let tableHeadings = [];
        let excludeColumnIndex = -1;
        let filename = $('#filenameInput').val();
        
        $('#basic-datatables thead th').each(function(index) {
            let headingText = $(this).text().trim().toLowerCase();
            if (headingText === 'action' || headingText === 'actions') {
                excludeColumnIndex = index;
            } else {
                tableHeadings.push($(this).text().trim());
            }
        });

        $('#basic-datatables tbody tr').each(function() {
            let row = [];
            $(this).find('td').each(function(index) {
                if (index !== excludeColumnIndex) {
                    let cellText;
                    if ($(this).find('span').length > 0) {
                        cellText = $(this).find('span').text().trim();
                    } else {
                        cellText = $(this).text().trim();
                    }
                    row.push(cellText);
                }
            });
            tableData.push(row);
        });

        $('#data').val(JSON.stringify(tableData));
        $('#headings').val(JSON.stringify(tableHeadings));

        let today = new Date().toISOString().split('T')[0];
        $('#filename').val(filename + '_' + today + '.xls');
        $(this).off('submit').submit();
    });




// export pdf coddeing


$('#exportPDFForm').on('submit', function(e) {
      e.preventDefault();

      let tableData = [];
      let tableHeadings = [];
      let excludeColumnIndex = -1;
      let filename = $('#filenameInput').val();
      
      $('#basic-datatables thead th').each(function(index) {
            let headingText = $(this).text().trim().toLowerCase();
            if (headingText === 'action' || headingText === 'actions') {
                excludeColumnIndex = index;
            } else {
                tableHeadings.push($(this).text().trim());
            }
        });

      $('#basic-datatables tbody tr').each(function() {
         let row = [];
         $(this).find('td').each(function(index) {
               if (index !== excludeColumnIndex) {
                  let cellText;
                  if ($(this).find('span').length > 0) {
                     cellText = $(this).find('span').text().trim();
                  } else {
                     cellText = $(this).text().trim();
                  }
                  row.push(cellText);
               }
         });
         tableData.push(row);
      });

      $('#pdfData').val(JSON.stringify(tableData));
      $('#pdfHeadings').val(JSON.stringify(tableHeadings));

      let today = new Date().toISOString().split('T')[0];
      $('#pdfFilename').val(filename + '_' + today + '.pdf');
      $(this).off('submit').submit();
   });


</script>