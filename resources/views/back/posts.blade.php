@extends('back.app')

@section('css')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/sweetalert2/6.3.8/sweetalert2.min.css">
    <style>
        input, th span {
            cursor: pointer;
        }
    </style>
@endsection

@section('main')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <strong>@lang('Status') :</strong> &nbsp;
                    <input type="checkbox" name="new" @if(request()->new) checked @endif> @lang('New')&nbsp;
                    <input type="checkbox" name="active" @if(request()->active) checked @endif> @lang('Active')&nbsp;
                    <div id="spinner" class="text-center"></div>
                </div>
                <div class="box-body table-responsive">
                    <table id="users" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>@lang('Title')<span id="title" class="fa fa-sort pull-right"
                                                    aria-hidden="true"></span></th>
                            <th>@lang('Image')</th>
                            <th>@lang('Active')<span id="active" class="fa fa-sort pull-right"
                                                     aria-hidden="true"></span></th>
                            <th>@lang('Creation')<span id="created_at" class="fa fa-sort-desc pull-right"
                                                       aria-hidden="true"></span></th>
                            <th>@lang('New')</th>
                            <th>@lang('SEO Title')<span id="seo_title" class="fa fa-sort pull-right"
                                                        aria-hidden="true"></span></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>@lang('Title')</th>
                            <th>@lang('Image')</th>
                            <th>@lang('Active')</th>
                            <th>@lang('Creation')</th>
                            <th>@lang('New')</th>
                            <th>@lang('SEO Title')</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                        <tbody id="pannel">
                        @if (session('post-ok'))
                            @component('back.components.alert')
                                @slot('type')
                                    success
                                @endslot
                                {!! session('post-ok') !!}
                            @endcomponent
                        @endif
                        @include('back.posts.table', compact('posts'))
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div id="pagination" class="box-footer">
                    {{ $posts->links() }}
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection

@section('js')
    <script>
        var user = (function () {
            var onReady = function () {
                $('#pannel').on('click', 'td a.btn-danger', function (event) {
                    const rowId = $(this).closest('tr').attr('id');
                    const postId = rowId.replace('post_', '');
                    const url = "{{ route('posts.destroy', ':postId') }}".replace(':postId', postId);
                    $.ajax({
                        url: url,
                        type:'DELETE',
                        data: {_token:'{{ csrf_token() }}', user:postId},
                        success: function(data){
                            $('#pannel').html(data);
                        },
                        error: function (xhr, status, error) {
                            console.error("AJAX error: " + error);
                        }
                    });
                })
            }

            return {
                onReady: onReady
            }

        })()

        $(document).ready(user.onReady)
    </script>
@endsection
