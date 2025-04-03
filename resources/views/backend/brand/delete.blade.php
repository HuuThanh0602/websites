@include('backend.dashboard.component.breadcrumb', ['title' =>'Xoá thương hiệu'])
@include('backend.dashboard.component.formError')
<form action="{{ route('brand.destroy', $productBrand->id) }}" method="post" class="box">
    @include('backend.dashboard.component.destroy', ['model' => ($productBrand) ?? null])
</form>
