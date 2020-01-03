@extends('master')

@section('content')
    @include('components.header_moblie')
    @include('components.header')
    @include('components.menu')
    @include('components.channel.content')
@endsection

@section('script')
    <script>
        jQuery(document).ready(function(){
            jQuery('#addChannel').click(function(e){
                e.preventDefault();
                jQuery.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('#token').attr('content')
                    },
                    url: "{{ asset('/channel') }}",
                    method: 'post',
                    data: {
                        id_channel: $('#id_channel').val(),
                        name: $('#name').val(),
                        email: $('#email').val(),
                        phone: $('#phone').val(),
                        type: $('#type').val(),
                    },
                    beforeSend: function()
                    {
                        Swal.fire({
                            icon: 'info',
                            title: 'Thông báo',
                            text: 'Đang xử lý',
                        })
                    },
                    success: function(data){
                        Swal.fire({
                            icon: 'success',
                            title: 'Thông báo',
                            text: 'Thêm thành công',
                        });
                    },
                    error: function(error)
                    {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: error.responseJSON.error[0],
                        })
                    }
                });
            });
        });
    </script>

    {{--sắp xếp--}}
    <script>
        $("#sort").change(function (event) {
            var type = $("#sort").val();
            switch (type) {
                case 'sortVideo':
                    jQuery.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('#token').attr('content')
                        },
                        url: "{{ asset('/sortVideoChannel') }}",
                        method: 'post',
                        success: function(data){
                            $('#listChannel').html(data);
                        },
                        error: function(error)
                        {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: error.responseJSON.error[0],
                            })
                        }
                    });
                    break;
                case 'sortSubscribe':
                    jQuery.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('#token').attr('content')
                        },
                        url: "{{ asset('/sortSubscribeChannel') }}",
                        method: 'post',
                        success: function(data){
                            $('#listChannel').html(data);
                        },
                        error: function(error)
                        {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: error.responseJSON.error[0],
                            })
                        }
                    });
                    break;
                case 'sortView':
                    jQuery.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('#token').attr('content')
                        },
                        url: "{{ asset('/sortViewChannel') }}",
                        method: 'post',
                        success: function(data){
                            $('#listChannel').html(data);
                        },
                        error: function(error)
                        {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: error.responseJSON.error[0],
                            })
                        }
                    });
                    break;
                case 'sortLike':
                    jQuery.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('#token').attr('content')
                        },
                        url: "{{ asset('/sortLikeChannel') }}",
                        method: 'post',
                        success: function(data){
                            $('#listChannel').html(data);
                        },
                        error: function(error)
                        {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: error.responseJSON.error[0],
                            })
                        }
                    });
                    break;
                case 'sortDislike':
                    jQuery.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('#token').attr('content')
                        },
                        url: "{{ asset('/sortDislikeChannel') }}",
                        method: 'post',
                        success: function(data){
                            $('#listChannel').html(data);
                        },
                        error: function(error)
                        {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: error.responseJSON.error[0],
                            })
                        }
                    });
                    break;
                case 'sortComment':
                    jQuery.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('#token').attr('content')
                        },
                        url: "{{ asset('/sortCommentChannel') }}",
                        method: 'post',
                        success: function(data){
                            $('#listChannel').html(data);
                        },
                        error: function(error)
                        {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: error.responseJSON.error[0],
                            })
                        }
                    });
                    break;
            }
        })
    </script>
     {{--end sắp xếp--}}

    {{--lọc--}}
    <script>
        jQuery(document).ready(function(){
            jQuery('#filter').click(function(e){
                e.preventDefault();
                var filter_subscribe = $('#filter_subscribe').val();
                if( filter_subscribe == '')
                    filter_subscribe = 0;

                var filter_video = $('#filter_video').val();
                if( filter_video == '')
                    filter_video = 0;

                var filter_view = $('#filter_vew').val();
                if( filter_view == '')
                    filter_view = 0;

                var filter_like = $('#filter_like').val();
                if( filter_like == '')
                    filter_like = 0;

                var filter_dislike = $('#filter_dislike').val();
                if( filter_dislike == '')
                    filter_dislike = 0;

                var filter_comment = $('#filter_comment').val();
                if( filter_comment == '')
                    filter_comment = 0;

                //console.log(filter_subscribe+' - '+filter_video);

                jQuery.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('#token').attr('content')
                    },
                    url: "{{ asset('/filterChannel') }}",
                    method: 'post',
                    data: {
                        filter_subscribe: filter_subscribe,
                        filter_video: filter_video,
                        filter_view: filter_view,
                        filter_like: filter_like,
                        filter_dislike: filter_dislike,
                        filter_comment: filter_comment
                    },
                    success: function(data){
                        $('#listChannel').html(data);
                    },
                    error: function(error)
                    {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: error.responseJSON.error[0],
                        })
                    }
                });
            });
        });
    </script>

    {{--refresh--}}
    <script>
        jQuery(document).ready(function(){
            jQuery('#refresh').click(function(e){
                e.preventDefault();
                jQuery.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('#token').attr('content')
                    },
                    url: "{{ asset('/refresh') }}",
                    method: 'post',
                    success: function(data){
                        $('#listChannel').html(data);
                    },
                    error: function(error)
                    {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: error.responseJSON.error[0],
                        })
                    }
                });
            });
        });
    </script>


    <script>
        function search()
        {
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('#token').attr('content')
                },
                url: "{{ asset('/search') }}",
                method: 'post',
                data:{
                    key: $('#search').val()
                },
                success: function(data){
                    $('#listChannel').html(data);
                },
                error: function(error)
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: error.responseJSON.error[0],
                    })
                }
            });
        }
    </script>
@endsection