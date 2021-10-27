@extends('template')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Distict</h2>
            <ol class="breadcrumb">
                <li>
                    <a>Home</a>
                </li>
                <li>
                    <a>Manager</a>
                </li>
                <li class="active">
                    <strong>Distict</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2"></div>
    </div>
    <div class="row" style="margin-top: 20px; padding-left:10px;">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-form"><i class="fa fa-plus"></i>
            Add</button>
    </div>
    <div class="row wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover stok-dapur-datatable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>District</th>
                                        <th>CSS grade</th>
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
    </div>

    <div class="modal inmodal fade" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Distict</h4>
                </div>
                <div class="modal-body">
                    <form id="form-district" role="form">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="form-group"><label>Province</label>
                            <select class="form-control m-b" name="province_id">
                                <option value=""></option>
                                @foreach ($provinces as $prov)
                                    <option value="{{ $prov->id }}">{{ $prov->province }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group"><label>City</label>
                            <select class="form-control m-b" name="city_id">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group"><label>District Name</label>
                            <input type="text" placeholder="Name of Province" class="form-control" name="province">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-submit">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('.stok-dapur-datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/manager/district/list",
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [{
                        extend: 'copy'
                    },
                    {
                        extend: 'csv'
                    },
                    {
                        extend: 'excel',
                        title: 'ExampleFile'
                    },
                    {
                        extend: 'pdf',
                        title: 'ExampleFile'
                    },

                    {
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'district',
                        name: 'district'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });

            $(document).on('click', '.show-modal-forms', function() {
                $('#modal-form').modal('show');
            })

            $('.btn-submit').click(function() {
                let id = $('#form-district').find("[name='id']").val();
                const formSubmit = $('#form-district').serialize()
                $.ajax({
                    method: id == '' ? 'POST' : 'PUT',
                    url: id == '' ? "/manager/district/store" : '/manager/district/update/' + id,
                    data: formSubmit,
                    cache: false,
                    success: function(response) {
                        const {
                            status,
                            message
                        } = response;
                        if (status) {
                            swal({
                                title: "Message",
                                text: message,
                                type: "success"
                            });
                            table.ajax.reload();
                            $('#modal-form').modal('hide');
                        } else {
                            swal({
                                title: "Message",
                                text: message,
                                type: "warning"
                            });
                        }
                    }
                });
            });

            $(document).on('click', '#btn-edit', function() {
                let id = $(this).data('id');
                $.ajax({
                    method: 'GET',
                    url: "/manager/district/edit/" + id,
                    cache: false,
                    success: function(response) {
                        const {
                            status,
                            message,
                            data
                        } = response;
                        if (status) {
                            $('#modal-form').find("[name='id']").val(data.id);
                            $('#modal-form').find("[name='province_id']").val(data.province_id);
                            $('#modal-form').find("[name='city']").val(data.city);
                        } else {
                            swal({
                                title: "Message",
                                text: message,
                                type: "warning"
                            });
                        }
                    }
                });
                $('#modal-form').modal('show');
            });


            $(document).on('click', '#btn-delete', function() {
                let id = $(this).data('id');
                $.ajax({
                    method: 'DELETE',
                    url: "/manager/district/destroy/" + id,
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    cache: false,
                    success: function(response) {
                        const {
                            status,
                            message,
                            data
                        } = response;
                        if (status) {
                            swal({
                                title: "Message",
                                text: message,
                                type: "success"
                            });
                            table.ajax.reload();
                        } else {
                            swal({
                                title: "Message",
                                text: message,
                                type: "warning"
                            });
                        }
                    }
                });
            })
        });
    </script>
@endsection
