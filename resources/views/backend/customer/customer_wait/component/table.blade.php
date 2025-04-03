<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Họ Tên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Mô tả</th>
            <th class="text-center">Loại cộng tác viên</th>
            <th class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($customers) && is_object($customers))
        @foreach($customers as $customer)
        <tr>
            <td>
                {{ $customer->name }}
            </td>
            <td>
                {{ $customer->email }}
            </td>
            <td>
                {{ $customer->phone }}
            </td>
            <td>
                {{ $customer->description }}
            </td>
            <td class="text-center">
            <form action="{{ route('customer.update1', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')
                <select name="customer_catalogue_id" class="form-control" onchange="this.form.submit()">
                    @foreach($customerCatalogues as $customerCatalogue)
                        <option value="{{ $customerCatalogue->id }}" 
                            {{ $customer->customer_catalogue_id == $customerCatalogue->id ? 'selected' : '' }}>
                            {{ $customerCatalogue->name }}
                        </option>
                    @endforeach
                </select>
            </form>

            </td>
            <td class="text-center">
            <a href="{{ route('customer.accept', $customer->id) }}" class="btn btn-success">
                <i class="fa fa-check"></i> Chấp nhận
            </a>
            <a href="{{ route('customer.reject', $customer->id) }}" class="btn btn-danger">
                <i class="fa fa-times"></i> Từ chối
            </a>

            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
{{ $customers->links('pagination::bootstrap-4') }}