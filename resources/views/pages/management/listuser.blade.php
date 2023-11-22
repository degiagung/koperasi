@extends('template.template')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}" />

<!-- Main content -->
<section class="content">
    <div class="panel">
        <div class="panel-flat">
            <h2>List User</h2>
            <button type="btn" id="add-btn" class="btn btn-primary">+ Tambah User</button>
            <hr>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="table-list" class="datatables">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email Address</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="panel">
        <div class="panel-flat">
            <div class="col-lg-2 col-xs-6">
                <select class="form-control" id="choiceaction">
                    <option value="0">-- Action --</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="unlock">Unlock Login</option>
                </select>
            </div>

            <button type="btn" id="updt-btn" class="btn btn-sgn">Submit</button>
        </div>
    </div> --}}
    <div class="modal fade" id="modal-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titleview"></h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Name:</label>
                        <input id="form-name" type="text" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Handphone:</label>
                        <input id="form-handphone" type="number" class="form-control" placeholder="No Handphone" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Email:</label>
                        <input id="form-email" type="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">No ktp:</label>
                        <input id="form-noktp" type="noktp" class="form-control" placeholder="No KTP" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Alamat:</label>
                        <input id="form-alamat" type="alamat" class="form-control" placeholder="Alamat" required>
                    </div>
                    <div class="form-group" id="divpassword">
                        <label for="message-text" class="control-label">Password:</label>
                        <input id="form-password" type="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Role:</label>
                        <select id="form-role" class="form-control select-search">

                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="save-btn" class="btn btn-primary">Simpan</button>
            </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->
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