@extends('layout.default')
@push('after-style')
    @foreach ($cssFiles as $file)
        <link rel="stylesheet" href="{{ $file }}">
    @endforeach
@endpush
@section('content')

    <section class="section dashboard">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header mt-2 flex-wrap d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">Menu Role Access</h4>
                            <p class="m-0 subtitle">Setting Permission</p>
                        </div>
                        <ul class="nav nav-pills justify-content-end mb-4">
                            <li class=" nav-item">
                                <a href="#navpills2-1" class="nav-link active permission-btn" data-bs-toggle="tab" aria-expanded="false">Permission Menu</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="#navpills2-2" class="nav-link jsondata-btn" data-bs-toggle="tab" aria-expanded="false">Permission JSON data</a>
                            </li> --}}
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div id="navpills2-1" class="tab-pane active">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="table-list" class="datatables">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Header Name</th>
                                                        <th>Menu Name</th>
                                                        <th>URL</th>
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
                            <div id="navpills2-2" class="tab-pane">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="table-list-json" class="datatables">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>URL</th>
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
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-data" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header headermodal">
                        <h5 class="modal-title">Setting Menu Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form p-1">
                            <form id="base-form">
                                {{-- <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input id="form-name" type="text" class="form-control" placeholder="Name">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input id="form-email" type="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Password</label>
                                    <div class="col-sm-9">
                                        <input id="form-password" type="password" class="form-control" placeholder="Password">
                                    </div>
                                </div>
                                <fieldset class="mb-3">
                                    <div class="row">
                                        <label class="col-form-label col-sm-3 pt-0">Status</label>
                                        <div class="col-sm-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="form-status"
                                                    value="1">
                                                <label class="form-check-label">
                                                    Active
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="form-status"
                                                    value="0">
                                                <label class="form-check-label">
                                                    Inactive
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Role</label>
                                    <div class="col-sm-9">
                                        <select id="form-role">

                                        </select>
                                    </div>
                                </div> --}}

                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="save-btn" class="btn btn-primary" onclick="saveConfirm(1)">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-edit" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header headermodal">
                        <h5 class="modal-title">Edit Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form p-1">
                            <form id="base-form2">
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Header Name</label>
                                    <div class="col-sm-9">
                                        <input id="form-mid" type="hidden" class="form-control" placeholder="">
                                        <input id="form-header" type="text" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Menu Name</label>
                                    <div class="col-sm-9">
                                        <input id="form-menu" type="text" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="save-btn" class="btn btn-primary" onclick="saveConfirm(2)">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('after-script')
    <script> 
        @foreach ($varJs as $varjsi)
            {!! $varjsi !!}
        @endforeach
    </script>        
    @foreach ($javascriptFiles as $file)
        <script src="{{ $file }}"></script>
    @endforeach
@endpush
