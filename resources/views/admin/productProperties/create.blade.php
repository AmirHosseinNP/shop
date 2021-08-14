@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border px-15">
                    <h1 class="box-title">ویژگی‌های محصول {{ $product->name }}</h1>
                </div>
                <div class="box-body p-0">
                    <form action="{{ route('products.properties.store', $product) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @foreach($propertyGroups as $group)
                            <div class="row px-15">
                                <div class="col-sm-1 py-15 border-left border-bottom">
                                    <h3
                                        style="top: 50%; right: 50%; transform: translate(50%, -50%)"
                                        class="m-0 text-center position-absolute">
                                        {{ $group->title }}
                                    </h3>
                                </div>
                                <div class="col-sm-11 border-bottom">
                                    <div class="form-group">
                                        <div class="row">
                                            @foreach($group->properties as $property)
                                                <div class="col-sm-12 my-15">
                                                    <div class="row">
                                                        <div class="col-sm-2 px-0 align-self-center text-center">
                                                            <label class="mb-0"
                                                                   for="property-id-{{ $property->id }}">{{ $property->title }}
                                                                :</label>
                                                        </div>
                                                        <div class="col-sm-10" style="padding-right: 0;">
                                                            <input
                                                                value="{{ $product->getPropertyValue($property) }}"
                                                                type="text"
                                                                name="properties[{{ $property->id }}][value]"
                                                                id="property-id-{{ $property->id }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group px-30 my-15">
                            <input type="submit" value="ثبت" class="btn btn-primary">
                        </div>
                    </form>
                    @include('admin.layout.errors')
                </div>
            </div>
        </div>
    </div>
@endsection
