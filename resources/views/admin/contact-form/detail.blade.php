@extends('admin.master')
@section('title')
    Customer Queries manage | {{env('APP_NAME')}}
@endsection

@section('body')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Customer Query Detail</li>
                    </ol>
                </div>
                <h4 class="page-title">{{$contactFormDetail->subject}}</h4>
            </div>
        </div>
    </div>
    <div class="row">

        <!-- Right Sidebar -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
{{--                    <div class="btn-group">--}}
{{--                        <button type="button" class="btn btn-secondary"><i class="mdi mdi-archive font-16"></i></button>--}}
{{--                        <button type="button" class="btn btn-secondary"><i class="mdi mdi-alert-octagon font-16"></i></button>--}}
{{--                        <button type="button" class="btn btn-secondary"><i class="mdi mdi-delete-variant font-16"></i></button>--}}
{{--                    </div>--}}
{{--                    <div class="btn-group">--}}
{{--                        <button type="button" class="btn btn-secondary dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                            <i class="mdi mdi-folder font-16"></i>--}}
{{--                            <i class="mdi mdi-chevron-down"></i>--}}
{{--                        </button>--}}
{{--                        <div class="dropdown-menu">--}}
{{--                            <span class="dropdown-header">Move to:</span>--}}
{{--                            <a class="dropdown-item" href="javascript: void(0);">Social</a>--}}
{{--                            <a class="dropdown-item" href="javascript: void(0);">Promotions</a>--}}
{{--                            <a class="dropdown-item" href="javascript: void(0);">Updates</a>--}}
{{--                            <a class="dropdown-item" href="javascript: void(0);">Forums</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="btn-group">--}}
{{--                        <button type="button" class="btn btn-secondary dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                            <i class="mdi mdi-label font-16"></i>--}}
{{--                            <i class="mdi mdi-chevron-down"></i>--}}
{{--                        </button>--}}
{{--                        <div class="dropdown-menu">--}}
{{--                            <span class="dropdown-header">Label as:</span>--}}
{{--                            <a class="dropdown-item" href="javascript: void(0);">Updates</a>--}}
{{--                            <a class="dropdown-item" href="javascript: void(0);">Social</a>--}}
{{--                            <a class="dropdown-item" href="javascript: void(0);">Promotions</a>--}}
{{--                            <a class="dropdown-item" href="javascript: void(0);">Forums</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="btn-group">--}}
{{--                        <button type="button" class="btn btn-secondary dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                            <i class="mdi mdi-dots-horizontal font-16"></i> More--}}
{{--                            <i class="mdi mdi-chevron-down"></i>--}}
{{--                        </button>--}}
{{--                        <div class="dropdown-menu">--}}
{{--                            <span class="dropdown-header">More Options :</span>--}}
{{--                            <a class="dropdown-item" href="javascript: void(0);">Mark as Unread</a>--}}
{{--                            <a class="dropdown-item" href="javascript: void(0);">Add to Tasks</a>--}}
{{--                            <a class="dropdown-item" href="javascript: void(0);">Add Star</a>--}}
{{--                            <a class="dropdown-item" href="javascript: void(0);">Mute</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="">
                        <h5 class="font-18">Subject: {{$contactFormDetail->subject}}</h5>

                        <hr/>

                        <div class="d-flex mb-3 mt-1">
                            <img class="d-flex me-2 rounded-circle" src="{{asset('/')}}admin/assets/images/users/avatar-2.jpg" alt="placeholder image" height="32">
                            <div class="w-100 overflow-hidden">
                                <small class="float-end">{{$contactFormDetail->created_at->format('Y-m-d h:m:i A')}}</small>
                                <h6 class="m-0 font-14">{{$contactFormDetail->name}}</h6>
                                <small class="text-muted">From: {{$contactFormDetail->email}}</small><br>
                                <small class="text-muted">Mobile: {{$contactFormDetail->phone}}</small>
                            </div>
                        </div>

                        <p>{{$contactFormDetail->message}}</p>
                        <hr/>

                        <div class="mt-5">
                            <a href="" class="btn btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#compose-modal"><i class="mdi mdi-reply me-1"></i> Reply</a>
                            <a href="{{route('dashboard.contact-form')}}" class="btn btn-light">Back to query page <i class="mdi mdi-keyboard-return ms-1"></i></a>
                        </div>

                    </div>
                    <!-- end .mt-4 -->

                </div>

                <div class="clearfix"></div>
            </div> <!-- end card-box -->

        </div> <!-- end Col -->
    </div><!-- End row -->

    <!-- Compose Modal -->
    <div id="compose-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="compose-header-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="compose-header-modalLabel">New Message</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="p-1">
                    <div class="modal-body px-3 pt-3 pb-0">
                        <form action="{{route('contactForm.replay', ['id' => $contactFormDetail->id])}}" method="POST" enctype="multipart/form-data" id="replayForm">
                            @csrf
                            <div class="mb-2">
                                <label for="msgto" class="form-label">To</label>
                                <input type="text" id="msgto" name="toEmail" readonly class="form-control" value="{{$contactFormDetail->email}}" placeholder="Example@email.com">
                            </div>
                            <div class="mb-2">
                                <label for="mailsubject" class="form-label">Subject</label>
                                <input type="text" id="mailsubject" name="subject" value="Reply for: {{$contactFormDetail->subject}}" class="form-control" placeholder="Your subject">
                            </div>
                            <div class="write-mdg-box mb-3">
                                <label class="form-label">Message</label>
                                <textarea id="simplemde1" name="replay">{{$contactFormDetail->replay ?? ''}}</textarea>
                            </div>
                        </form>
                    </div>
                    <div class="px-3 pb-3">
                        <button type="button" onclick="event.preventDefault(); document.getElementById('replayForm').submit();" class="btn btn-primary" data-bs-dismiss="modal"><i class="mdi mdi-send me-1"></i> Send Message</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection
