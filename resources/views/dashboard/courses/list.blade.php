@extends('layouts.app')
@section('content')
    <section class="wrapper">
        <!-- row -->
        <div class="row mt">
            <div class="col-md-12">
                <div class="content-panel">

                    <table class="table table-striped table-advance table-hover">
                        <button onclick="setupAdd()" class="btn btn-primary" data-toggle="modal" data-target="#course_info" style="float: right;margin-right: 20px;width: 10em;">Add</button>
                        <h4><i class="fa fa-angle-right"></i> Courses</h4>
                        <hr>
                        <thead>
                        <tr>
                            <th><i class="fa fa-bullhorn"></i>Name</th>
                            <th class="hidden-phone"><i class="fa fa-question-circle"></i> Duration</th>
                            <th><i class="fa fa-bookmark"></i> Start Date</th>
                            <th><i class="fa fa-bookmark"></i> End Date</th>
                            <th><i class=" fa fa-edit"></i> Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                                @if(isset($courses))
                                    @foreach($courses as $course)
                                        <tr>
                                            <td id="c_name">{{$course->name}}</td>
                                            <td id="c_duration" class="hidden-phone">{{$course->duration}}</td>
                                            <td id="c_start_date">{{$course->start_date}}</td>
                                            <td id="c_end_date">{{$course->end_date}}</td>
                                            <td><span id="c_status" class="label @if($course->status) label-success @else label-warning @endif label-mini">@if($course->status) enable @else disable @endif</span></td>
                                            <td>
                                                @if(!$course->status)
                                                    <button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                                                @endif
                                                <button onclick="setupEdit(this,{{$course->id}})" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#course_info"><i class="fa fa-pencil"></i></button>
                                                <button onclick="setupDelete(this,{{$course->id}})" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                        </tbody>
                    </table>
                </div>
                <!-- /content-panel -->
            </div>
            <!-- /col-md-12 -->
        </div>
        <!-- /row -->
    </section>

{{--    Modal    --}}
    <div class="modal fade" id="course_info" tabindex="-1" role="dialog" aria-labelledby="course_info" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="course_info_title">Edit Course</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal style-form" method="post" action="{{route('course.edit')}}">
                        <input type="hidden" name="course_id" id="course_id" />
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="course_name" id="course_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Duration</label>
                            <div class="col-sm-10">
                                <input type="text" name="course_duration" id="course_duration" class="form-control">
                                <span class="help-block">Example: 24 hours.</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Start Date</label>
                            <div class="col-sm-10">
                                <input type="date" name="course_start_date" id="course_start_date" class="form-control" size="16">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">End Date</label>
                            <div class="col-sm-10">
                                <input type="date" name="course_end_date" id="course_end_date" class="form-control" size="16">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Status</label>
                            <div class="col-sm-6 text-center">
                                <select class="form-control" name="course_status" id="course_status">
                                    <option value="0">Disable</option>
                                    <option value="1">Enable</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="course_info_add" class="btn btn-primary" hidden>Save</button>
                    <button type="button" id="course_info_edit" class="btn btn-primary" hidden>Save Changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function setupAdd(){
            $('#course_info_title').text("Add Course");
            $('#course_info_add').show();
            $('#course_info_edit').hide();

            $("#course_info_add").click(function(e) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                e.preventDefault();
                var course_name = $("input[name='course_name']").val();
                var course_duration = $("input[name='course_duration']").val();
                var course_start_date = $("input[name='course_start_date']").val();
                var course_end_date = $("input[name='course_end_date']").val();
                var course_status = $("select[name='course_status']").val();

                $.ajax({
                    url: '{{ route('course.add') }}',
                    type: 'POST',
                    data: {
                        course_name: course_name,
                        course_duration: course_duration,
                        course_start_date: course_start_date,
                        course_end_date: course_end_date,
                        course_status: course_status,
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Great...',
                                text: 'Course will added successfully!',
                            })
                        } else {
                            printErrorMsg(data.error);
                        }
                    }
                });

            });

            function printErrorMsg(msg) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                })
            }

        }
        function setupEdit(element,course_id){
            $('#course_info_add').hide();
            $('#course_info_edit').show();

            var parent_elem = $(element).closest('td').parent().first();

            $('#course_info_title').text("Edit Course");
            $('#course_name').val(parent_elem.find('#c_name').text());
            $('#course_duration').val(parent_elem.find('#c_duration').text());
            $('#course_start_date').val(parent_elem.find('#c_start_date').text());
            $('#course_end_date').val(parent_elem.find('#c_end_date').text());

            if (parent_elem.find('td #c_status').text().toString().trim() == "enable")
                $('#course_status option:eq(1)').prop('selected', true);
            else if(parent_elem.find('td #c_status').text().toString().trim() == "disable")
                $('#course_status option:eq(0)').prop('selected', true);

            $("#course_info_edit").click(function(e) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                e.preventDefault();
                var course_name = $("input[name='course_name']").val();
                var course_duration = $("input[name='course_duration']").val();
                var course_start_date = $("input[name='course_start_date']").val();
                var course_end_date = $("input[name='course_end_date']").val();
                var course_status = $("select[name='course_status']").val();

                $.ajax({
                    url: '{{ route('course.edit') }}/'+course_id,
                    type: 'POST',
                    data: {
                        course_name: course_name,
                        course_duration: course_duration,
                        course_start_date: course_start_date,
                        course_end_date: course_end_date,
                        course_status: course_status,
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Great...',
                                text: 'Course will added successfully!',
                            })
                        } else {
                            printErrorMsg(data.error);
                        }
                    }
                });

            });

            function printErrorMsg(msg) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                })
            }
        }
        function setupDelete(element,course_id){


                $.ajax({
                    url: '{{ route('course.delete') }}/'+course_id,
                    type: 'get',
                    data: null,
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            $(element).closest('td').parent().first().remove();
                            Swal.fire({
                                icon: 'success',
                                title: 'Great...',
                                text: 'Course will deleted successfully!',
                            })
                        } else {
                            printErrorMsg(data.error);
                        }
                    }
                });
            function printErrorMsg(msg) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                })
            }
        }
    </script>

@endsection
