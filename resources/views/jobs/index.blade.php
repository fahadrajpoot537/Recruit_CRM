@extends('layouts.app')

@section('content')
    <style>
        .hover-zoom {
            display: inline-block;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .hover-zoom:hover {
            transform: scale(1.3);
        }
    </style>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12 mb-md-4 mb-3">
                <div class="card card-border mb-0 h-100">
                    <div class="card-header card-header-action">
                        <h6>Jobs
                            <span class="badge badge-sm badge-light ms-1">240</span>
                        </h6>
                        <div class="card-action-wrap">
                            <button class="btn btn-sm btn-outline-light"><span><span class="icon"><span
                                            class="feather-icon"><i data-feather="upload"></i></span></span><span
                                        class="btn-text">import</span></span></button>
                            <a href="{{ route('jobs.create') }}" class="btn btn-sm btn-primary ms-3"><span><span class="icon"><span
                                            class="feather-icon"><i data-feather="plus"></i></span></span><span
                                        class="btn-text">Add new</span></span></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="contact-list-view">
                            <table id="datable_1" class="table nowrap w-100 mb-5">
                                <thead>
                                    <tr>
                                        <th><span class="form-check fs-6 mb-0">
                                                <input type="checkbox" class="form-check-input check-select-all"
                                                    id="customCheck1">
                                                <label class="form-check-label" for="customCheck1"></label>
                                            </span></th>
                                        <th>Name</th>
                                        <th class="w-25">Usage</th>
                                        <th>Last Update</th>
                                        <th>Tags</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <div class="media align-items-center">
                                                <div class="media-head me-2">
                                                    <div class="avatar avatar-xs avatar-rounded">
                                                        <img src="dist/img/logo-avatar-1.png" alt="user"
                                                            class="avatar-img">
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-high-em">Phone Pay</div>
                                                    <div class="fs-7"><a href="#"
                                                            class="table-link-text link-medium-em">phonepay.in</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress-lb-wrap">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress progress-bar-rounded progress-bar-xs flex-1">
                                                        <div class="progress-bar bg-blue-dark-3 w-90" role="progressbar"
                                                            aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <div class="fs-8 ms-3">90%</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>10 June, 2022</td>
                                        <td>
                                            <span class="badge badge-soft-secondary  my-1  me-2">admin</span>
                                            <span class="badge badge-soft-secondary my-1  me-2">Finance</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                                    data-bs-toggle="tooltip" data-placement="top" title=""
                                                    data-bs-original-title="Edit" href="#"><span class="icon"><span
                                                            class="feather-icon"><i
                                                                data-feather="edit-2"></i></span></span></a>
                                                <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover del-button"
                                                    data-bs-toggle="tooltip" data-placement="top" title=""
                                                    data-bs-original-title="Delete" href="#"><span
                                                        class="icon"><span class="feather-icon"><i
                                                                data-feather="trash"></i></span></span></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <div class="media align-items-center">
                                                <div class="media-head me-2">
                                                    <div class="avatar avatar-xs avatar-rounded">
                                                        <img src="dist/img/logo-avatar-2.png" alt="user"
                                                            class="avatar-img">
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-high-em">Swiggy</div>
                                                    <div class="fs-7"><a href="#"
                                                            class="table-link-text link-medium-em">swiggy.com</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress-lb-wrap">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress progress-bar-rounded progress-bar-xs flex-1">
                                                        <div class="progress-bar bg-blue w-75" role="progressbar"
                                                            aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <div class="fs-8 ms-3">75%</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>09 July, 2022</td>
                                        <td>
                                            <span class="badge badge-soft-secondary my-1  me-2">customer
                                                data</span>
                                            <span class="badge badge-soft-secondary  my-1  me-2">admin</span>
                                            <span class="badge badge-soft-secondary  my-1  me-2">+4</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                                    data-bs-toggle="tooltip" data-placement="top" title=""
                                                    data-bs-original-title="Edit" href="#"><span class="icon"><span
                                                            class="feather-icon"><i
                                                                data-feather="edit-2"></i></span></span></a>
                                                <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover del-button"
                                                    data-bs-toggle="tooltip" data-placement="top" title=""
                                                    data-bs-original-title="Delete" href="#"><span
                                                        class="icon"><span class="feather-icon"><i
                                                                data-feather="trash"></i></span></span></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <div class="media align-items-center">
                                                <div class="media-head me-2">
                                                    <div class="avatar avatar-xs avatar-rounded">
                                                        <img src="dist/img/logo-avatar-3.png" alt="user"
                                                            class="avatar-img">
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-high-em">Coursera</div>
                                                    <div class="fs-7"><a href="#"
                                                            class="table-link-text link-medium-em">coursera.com</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress-lb-wrap">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress progress-bar-rounded progress-bar-xs flex-1">
                                                        <div class="progress-bar bg-primary w-50" role="progressbar"
                                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <div class="fs-8 ms-3">50%</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>24 Aug, 2022</td>
                                        <td>
                                            <span class="badge badge-soft-secondary my-1  me-2">education</span>
                                            <span class="badge badge-soft-secondary  my-1  me-2">admin</span>
                                            <span class="badge badge-soft-secondary  my-1  me-2">+3</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                                    data-bs-toggle="tooltip" data-placement="top" title=""
                                                    data-bs-original-title="Edit" href="#"><span
                                                        class="icon"><span class="feather-icon"><i
                                                                data-feather="edit-2"></i></span></span></a>
                                                <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover del-button"
                                                    data-bs-toggle="tooltip" data-placement="top" title=""
                                                    data-bs-original-title="Delete" href="#"><span
                                                        class="icon"><span class="feather-icon"><i
                                                                data-feather="trash"></i></span></span></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <div class="media align-items-center">
                                                <div class="media-head me-2">
                                                    <div class="avatar avatar-xs avatar-rounded">
                                                        <img src="dist/img/logo-avatar-4.png" alt="user"
                                                            class="avatar-img">
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-high-em">Tinder</div>
                                                    <div class="fs-7"><a href="#"
                                                            class="table-link-text link-medium-em">tinder.com</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress-lb-wrap">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress progress-bar-rounded progress-bar-xs flex-1">
                                                        <div class="progress-bar bg-primary-dark-2 w-60"
                                                            role="progressbar" aria-valuenow="60" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <div class="fs-8 ms-3">60%</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>17 May, 2022</td>
                                        <td>
                                            <span class="badge badge-soft-secondary my-1  me-2">Social</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                                    data-bs-toggle="tooltip" data-placement="top" title=""
                                                    data-bs-original-title="Edit" href="#"><span
                                                        class="icon"><span class="feather-icon"><i
                                                                data-feather="edit-2"></i></span></span></a>
                                                <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover del-button"
                                                    data-bs-toggle="tooltip" data-placement="top" title=""
                                                    data-bs-original-title="Delete" href="#"><span
                                                        class="icon"><span class="feather-icon"><i
                                                                data-feather="trash"></i></span></span></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <div class="media align-items-center">
                                                <div class="media-head me-2">
                                                    <div class="avatar avatar-xs avatar-rounded">
                                                        <img src="dist/img/logo-avatar-5.png" alt="user"
                                                            class="avatar-img">
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-high-em">PCD</div>
                                                    <div class="fs-7"><a href="#"
                                                            class="table-link-text link-medium-em">pcdeals.com</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress-lb-wrap">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress progress-bar-rounded progress-bar-xs flex-1">
                                                        <div class="progress-bar bg-grey w-30" role="progressbar"
                                                            aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <div class="fs-8 ms-3">30%</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>13 July, 2022</td>
                                        <td>
                                            <span class="badge badge-soft-secondary my-1  me-2">Portal</span>
                                            <span class="badge badge-soft-secondary  my-1  me-2">admin</span>
                                            <span class="badge badge-soft-secondary  my-1  me-2">+3</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                                    data-bs-toggle="tooltip" data-placement="top" title=""
                                                    data-bs-original-title="Edit" href="#"><span
                                                        class="icon"><span class="feather-icon"><i
                                                                data-feather="edit-2"></i></span></span></a>
                                                <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover del-button"
                                                    data-bs-toggle="tooltip" data-placement="top" title=""
                                                    data-bs-original-title="Delete" href="#"><span
                                                        class="icon"><span class="feather-icon"><i
                                                                data-feather="trash"></i></span></span></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <div class="media align-items-center">
                                                <div class="media-head me-2">
                                                    <div class="avatar avatar-xs avatar-rounded">
                                                        <img src="dist/img/logo-avatar-6.png" alt="user"
                                                            class="avatar-img">
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-high-em">Icons 8</div>
                                                    <div class="fs-7"><a href="#"
                                                            class="table-link-text link-medium-em">icons8.com</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress-lb-wrap">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress progress-bar-rounded progress-bar-xs flex-1">
                                                        <div class="progress-bar bg-green-dark-1 w-45" role="progressbar"
                                                            aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <div class="fs-8 ms-3">45%</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>14 July, 2022</td>
                                        <td>
                                            <span class="badge badge-soft-secondary my-1  me-2">Library</span>
                                            <span class="badge badge-soft-secondary  my-1  me-2">Asset</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                                    data-bs-toggle="tooltip" data-placement="top" title=""
                                                    data-bs-original-title="Edit" href="#"><span
                                                        class="icon"><span class="feather-icon"><i
                                                                data-feather="edit-2"></i></span></span></a>
                                                <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover del-button"
                                                    data-bs-toggle="tooltip" data-placement="top" title=""
                                                    data-bs-original-title="Delete" href="#"><span
                                                        class="icon"><span class="feather-icon"><i
                                                                data-feather="trash"></i></span></span></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
