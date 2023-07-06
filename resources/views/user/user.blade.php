@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Data User</h6>
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
                            <table class="table table-flush" id="tbl_user">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Tanggal Lahir</th>
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
    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-add" aria-hidden="true">
        <form id="user" name="user" class="form-horizontal">
            @csrf
            <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modal-title-default">Tambah Data User</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12" id="form_error" style="display: none">
                                <div class="alert alert-danger" role="alert">
                                    <strong>Error!</strong>
                                    <ul id="error_list">
                                                    
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Nama User</label>
                                    <input type="hidden" id="user_id" name="user_id" value="">
                                    <input type="text" class="form-control" id="nama_user" name="nama_user" value="" placeholder="Nama User">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="" placeholder="Username">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="birthdate" name="birthdate" value="" placeholder="Tanggal Lahir">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" value="" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">Password Confirmation</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="" placeholder="Password Confirmation">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="action" name="action" value="create">
                        <button type="submit" class="btn btn-primary" id="submit_user" value="create">Submit</button>
                        <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#add_user').click(function () {
                $('#action').val("create");
                $('#user_id').val('');
                $('#user').trigger("reset");
                $('.modal-title').html("Tambah Data User");
                $('#form_error').hide();
                $('#modal-add').modal('show');
            });

            let tbl_user = $('#tbl_user').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data_user') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'name', name: 'name' },
                    { data: 'username', name: 'username' },
                    { data: 'email', name: 'email' },
                    { data: 'birth_date', name: 'birth_date' },
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

            $('#submit_user').click(function (e) {
                e.preventDefault();
                $(this).html('Saving Data..');
                
                $.ajax({
                    data: $('#user').serialize(),
                    url: "{{ route('data_user.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#user').trigger("reset");
                        $('#submit_user').html('Submit');
                        $('#modal-add').modal('hide');
                        $('.modal-title').html("Tambah Data User");
                        $('#user_id').val('');
                        tbl_user.ajax.reload(null, false);
                        
                        swal("Success", "Data Berhasil Disimpan", "success")
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#submit_user').html('Submit');
                        $('#error_list').html('');
                        $.each(data.responseJSON.errors, function(key, value){
                            $('#form_error').show();
                            $('#error_list').append('<li>'+value+'</li>');
                        });
                    }
                });
            });

            $('body').on('click', '.edit_user', function () {
                let user_id = $(this).data('id');
                $.get("{{ route('data_user') }}" +'/edit/' + user_id, function (data) {
                    $('.modal-title').html("Edit Data User");
                    $('#action').val("edit");
                    $('#modal-add').modal('show');
                    $('#form_error').hide();
                    // show data
                    $('#user_id').val(data.id);
                    $('#nama_user').val(data.name);
                    $('#username').val(data.username);
                    $('#email').val(data.email);
                    $('#birthdate').val(data.birth_date);
                })
            });

            $('body').on('click', '.delete_user', function () {
                let user_id = $(this).data('id');
                // confirm("Are You sure want to delete !");
                
                swal({
                    title: 'Apakah anda yakin?',
                    text: 'Data akan dihapus secara permanen',
                    icon: 'warning',
                    buttons: ["Cancel", "Yes!"],
                }).then(function(value) {
                    if (value) {
                        $.ajax({
                            url: "{{ route('data_user') }}" + '/delete/' + user_id,
                            success: function (data) {
                                tbl_user.ajax.reload(null, false);
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