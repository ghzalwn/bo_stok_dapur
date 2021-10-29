@extends('template')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Product Category</h2>
            <ol class="breadcrumb">
                <li>
                    <a>Home</a>
                </li>
                <li>
                    <a>Manager</a>
                </li>
                <li class="active">
                    <strong>Product Category</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2"></div>
    </div>
    <div class="row" style="margin-top: 20px; padding-left:10px;">
        <button class="btn btn-primary show-modal-forms"><i class="fa fa-plus"></i>
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
                                        <th>Category</th>
                                        <th>Action</th>
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
                <form id="form-product-category" role="form" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="form-control" name="id">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Product Category</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group"><label>Category</label>
                            <input type="text" placeholder="Category" class="form-control" name="category">
                        </div>
                        <div class="form-group"><label> Icon</label>
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput">
                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                    <span class="fileinput-filename"></span>
                                </div>
                                <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">Select file</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="..." />
                                </span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists"
                                    data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary  btn-submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <!-- Jasny -->
    <script src="{{ URL::asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>

    <!-- DROPZONE -->
    <script src="{{ URL::asset('js/plugins/dropzone/dropzone.js') }}"></script>

    <!-- CodeMirror -->
    <script src="{{ URL::asset('js/plugins/codemirror/codemirror.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/codemirror/mode/xml/xml.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('.stok-dapur-datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/manager/product-category/list",
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
                        data: 'category',
                        name: 'category'
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

            $('.btn-submit').click(function(e) {
                e.preventDefault();
                let id = $('#form-product-category').find("[name='id']").val();
                let form = $('#form-product-category')[0]
                let formData = new FormData(form);

                $.ajax({
                    method: id == '' ? 'POST' : 'PUT',
                    url: id == '' ? "/manager/product-category/store" :
                        '/manager/product-category/update/' + id,
                    data: formData,
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
                    url: "/manager/product-category/edit/" + id,
                    cache: false,
                    success: function(response) {
                        const {
                            status,
                            message,
                            data
                        } = response;
                        if (status) {
                            $('#modal-form').find("[name='id']").val(data.id);
                            $('#modal-form').find("[name='status']").val(data.status);
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
                    url: "/manager/product-category/destroy/" + id,
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
