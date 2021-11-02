@extends('template')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Change Password</h2>
            <ol class="breadcrumb">
                <li>
                    <a>Home</a>
                </li>
                <li>
                    <a>Manager</a>
                </li>
                <li class="active">
                    <strong>Change Password</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2"></div>
    </div>
    <div class="row wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Change Password</h5>
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
                        <div class="row">
                            <div class="col-sm-12">
                                <form id="form-change-password" role="form">
                                    <div class="form-group"><label>Password New</label>
                                        <input type="password" placeholder="Password Old" class="form-control"
                                            name="password_old">
                                    </div>
                                    <div class="form-group"><label>Password</label>
                                        <input type="password" placeholder="Password New" class="form-control"
                                            name="password_new">
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs btn-submit" type="button">
                                            <strong>Submit</strong>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
            $('.btn-submit').click(function() {
                const formSubmit = $('#form-change-password').serialize()
                $.ajax({
                    method: 'POST',
                    url: '/manager/user/submit-change-password'
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


        });
    </script>
@endsection
