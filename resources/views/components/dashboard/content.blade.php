<!-- PAGE CONTAINER-->
<div class="page-container">
    <!-- HEADER DESKTOP-->
    @include('components.header_desktop')
    <!-- HEADER DESKTOP-->

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Tổng quan</h2>

                        </div>
                    </div>
                </div>
                <div class="row m-t-25">
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c4">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-accounts-list zmdi-hc-fw"></i>
                                    </div>
                                    <div class="text">
                                        <h2>{{number_format($num_channel)}}</h2>
                                        <span>kênh</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c1">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-play-circle"></i>
                                    </div>
                                    <div class="text">
                                        <h2>{{number_format($total_video)}}</h2>
                                        <span>video</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c6">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmd-fw zmdi zmdi-face"></i>
                                    </div>
                                    <div class="text">
                                        <h2>{{number_format($total_subscribe)}}</h2>
                                        <span>Subscribe</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c2">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-eye"></i>
                                    </div>
                                    <div class="text">
                                        <h2>{{number_format($total_view)}}</h2>
                                        <span>Lượt xem</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c3">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-thumb-up"></i>
                                    </div>
                                    <div class="text">
                                        <h2>{{number_format($total_like)}}</h2>
                                        <span>Lượt like</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c5">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-thumb-down"></i>
                                    </div>
                                    <div class="text">
                                        <h2>{{$total_dislike}}</h2>
                                        <span>Lượt dislike</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c4">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-comment-text-alt"></i>
                                    </div>
                                    <div class="text">
                                        <h2>{{$total_comment}}</h2>
                                        <span>Lượt comment</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-9">
                        <h2 class="title-1 m-b-25">Top video nhiều lượt xem nhất</h2>
                        <div class="table-responsive table--no-card m-b-40">
                            <table class="table table-borderless table-striped table-earning">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Thumbnail</th>
                                    <th>Tiêu đề</th>
                                    <th>view</th>
                                    <th>like</th>
                                    <th>dislike</th>
                                    <th>comment</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($videos as $index => $video)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>
                                            <div class="img-thumbnail">
                                                <image class="img-thumbnail" title="{{$video->title}}" src="{{$video->thumbnail}}"></image>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="block-title" title="{{$video->title}}">
                                                <a href="https://www.youtube.com/watch?v={{$video->id_video}}" target="_blank">
                                                {{$video->title}}
                                                </a>
                                            </div>
                                        </td>
                                        <td>{{$video->view}}</td>
                                        <td>{{$video->num_like}}</td>
                                        <td>{{$video->dislike}}</td>
                                        <td>{{$video->comment}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <h2 class="title-1 m-b-25">Top kênh tương tác nhiều nhất</h2>
                        <div class="au-card au-card--bg-blue au-card-top-countries m-b-40">
                            <div class="au-card-inner">
                                <div class="table-responsive">
                                    <table class="table table-top-countries">
                                        <thead>
                                            <th>STT</th>
                                            <th>Tên kênh</th>
                                            <th>Lượt</th>
                                        </thead>
                                        <tbody>
                                        @foreach($top_channel as $index => $channel)
                                        <tr class="text-center">
                                            <td class="text-dark">{{$index+1}}</td>
                                            <td class="text-center">
                                                <a target="_blank" class="text-success" href="https://www.youtube.com/channel/{{$channel->channel_id}}?view_as=subscriber">
                                                    {{$channel->name}}
                                                </a>
                                            </td>
                                            <td class="text-dark">
                                                {{number_format($channel->tuongtac)}}
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="au-card m-b-30">
                            <div class="au-card-inner">
                                <h3 class="title-2 m-b-40">Biểu đồ theo dõi số lượng view mỗi ngày</h3>

                                <canvas id="lineChartView"></canvas>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="copyright">
                            <p>Copyright © 2018 Colorlib. All rights reserved. Template by <a href="https://tovicorp.com">tovi</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
    <!-- END PAGE CONTAINER-->
</div>