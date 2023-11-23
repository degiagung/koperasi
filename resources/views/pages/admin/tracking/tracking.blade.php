@extends('layout.default')
@section('content')
    {{-- <div class="row">
        <div class="col-xl-6 mb-3">
            <div class="input-group search-area">
                <input type="text" class="form-control" placeholder="No Booking">
                <span class="input-group-text"><a href="javascript:void(0)">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1_450)">
                        <path opacity="0.3" d="M14.2929 16.7071C13.9024 16.3166 13.9024 15.6834 14.2929 15.2929C14.6834 14.9024 15.3166 14.9024 15.7071 15.2929L19.7071 19.2929C20.0976 19.6834 20.0976 20.3166 19.7071 20.7071C19.3166 21.0976 18.6834 21.0976 18.2929 20.7071L14.2929 16.7071Z" fill="#452B90"></path>
                        <path d="M11 16C13.7614 16 16 13.7614 16 11C16 8.23859 13.7614 6.00002 11 6.00002C8.23858 6.00002 6 8.23859 6 11C6 13.7614 8.23858 16 11 16ZM11 18C7.13401 18 4 14.866 4 11C4 7.13402 7.13401 4.00002 11 4.00002C14.866 4.00002 18 7.13402 18 11C18 14.866 14.866 18 11 18Z" fill="#452B90"></path>
                        </g>
                        <defs>
                        <clipPath id="clip0_1_450">
                        <rect width="24" height="24" fill="white"></rect>
                        </clipPath>
                        </defs>
                    </svg>
                </a></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Booking Status</h4>
                </div>
                <div class="card-body">
                    <div id="smartwizard" class="form-wizard order-create sw sw-theme-default sw-justified">
                        <ul class="nav nav-wizard">
                            <li><a class="nav-link inactive active" href="#wizard_Service"> 
                                <span>60 menit</span> 
                            </a>
                                <div>Body scrub</div>
                              
                            </li>
                            <li><a class="nav-link inactive" href="#wizard_Time">
                                <span>2</span>
                               
                            </a> <div>Body scrub</div></li>
                            <li><a class="nav-link inactive" href="#wizard_Details">
                                <span>3</span>
                             
                            </a>   <div>Body scrub</div></li>
                            <li><a class="nav-link inactive" href="#wizard_Payment">
                                <span>4</span>
                                
                            </a><div>Body scrub</div></li>
                        </ul>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
  --}}
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header mt-2 flex-wrap d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">List of Upcoming Bookings</h4>
                        <p class="m-0 subtitle">Add <code>Patient</code> class with <code>datatables</code></p>
                    </div>
                    {{-- <ul class="nav nav-tabs dzm-tabs" id="myTab-4" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button type="button" id="add-btn" class="nav-link active">Add</button>
                        </li>
                    </ul> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-list" class="datatables">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Booking Date</th>
                                    <th>No Booking</th>
                                    <th>Customers Name</th>
                                    {{-- <th>Category (Package)</th> --}}
                                    <th>Status</th>
                                    <th>Duration</th>
                                    <th>Total Price</th>
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
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data View</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="basic-form">
                        <form>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Booking Date</label>
                                <div class="col-sm-9">
                                    <input id="form-booking-date" type="text" class="form-control" placeholder="Name">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">No Booking</label>
                                <div class="col-sm-9">
                                    <input id="form-no-booking" type="text" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Diskon</label>
                                <div class="col-sm-9">
                                    <input id="form-discount" type="number" class="form-control" placeholder="Phone">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Total Price</label>
                                <div class="col-sm-9">
                                    <input id="form-total-price" type="number" class="form-control" placeholder="Phone">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="table-responsive">
                                    <table id="table-list-det" class="datatables w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Service Name</th>
                                                <th>Employee Name</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="save-btn" class="btn btn-primary d-none">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('after-script')
    <script src="{{ $javascriptFile }}"></script>
@endpush
