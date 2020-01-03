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
                @else($channel->type == 5)
                    <span class="badge badge-pill badge-dark">apk search</span>
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