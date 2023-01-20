@extends('app')

@section('content')
    <h1>Providers</h1>
    {{-- <a href="" class="btn btn-primary float-right my-2 add_new"><i class='fas fa-plus'></i> Add New</a> --}}

    <!-- Button trigger modal -->
   <button type="button" class="btn btn-primary float-right my-2 add_new">
        <i class='fas fa-plus'></i> Add New
    </button> 

      <table id="providers" class="table table-bordered table-hover display nowrap" style="width:100%">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">URL</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>

    {{-- Include add modal for Viewing --}}
    @include('provider.modal.view_modal')
    @include('provider.modal.view_image_modal')
@endsection

@push('scripts')
<script>
$(function() {

let table = $('#providers').DataTable({
  dom: 'Bfrtip',
  buttons: [
          'pageLength',
          'colvis'
      ],
      responsive: true,
      processing: true,
      serverSide: true,
      ajax: "{{ route('providers.list') }}",
      columns: [
          {data: 'DT_RowIndex', name: 'DT_RowIndex'},
          {data: 'name', name: 'name',  orderable: true},
          {data: 'url', name: 'url'},
          {
              data: 'action', 
              name: 'action', 
              orderable: true, 
              searchable: true
          },
      ]
  });

  // - Event for showing the Add Modal
  $(document).on('click','.add_new', function(e) {
        e.preventDefault();
        // global area id
        $('#pro_id').val('');
        // clear fields
        $('#providerModal').find('input').val('');
        // // show modal manually
        $('#providerModal').modal('show'); 
    });

    // - Save / Update Changes
    $(document).on('click','.save_changes',function(e) {
        e.preventDefault();
        // Data
        let pro_data = {
            'pro_id': $('#pro_id').val(),
            'name': $('#pro_name').val(),
            'url': $('#pro_url').val()
        };
        // Check if Add 
        if(pro_data.pro_id === "") {
            // 
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Proceed!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX
                    $.ajax({
                        type:"POST",
                        url:"http://127.0.0.1:8000/api/provider",
                        data: pro_data,
                        dataType: 'json',
                        success: function(response) {
                            // Show Success Message
                            Swal.fire(
                                'Saved!',
                                response.message,
                                'success'
                            )
                            // Refresh table
                            table.ajax.reload();
                         $('#providerModal').modal('hide');
                      },
                     error: function(response) {
                         // custom error validation
                         let err = jQuery.parseJSON(response.responseText);
                         // show each errors
                         let errResult = '';
                        // show each errors
                        $.each(err.errors, function(key, item){
                            // toastr.error(item).fadeOut(4000);
                            errResult += item + "\n";
                        });
                        // Show Error
                        Swal.fire({
                            icon: 'error',
                            title: 'Required Fields',
                            text: errResult,
                        })
                     }
                    });
                }
            })

        } else {
            // Edit State
            const pro_id = pro_data.pro_id;
            // Call AJAX API Request
            $.ajax({
                type:"PUT",
                url:"http://127.0.0.1:8000/api/provider/" + pro_id,
                data: pro_data,
                dataType: 'json',
                success: function(response) {
                    // Show Success Message
                    Swal.fire(
                        'Saved!',
                        response.message,
                        'success'
                    )
                    // Refresh table
                    table.ajax.reload();
                    $('#providerModal').modal('hide');
                },
                error: function(response) {
                    // custom error validation
                    let err = jQuery.parseJSON(response.responseText);
                    // show each errors
                    $.each(err.errors, function(key, item){
                        toastr.error(item).fadeOut(4000);
                    });
                }
            });

        }

    });

    // Edit Selected Record
    $(document).on('click','.edit_provider',function(e) {
        e.preventDefault();
        // 
        $('#providerModal').modal('show');
        // ID
        const pro_id = $(this).val();
        $('#pro_id').val(pro_id);
        // Call AJAX API Request
        $.ajax({
            type: "GET",
            url: "http://127.0.0.1:8000/api/provider/" + pro_id,
            dataType: "json",
            success: function (response) {
                let result = response.message;
                // Pass Value
                $('#pro_name').val(result.name);
                $('#pro_url').val(result.url);
            }
        });
    });

    // Delete Selected Record
    $(document).on('click','.delete_provider',function(e) {
        e.preventDefault();

        let provider_id = $(this).val();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                // Call AJAX API Request
                $.ajax({
                    type: "DELETE",
                    url: "http://127.0.0.1:8000/api/provider/" + provider_id,
                    dataType: "json",
                    success: function (response) {
                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        )
                    }
                });
                // Refresh data table
                table.ajax.reload();
            }
        })
    });

    // View Image
    $(document).on('click','.view_image',function(e) {
        e.preventDefault();
        let self = $(this).val();
        // Show image
        $('.stock_image').attr('src', self);
        // 
        $('#providerImageModal').modal('show');
    });


});
</script>
<script src="{{ asset('js/datatables/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('js/datatables/1.12.1/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/datatables/buttons/2.2.3/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/datatables/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ asset('js/datatables/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/datatables/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/datatables/buttons/2.2.3/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/datatables/buttons/2.2.3/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/datatables/buttons/2.2.3/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('js/datatables/responsive/2.2.9/js/dataTables.responsive.min.js') }}"></script>
@endpush

@push('css')
<!-- Datatable CSS assets -->
<link rel="stylesheet" href="{{ asset('js/datatables/buttons/2.2.3/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/datatables/1.12.1/css/jquery.dataTables.min.css') }}">
<!-- Responsive -->
<link href="{{asset('js/datatables/responsive/2.2.9/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<!-- toastrJS-->
<script type="text/javascript" src="{{ asset('js/jquery-1.11.3.min.js') }}"></script>
@endpush
