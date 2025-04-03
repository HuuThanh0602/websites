<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>{{ __('Tên nhóm giá') }}</th>
            <th>{{ __('Chiết khấu') }}</th>
            <th>{{ __('Phí vận chuyển') }}</th>
            <th>Thời gian cập nhật</th>
            <th class="text-center" style="width:100px;">{{ __('Hành động') }}</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($price_groups) && $price_groups->count() > 0)

        @foreach($price_groups as $group)
        <tr id="row-{{ $group->price_group_id }}">
            <td>{{ $group->name }}</td>
            <td class="text-left">{{ number_format($group->exchange_rate) }}</td>
            <td class="text-left">{{ number_format($group->shipping) }}</td>
            <td class="text-left">{{$group->updated_at }}</td>
            <td class="text-center">
                <a href="{{ route('price_group.edit', [$group->id, $queryUrl ?? '']) }}" class="btn btn-success">
                    <i class="fa fa-edit"></i>
                </a>
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="10" class="text-center">Không có dữ liệu</td>
        </tr>
        @endif
    </tbody>
</table>
{{ $price_groups->links('pagination::bootstrap-4') }}