<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th>Tên chương trình</th>

            <th>Thông tin</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th class="text-center">Tình Trạng</th>
            <th>Chi tiết</th>
            <th class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($promotions) && is_object($promotions))
        @foreach($promotions as $key => $promotion)
        @php
        $startDate = convertDateTime($promotion->startDate);
        $endDate = convertDateTime($promotion->endDate);
        $status = '';
        if($promotion->endDate != NULL && strtotime($promotion->endDate) - strtotime(now()) <= 0){
            $status='<span class="text-danger text-small">- Hết Hạn</span>' ;
            }
            @endphp
            <tr>
            <td>
                <input type="checkbox" value="{{ $promotion->id }}" class="input-checkbox checkBoxItem">
            </td>
            <td>
                <div>{{ $promotion->name }} {!! $status !!} </div>
                <div class="text-small text-success">Mã: {{ $promotion->code }}</div>
            </td>

            <td>
                <div>{{ __('module.promotion')[$promotion->method] }}</div>

            </td>
            <td>
                {{ $startDate }}
            </td>
            <td>
                {{ ($promotion->neverEndDate === 'accept') ? 'Không giới hạn' : $endDate; }}
            </td>
            @php
            $now = now(); // Lấy thời gian hiện tại
            $startDate = \Carbon\Carbon::parse($promotion->startDate);
            $endDate = \Carbon\Carbon::parse($promotion->endDate);

            if ($now->lt($startDate)) {
            $statusText = 'Sắp diễn ra';
            $statusClass = 'text-warning'; // Màu vàng
            } elseif ($now->between($startDate, $endDate)) {
            $statusText = 'Đang diễn ra';
            $statusClass = 'text-success'; // Màu xanh
            } else {
            $statusText = 'Đã hết hạn';
            $statusClass = 'text-danger'; // Màu đỏ
            }
            @endphp

            <td class="text-center {{ $statusClass }}">
                {{ $statusText }}
            </td>

            <td>
                <div class="discount-information " style="max-width: 150px;">

                    Giảm {{ $promotion['discountInformation']['info']['amountValue'][0] }}
                    cho đơn tối thiểu {{ $promotion['discountInformation']['info']['amountFrom'][0] }}
                    tối đa {{ $promotion['discountInformation']['info']['amountTo'][0] }}

                </div>
            </td>
            <td class="text-center">
                <a href="{{ route('promotion.edit', $promotion->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                <a href="{{ route('promotion.delete', $promotion->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
            </td>
            </tr>
            @endforeach
            @endif
    </tbody>
</table>
{{ $promotions->links('pagination::bootstrap-4') }}