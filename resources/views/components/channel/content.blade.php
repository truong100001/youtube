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
                        <h3 class="title-5 m-b-35">Kênh youtube</h3>
                        <div class="table-data__tool">
                            <div class="table-data__tool-left">
                                <div class="rs-select2--light rs-select2--md">
                                    <select class="js-select2" name="property" id="sort">
                                        <option selected="selected">Sắp xếp</option>
                                        <option value="sortVideo">Số Video</option>
                                        <option value="sortSubscribe">Số Subscribe</option>
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

                                <button class="au-btn-filter" data-toggle="modal" id="refresh" >
                                    <i class="zmdi zmdi-refresh"></i>
                                    Refesh
                                </button>
                            </div>

                            <div class="table-data__tool-right">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal" data-target="#mediumModal">
                                    <i class="zmdi zmdi-plus"></i>Thêm mới
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <input onkeypress="search()" id="search" name="search" type="text" class="form-control" aria-required="true" aria-invalid="false">
                            </div>
                            <div class="col-md-2">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-search"></i>Tìm
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive table-responsive-data2" id="listChannel">
                            <table class="table table-data2">
                                <thead>
                                <tr class="text-center">
                                    <th>
                                        STT
                                    </th>
                                    <th>tên kênh</th>
                                    <th>Email</th>
                                    <th>Loại</th>
                                    <th>số điện thoại</th>
                                    <th>Số video</th>
                                    <th>subscribe</th>
                                    <th>view</th>
                                    <th>like</th>
                                    <th>dislike</th>
                                    <th>commnet</th>
                                    <th></th>
                                </tr>
                                </thead>
                                @foreach($channels as $key => $channel)
                                <tbody class="text-center">
                                <tr class="tr-shadow">
                                    <td>{{$key+1}}</td>

                                    </td>

                                    <td>
                                        <span class="block-email">{{$channel->name}}</span>
                                    </td>
                                    <td>
                                        <span class="block-email">{{$channel->email}}</span>
                                    </td>
                                    <td>
                                        @if($channel->type == 0)
                                            <span class="badge badge-pill badge-success">apk thường</span>
                                        @elseif($channel->type == 4)
                                            <span class="badge badge-pill badge-primary">mac os</span>
                                        @elseif($channel->type == 5)
                                            <span class="badge badge-pill badge-dark">apk search</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">loại khác</span>
                                        @endif
                                    </td>
                                    <td class="desc">{{$channel->phone}}</td>
                                    <td>{{$channel->total_video}}</td>
                                    <td>{{$channel->subscribe}}</td>
                                    <td>{{$channel->total_view}}</td>
                                    <td>{{$channel->total_like}}</td>
                                    <td>{{$channel->total_dislike}}</td>
                                    <td>{{$channel->total_comment}}</td>

                                    <td>
                                        <div class="table-data-feature">
                                            <button class="item" data-toggle="tooltip" data-placement="top" title="Xóa">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                            <a target="_blank" href="https://www.youtube.com/channel/{{$channel->channel_id}}?view_as=subscriber">
                                            <button class="item" data-toggle="tooltip" data-placement="top" title="Xem chi tiết">
                                                <i class="zmdi zmdi-more"></i>
                                            </button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>
                                </tbody>
                                @endforeach
                            </table>
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
    {{-- LỌC --}}
    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="largeModalLabel">Lọc</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cc-payment" class="control-label mb-1">Số subscribe</label>
                                    <input id="filter_subscribe" min="0" placeholder="vd: 100" name="cc-payment" type="number" class="form-control" aria-required="true" aria-invalid="false">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cc-payment" class="control-label mb-1">Số video</label>
                                    <input id="filter_video" min="0" placeholder="vd: 100" name="cc-payment" type="number" class="form-control" aria-required="true" aria-invalid="false">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cc-payment" class="control-label mb-1">View</label>
                                    <input id="filter_view" min="0" placeholder="vd: 100" name="cc-view" type="number" class="form-control" aria-required="true" aria-invalid="false">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cc-payment" class="control-label mb-1">Like</label>
                                    <input id="filter_like" min="0"  placeholder="vd: 100" name="cc-like" type="number" class="form-control" aria-required="true" aria-invalid="false">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cc-payment" class="control-label mb-1">Dislike</label>
                                    <input id="filter_dislike" min="0" placeholder="vd: 100" name="cc-dislike" type="number" class="form-control" aria-required="true" aria-invalid="false">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cc-payment" class="control-label mb-1">Comment</label>
                                    <input id="filter_comment" min="0" placeholder="vd: 100" name="cc-comment" type="number" class="form-control" aria-required="true" aria-invalid="false">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button id="filter" type="button" class="btn btn-primary"><i class="fa fa-filter"></i> OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- END LỌC --}}

    {{-- THÊM MỚI KÊNH --}}
    <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Thêm kênh</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cc-payment" class="control-label mb-1">ID_kênh</label>
                                <input id="id_channel" name="id_channel" type="text" class="form-control" aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cc-payment" class="control-label mb-1">Tên kênh</label>
                                <input id="name" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cc-payment" class="control-label mb-1">Email</label>
                                <input id="email"  name="email" type="text" class="form-control" aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cc-payment" class="control-label mb-1">Số điện thoại</label>
                                <input id="phone" name="phone" type="text" class="form-control" aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cc-payment" class="control-label mb-1">Loại video</label>
                                <input id="type" name="type" placeholder="0: apk thường, 4: mac os, 5: apk search" type="text" class="form-control" aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button id="addChannel" type="button" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END THÊM MỚI --}}
</div>