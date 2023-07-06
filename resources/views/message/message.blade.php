@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Message</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        {{-- Put Content Here --}}
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="table-responsive py-4">
                            <table class="table table-flush" id="tbl_message">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Email</th>
                                        <th>Message</th>
                                        <th>Message Type</th>
                                        <th>File Type</th>
                                        <th>Energy Usage</th>
                                        <th>*</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Put Content Here --}}
    </div>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let tbl_message = $('#tbl_message').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('message') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'email', name: 'email' },
                    { data: 'message', name: 'message' },
                    { data: 'message_type', name: 'message_type' },
                    { data: 'file_type', name: 'file_type' },
                    { data: 'energy_usage', name: 'energy_usage' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                language: {
                    paginate: {
                        next: '<i class="fas fa-angle-right"></i>', // or '→'
                        previous: '<i class="fas fa-angle-left"></i>' // or '←' 
                    }
                }
                // columnDefs: [
                //     {
                //         targets: [4,10,11],  
                //         className: 'text-center',
                //     }
                // ],
            });

            $('body').on('click', '.delete_user', function () {
                let message_id = $(this).data('id');
                // confirm("Are You sure want to delete !");
                
                swal({
                    title: 'Apakah anda yakin?',
                    text: 'Data akan dihapus secara permanen',
                    icon: 'warning',
                    buttons: ["Cancel", "Yes!"],
                }).then(function(value) {
                    if (value) {
                        $.ajax({
                            url: "{{ route('message') }}" + '/delete/' + message_id,
                            success: function (data) {
                                tbl_message.ajax.reload(null, false);
                                swal("Success", "Data Berhasil Dihapus", "success")
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection