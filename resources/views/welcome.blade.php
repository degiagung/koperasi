@extends('layout.default')
@section('content')
<div class="row">
    <div class="col-xl-3 col-sm-6">
        <div class="card box-hover">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-box icon-box-lg bg-success-light rounded">
                        <i class="fa-solid fa-briefcase text-success"></i>
                    </div>
                    <div class="total-projects ms-3">
                        <h3 class="text-success count" id="form-tot-employees"></h3> 
                        <span>Total Employee</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card box-hover">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-box icon-box-lg bg-primary-light rounded">
                        <i class="fa-solid fa-cart-shopping text-primary"></i>

                    </div>
                    <div class="total-projects ms-3">
                        <h3 class="text-primary count" id="form-tot-bookings"></h3> 
                        <span>Total Booked</span>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card box-hover">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-box icon-box-lg bg-warning-light rounded">
                        <i class="fa-solid fa-users text-warning"></i>
                    </div>
                    <div class="total-projects ms-3">
                        <h3 class="text-warning count" id="form-tot-users"></h3> 
                        <span>Total User</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card box-hover">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-box icon-box-lg bg-danger-light rounded">
                        <i class="fa-solid fa-hand-holding-dollar text-danger"></i>
                    </div>
                    <div class="total-projects ms-3">
                        <h4 class="text-danger count" id="form-tot-revenue"></h4> 
                        <span>Total Revenue (Rp)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">		
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive active-projects">
                    <div class="tbl-caption">
                        <h4 class="heading mb-0">Best Service Booked</h4>
                    </div>
                    <div class="table-responsive px-4 pb-4">
                        <table id="table-top-booked" class="datatables w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Service Name</th>
                                    <th>Total Booking</th>
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
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive active-projects">
                    <div class="tbl-caption">
                        <h4 class="heading mb-0">Latest Booked</h4>
                    </div>
                    <div class="table-responsive px-4 pb-4">
                        <table id="table-latest-booked"  class="table dataTable no-footer" role="grid" aria-describedby="projects-tbl_info">
                            <thead>
                                <th>No</th>
                                <th>No Booking</th>
                                <th>Status Booking</th>
                                <th>Payment Status</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

