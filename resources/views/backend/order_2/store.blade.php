@include('backend.dashboard.component.breadcrumb', ['title' => 'Tạo đơn hàng mới'])
@include('backend.dashboard.component.formError')

<style>#product-list {
    max-height: 200px; 
    overflow-y: auto;
    border: 1px solid #ccc;
    padding: 10px;
}
.product-item {
    display: flex;
    align-items: center;
    gap: 10px; 
}

.product-item select,
.product-item input {
    flex: 1;
    min-width: 150px; 
}

.product-item button {
    flex-shrink: 0; 
}

</style>
<form action="{{ route('customer.order.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <h4>THÔNG TIN GIAO HÀNG</h4>
            <div class="form-group">
                <input type="text" name="fullname" class="form-control" placeholder="Nhập vào Họ Tên" required>
            </div>
            <div class="form-group">
                <input type="text" name="phone" class="form-control" placeholder="Nhập vào Số điện thoại" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Nhập vào Email" required>
            </div>
            <div class="form-group row">
    <div class="col-md-4">
        <select name="province_id" class="form-control province location setupSelect2" data-target="districts">
            <option value="0">[Chọn Thành Phố]</option>
            @foreach ($provinces as $key => $val)
                <option value="{{ $val->code }}">{{ $val->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <select name="district_id" class="form-control setupSelect2 districts location" data-target="wards">
            <option value="0">Chọn Quận Huyện</option>
        </select>
    </div>
    <div class="col-md-4">
        <select name="ward_id" class="form-control setupSelect2 wards">
            <option value="0">Chọn Phường Xã</option>
        </select>
    </div>
</div>

            <div class="form-group">
                <input type="text" name="address" class="form-control" placeholder="Địa chỉ chi tiết (Số nhà, ấp...)" required>
            </div>
            <div class="form-group">
                <textarea name="description" class="form-control" placeholder="Ghi chú"></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <h4>ĐƠN HÀNG</h4>
            <div class="form-group">
                <label for="products">Sản phẩm</label>
                <div id="product-list">
                    <div class="product-item d-flex align-items-center mb-2">
                        <select name="products[]" class="form-control product-select w-50" required>
                            <option value="">Chọn sản phẩm</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                    {{ $product->product_language->name }} - {{ number_format($product->price, 0, ',', '.') }} VND
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="quantities[]" class="form-control quantity-input ml-2 w-25" min="1" value="1" required>
                        <button type="button" class="btn btn-success ml-2 add-product">+</button>
                        <button type="button" class="btn btn-danger ml-2 remove-product">-</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="discount">Giảm giá</label>
                <input type="text" name="discount" class="form-control" id="discount" value="0" readonly>
            </div>
            <div class="form-group">
                <label for="shipping_fee">Phí giao hàng</label>
                <input type="text" name="shipping_fee" class="form-control" id="shipping_fee" value="Miễn phí" readonly>
            </div>
            <div class="form-group">
                <label for="total_price">Tổng tiền</label>
                <input type="text" name="total_price" class="form-control" id="total_price" readonly>
            </div>
            <button type="submit" class="btn btn-success">ĐẶT NGAY</button>
        </div>
    </div>
</form>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const productList = document.getElementById("product-list");

        function updateTotalPrice() {
            let totalPrice = 0;
            document.querySelectorAll(".product-item").forEach(item => {
                const select = item.querySelector(".product-select");
                const quantity = parseInt(item.querySelector(".quantity-input").value) || 1;
                const selectedOption = select.options[select.selectedIndex];

                if (selectedOption.value) {
                    const price = parseInt(selectedOption.getAttribute("data-price")) || 0;
                    totalPrice += price * quantity;
                }
            });
            document.getElementById("total_price").value = totalPrice.toLocaleString() + " VND";
        }

        document.addEventListener("click", function (event) {
            if (event.target.classList.contains("add-product")) {
                const newProduct = document.createElement("div");
                newProduct.classList.add("product-item", "d-flex", "align-items-center", "mb-2");
                newProduct.innerHTML = `
                    <select name="products[]" class="form-control product-select w-10" required>
                        <option value="">Chọn sản phẩm</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                {{ $product->product_language->name }} - {{ number_format($product->price, 0, ',', '.') }} VND
                            </option>
                        @endforeach
                    </select>
                    <input type="number" name="quantities[]" class="form-control quantity-input ml-2 w-25" min="1" value="1" required>
                    <button type="button" class="btn btn-success ml-2 add-product">+</button>
                    <button type="button" class="btn btn-danger ml-2 remove-product">-</button>
                `;
                productList.appendChild(newProduct);
                updateTotalPrice();
            }

            if (event.target.classList.contains("remove-product")) {
                const productItems = document.querySelectorAll(".product-item");
                if (productItems.length > 1) {
                    event.target.parentElement.remove();
                    updateTotalPrice();
                }
            }
        });

        document.addEventListener("change", function (event) {
            if (event.target.classList.contains("product-select") || event.target.classList.contains("quantity-input")) {
                updateTotalPrice();
            }
        });

        updateTotalPrice();
    });
</script>
