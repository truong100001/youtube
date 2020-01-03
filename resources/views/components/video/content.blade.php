<!-- PAGE CONTAINER-->
<div class="page-container">
    <!-- HEADER DESKTOP-->
    @include('components.header_desktop')
    <!-- END HEADER DESKTOP-->

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <h3 class="title-5 m-b-35">Video</h3>
                        <div class="table-data__tool">
                            <div class="table-data__tool-left">
                                <div class="rs-select2--light rs-select2--md">
                                    <select class="js-select2" name="property" id="sortVideo">
                                        <option selected="selected">Sắp xếp</option>
                                        <option value="sortView">Lượt xem</option>
                                        <option value="sortLike">Lượt like</option>
                                        <option value="sortDislike">Lượt dislike</option>
                                        <option value="sortComment">Lượt comment</option>
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>

                                <button class="au-btn-filter" data-toggle="modal" data-target="#largeModal">
                                    <i class="zmdi zmdi-filter-list"></i>
                                    Lọc
                                </button>
                            </div>

                        </div>
                        <div class="table-responsive table-responsive-data2">
                            <div class="text-primary">{{$num_result}} kết quả</div>
                            <table class="table table-data2">
                                <thead>
                                <tr>
                                    <th>
                                        STT
                                    </th>
                                    <th>Thumbnail</th>
                                    <th>Tiêu đề</th>
                                    <th>email</th>
                                    <th>thời lượng</th>
                                    <th>view</th>
                                    <th>like</th>
                                    <th>dislike</th>
                                    <th>commnent</th>
                                    <th>status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                @foreach($videos as $index => $video)
                                <tbody>
                                <tr class="tr-shadow">
                                    <td>{{$index+1}}</td>
                                    <td>
                                        <div class="img-thumbnail">
                                            <image class="img-thumbnail" title="{{$video->title}}" src="{{$video->thumbnail}}"></image>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="block-title" title="{{$video->title}}">{{$video->title}}</div>
                                    </td>
                                    <td>
                                        <span class="block-email">{{$video->email}}</span>
                                    </td>
                                    <td class="desc">{{str_replace_first('PT','',$video->duration)}}</td>
                                    <td>{{$video->view}}</td>
                                    <td>{{$video->num_like}}</td>
                                    <td>{{$video->dislike}}</td>
                                    <td>{{$video->comment}}</td>
                                    <td>
                                        <span class="badge badge-pill badge-success">{{$video->status}}</span>
                                    </td>
                                    <td>
                                        <div class="table-data-feature">
                                            <button onclick="watchYoutube('{{$video->id_video}}')" class="item" title="Xem nhanh" data-toggle="modal" data-target="#mediumModal">
                                                <i class="zmdi zmdi-mail-send"></i>
                                            </button>
                                            <a target="_blank" href="https://www.youtube.com/watch?v={{$video->id_video}}">
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Xem chi tiết">
                                                    <i class="zmdi zmdi-more"></i>
                                                </button>
                                            </a>

                                            <button onclick="test()" class="item" data-toggle="tooltip" data-placement="top" title="Xóa">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>

                                </tbody>
                                @endforeach
                            </table>
                            @if(!isset($noLink))
                            {{$videos->links()}}
                            @endif
                        </div>
                        <!-- END DATA TABLE -->
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
    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="largeModalLabel">Lọc</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{asset('/filterVideo')}}" method="get">
                    <div class="modal-body">
                       <div class="row">
                           <div class="col-md-3">
                               <div class="form-group">
                                   <label for="cc-payment" class="control-label mb-1">View</label>
                                   <input id="cc-pament" value="0" placeholder="vd: 100" name="view" type="number" min="0" class="form-control" aria-required="true" aria-invalid="false">
                                   @if($errors->has('view'))
                                       <div class="text-danger">{{ $errors->first('view') }}</div>
                                   @endif
                               </div>
                           </div>
                           <div class="col-md-3">
                               <div class="form-group">
                                   <label for="cc-payment" class="control-label mb-1">Like</label>
                                   <input id="cc-pament" value="0" placeholder="vd: 100" name="num_like" type="number" min="0" class="form-control" aria-required="true" aria-invalid="false">
                                   @if($errors->has('num_like'))
                                       <div class="text-danger">{{ $errors->first('num_like') }}</div>
                                   @endif
                               </div>
                           </div>
                           <div class="col-md-3">
                               <div class="form-group">
                                   <label for="cc-payment" class="control-label mb-1">Dislike</label>
                                   <input id="cc-pament" value="0" placeholder="vd: 100" name="dislike" type="number" min="0" class="form-control" aria-required="true" aria-invalid="false">
                                   @if($errors->has('dislike'))
                                       <div class="text-danger">{{ $errors->first('dislike') }}</div>
                                   @endif
                               </div>
                           </div>
                           <div class="col-md-3">
                               <div class="form-group">
                                   <label for="cc-payment" class="control-label mb-1">Comment</label>
                                   <input id="cc-pament" value="0" placeholder="vd: 100" name="comment" type="number" min="0" class="form-control" aria-required="true" aria-invalid="false">
                                   @if($errors->has('comment'))
                                       <div class="text-danger">{{ $errors->first('comment') }}</div>
                                   @endif
                               </div>
                           </div>
                           <div class="col-md-3">
                               <div class="form-group">
                                   <label for="cc-payment" class="control-label mb-1">Kênh</label>
                                   <select name="id_channel" id="select" class="form-control">
                                       <option value="">Chọn kênh</option>
                                       @foreach($channels as $channel)
                                        <option value="{{$channel->channel_id}}">{{$channel->name}}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>
                           <div class="col-md-3">
                               <div class="form-group">
                                   <label for="cc-payment" class="control-label mb-1">Loại video</label>
                                   <select name="type" id="select" class="form-control">
                                       <option value="">Loại video</option>
                                       <option value="0">APK thường</option>
                                       <option value="4">Mac os</option>
                                       <option value="5">APK search</option>
                                   </select>
                               </div>
                           </div>
                       </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <iframe
                            id="watch_youtube"
                            width="100%"
                            height="500px"
                            src="https://www.youtube.com/embed/zkseG9CogxA"
                            frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>