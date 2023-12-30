@extends('layout.default')
@push('after-style')
    @foreach ($cssFiles as $file)
        <link rel="stylesheet" href="{{ $file }}">
    @endforeach
@endpush
@section('content')

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header mt-2 flex-wrap d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">List Penghuni</h4>
                        </div>
                        <ul class="nav nav-tabs dzm-tabs" id="myTab-4" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button type="button" id="add-btn" class="nav-link active btn-sgn">Add</button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-list" class="datatables">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email Address</th>
                                        <th>Handphone</th>
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
        <div class="modal fade" id="modal-data" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header headermodal">
                        <h5 class="modal-title">Data View</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form">
                            <form>
                                <div class="mb-3 row">
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
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="save-btn" class="btn btn-primary">Save</button>
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