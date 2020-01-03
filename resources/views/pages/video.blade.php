@extends('master')

@section('content')
    @include('components.header_moblie')
    @include('components.header')
    @include('components.menu')
    @include('components.video.content')
@endsection

@section('script')
    <script>
        $("#sortVideo").change(function () {
            var type = $('#sortVideo').val();
            console.log(type);
            switch (type) {
                case 'sortView':
                    window.location = '/sortViewVideo';
                    break;
                case 'sortLike':
                    window.location = '/sortLikeVideo';
                    break;
                case 'sortDislike':
                    window.location = '/sortDislikeVideo';
                    break;
                case 'sortComment':
                    window.location = '/sortCommentVideo';
                    break;
                default:
                    window.location = '/video';
                    break;
            }
        });
    </script>

    <script>
        function watchYoutube(id_video) {
            $('#watch_youtube').attr('src','https://www.youtube.com/embed/'+id_video);
        }
    </script>

@endsection