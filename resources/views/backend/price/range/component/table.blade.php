@php
$query = base64_encode(http_build_query(request()->query()));
$queryUrl = rtrim($query, '=');
@endphp

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width:50px;">
                <input type="checkbox" id="checkAll" class="input-checkbox">
            </th>
            <th>{{ __('Thương hiệu & Dải giá') }}</th>
            <th>Dải giá</th>
            <th>{{ __('Loại giá trị') }}</th>
            <th>{{ __('Giá trị') }}</th>
            <th class="text-center" style="width:100px;">{{ __('Hành động') }}</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($price_ranges) && $price_ranges->count() > 0)
        @php
        $groupedBrands = $price_ranges->groupBy('brand_name')->sortKeys(); // Sắp xếp theo thương hiệu
        @endphp

        @foreach($groupedBrands as $brand_name => $brandRanges)
        {{-- Hiển thị thương hiệu --}}
        <tr>
            <td><input type="checkbox" class="input-checkbox checkBoxItem" disabled></td>
            <td colspan="5"><strong>|--- {{ $brand_name ?? 'N/A' }}</strong></td>
        </tr>

        @php
        $groupedSubs = $brandRanges->groupBy('sub_name')->sortKeys(); // Sắp xếp theo dải giá
        @endphp

        @foreach($groupedSubs as $sub_name => $priceRanges)
        {{-- Hiển thị dải giá --}}
        <tr>
            <td><input type="checkbox" class="input-checkbox checkBoxItem" disabled></td>
            <td colspan="4">|---|--- {{ $sub_name }}</td>
            <td class="text-center">
                <!-- Thêm nút sửa cho dải giá với ID của sub_name -->
                <a href="{{ route('sub_price_range.edit', [$sub_name, $queryUrl ?? '']) }}" class="btn btn-primary">
                    <i class="fa fa-edit"></i> Sửa
                </a>
            </td>
        </tr>

        @foreach($priceRanges->sortBy('name') as $priceRange) {{-- Sắp xếp theo tên dải giá --}}
            {{-- Hiển thị cấp con (price_ranges->name) --}}
            <tr id="row-{{ $priceRange->id }}">
                <td>
                    <input type="checkbox" value="{{ $priceRange->id }}" class="input-checkbox checkBoxItem">
                </td>
                <td>|---|---|--- {{ $priceRange->name }}</td>
                <td>
                    @if(fmod($priceRange->range_from, 1) == 0 && fmod($priceRange->range_to, 1) == 0)
                        {{ number_format($priceRange->price_min, 0, '.', '.') }}VNĐ - {{ number_format($priceRange->price_max, 0, '.', '.') }}VNĐ
                    @else
                        {{ number_format($priceRange->price_min, 2, '.', '.') }}VNĐ - {{ number_format($priceRange->price_max, 2, '.', '.') }}VNĐ
                    @endif
                </td>
                <td>
                    @if ($priceRange->value_type == 'percentage')
                        Phần trăm (%)
                    @else
                        Giá trị cố định
                    @endif
                </td>
                <td class="text-right">
                    @if(fmod($priceRange->value, 1) == 0)
                        {{ number_format($priceRange->value, 0, '.', '.') }}
                    @else
                        {{ number_format($priceRange->value, 2, '.', '.') }}
                    @endif
                </td>
                <td class="text-center">
                    <!-- <a href="{{ route('price_range.edit', [$priceRange->price_range_id, $queryUrl ?? '']) }}" class="btn btn-success">
                        <i class="fa fa-edit"></i>
                    </a>
                    <form action="{{ route('price_range.destroy', $priceRange->price_range_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form> -->
                </td>
            </tr>
        @endforeach
        @endforeach
        @endforeach
        @else
        <tr>
            <td colspan="6" class="text-center">Không có dữ liệu</td>
        </tr>
        @endif
    </tbody>
</table>
