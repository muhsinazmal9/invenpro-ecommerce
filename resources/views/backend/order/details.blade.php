@extends('backend.layouts.app')
@section('title', __('app.order_details'))
@section('content')

<!-- ========== section start ========== -->
<section class="section">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">

                <div class="col-md-6">
                    <div class="title">
                        <h2>{{ __('app.order') }} #<span>{{ $order->invoice_id }}</span></h2>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item ">
                                    <a href="{{ route('admin.dashboard.index') }}">{{ 'Dashboard' }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="{{ route('admin.orders.index') }}">{{ __('app.orders') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('app.order_details') }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- ========== title-wrapper end ========== -->
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="card-style">
                            <div
                                class="p-3 bg-secondary-subtle rounded mb-3 d-flex flex-column gap-2 flex-md-row justify-content-between align-items-center">
                                <div>
                                    <h6>{{ __('app.all_items') }}:</h6>
                                </div>
                                <div class="d-flex flex-md-row gap-2">
                                    <a href="{{ route('admin.orders.invoice.pdf.download', $order->id) }}"
                                        class="main-btn primary-btn-outline square-btn btn-hover btn-sm"><i
                                            class="lni lni-cloud-download"></i>{{ __('app.download_invoice') }}</a>
                                    <a target="_blank" href="{{ route('admin.orders.invoice.pdf.stream', $order->id) }}"
                                        class="main-btn primary-btn square-btn btn-hover btn-sm"><i
                                            class="lni lni-printer"></i>{{ __('app.print_invoice') }}</a>
                                </div>
                            </div>
                            <div class="table-wrapper table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <h6>{{ __('app.product_name') }}</h6>
                                            </th>
                                            <th>
                                                <h6>{{ __('app.variation') }}</h6>
                                            </th>
                                            <th>
                                                <h6>{{ __('app.quantity') }}</h6>
                                            </th>
                                            <th>
                                                <h6>{{ __('app.price') }}</h6>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->products as $product)
                                        <tr>
                                            @php
                                            $productData = json_decode($product->product_json, true);
                                            @endphp
                                            <td class="min-width d-flex align-items-center gap-2">
                                                <img style="width: 50px" src="{{ asset($productData['thumbnail']) }}"
                                                    alt="{{ $productData['title'] }}">
                                                <p>{{ $productData['title'] }}</p>
                                            </td>
                                            <td class="min-width">
                                                <p>
                                                    @foreach (json_decode($product->meta) as $key => $item)
                                                    {{ $item->value }}
                                                    {{ count(json_decode($product->meta)) - 1 > $key ? ',' : '' }}
                                                    @endforeach
                                                </p>
                                            </td>
                                            <td class="min-width">
                                                <p>{{ $product->quantity }}x</p>
                                            </td>
                                            <td class="min-width">
                                                <p>{{ getSetting('currency_symbol') . number_format($product->price, 2)
                                                    }}
                                                    @if (!empty($productData['tax']['rate']))
                                                    (+ {{ $productData['tax']['rate'] }}% {{ __('app.tax') }})
                                                    @endif


                                                </p>
                                            </td>
                                        </tr>
                                        @php
                                        $review = $order->reviews
                                        ->where('product_id', $productData['id'])
                                        ->first();
                                        @endphp
                                        @if ($review)
                                        <tr>
                                            <td>
                                                <div class="ms-5">
                                                    <p class="mb-1"><strong>Review</strong> <sub><i
                                                                class="fa-solid fa-arrow-turn-down fa-fw"></i></sub>
                                                    </p>

                                                    <div class="ms-2">

                                                        <p>
                                                            {{ $review->created_at->format('d/m/Y h:i A') }}
                                                        </p>

                                                        <p>
                                                            @for ($i = 0; $i < (int) $review->rating; $i++)
                                                                <i class="fas fa-star text-warning"></i>
                                                                @endfor

                                                                @if ($review->ratting - (int) $review->rating > 0.5)
                                                                <i
                                                                    class="fa-solid fa-star-half-stroke text-warning"></i>
                                                                @endif

                                                                @for ($i = 0; $i < 5 - round($review->rating); $i++)
                                                                    <i class="far fa-star text-warning"></i>
                                                                    @endfor
                                                        </p>

                                                        <div class="comment mt-2">
                                                            <p>
                                                                {{ $review->comment }}
                                                            </p>
                                                        </div>
                                                    </div>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-4">
                        <div class="card-style">
                            <ul class="p-3 bg-secondary-subtle rounded">
                                <li style="width: 41vw" class="d-inline-block">
                                    <h6>{{ __('app.cart_totals') }}</h6>
                                </li>
                                <li class="d-inline-block">
                                    <h6>{{ __('app.price') }}</h6>
                                </li>
                            </ul>
                            <div class="table-wrapper table-responsive">
                                <table class="table p-2">
                                    <tbody>
                                        <tr>
                                            <td style="width: 50rem">
                                                <p>{{ __('app.subtotal') }}</p>
                                            </td>
                                            <td class="min-width">
                                                <p>{{ getSetting('currency_symbol') . number_format($order->subtotal, 2)
                                                    }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50rem">
                                                <p>{{ __('app.shipping_charge') }}</p>
                                            </td>
                                            <td class="min-width">
                                                <p>{{ getSetting('currency_symbol') .
                                                    number_format($order->shipping_charge, 2) }}
                                                </p>
                                            </td>
                                        </tr>
                                        @if ($order->gift_wrapper_charge)
                                        <tr>
                                            <td style="width: 50rem">
                                                <p>{{ __('app.gift_wrapper_charge') }}</p>
                                            </td>
                                            <td class="min-width">

                                                <p>{{ getSetting('currency_symbol') .
                                                    number_format($order->gift_wrapper_charge, 2) }}
                                                </p>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td style="width: 50rem">
                                                <p>{{ __('app.service_charge') }}</p>
                                            </td>
                                            <td class="min-width">

                                                <p>{{ getSetting('currency_symbol') .
                                                    number_format($order->service_amount, 2) }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50rem">
                                                <p>{{ __('app.discount') }}</p>
                                            </td>
                                            <td class="min-width">
                                                <p>{{ getSetting('currency_symbol') . number_format($order->discount, 2)
                                                    }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50rem">
                                                <p>{{ __('app.tax') }}</p>
                                            </td>
                                            <td class="min-width">
                                                <p>{{ getSetting('currency_symbol') . number_format($order->tax, 2) }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50rem">
                                                <p class="fw-semibold">{{ __('app.total_price') }}</p>
                                            </td>
                                            <td class="min-width">
                                                <p class="fw-semibold">
                                                    {{ getSetting('currency_symbol') .
                                                    number_format($order->grand_total, 2) }}
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 mb-4" @if (!$order->transaction) style="display: none" @endif>
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="card-style">
                                    <h6 class="pb-3">{{ __('app.transactions') }}</h6><br>
                                    <div class="row">
                                        <div class=" col-md-3 d-flex gap-3  ">
                                            <img style="width: 20%" src="{{ asset('assets/backend/images/logo/314420.png') }}" class="rounded-circle" alt="{{ $order->name }}">
                                            <div>
                                                <p> <strong>{{ __('app.payment_method') }}</strong></p>
                                                @if ($order->transaction?->payment_method==1)
                                                <p> <strong> {{ __('app.cod') }}</strong></p>
                                                @endif
                                                @if($order->transaction?->payment_method==2)
                                                <p><strong>  {{ __('app.online') }}</strong></p>
                                                @endif
                                                @if($order->transaction?->payment_method==3)
                                                <p><strong>  {{ __('app.bkash') }}</strong></p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-3 mt-md-0">
                                            <p>{{ __('app.status') }}</p>
                                            @if ($order->transaction?->status==1)
                                            <p> <strong> {{ __('app.pending') }}</strong></p>
                                            @endif
                                            @if($order->transaction?->status==2)
                                            <p><strong> {{ __('app.failed') }}</strong></p>
                                            @endif
                                            @if($order->transaction?->status==3)
                                            <p><strong> {{ __('app.success') }}</strong></p>
                                            @endif
                                            @if($order->transaction?->status==4)
                                            <p><strong> {{ __('app.cancel') }}</strong></p>
                                            @endif

                                        </div>
                                        <div class="col-md-3 mt-3 mt-md-0">
                                            <p>{{ __('app.date') }}</p>
                                            <p><strong>{{ $order->transaction?->created_at?->format('d M Y , h:i A') }}</strong>
                                            </p>
                                        </div>
                                        <div class="col-md-3 mt-3 mt-md-0">
                                            <p>{{ __('app.amount') }}</p>
                                            <p><strong>{{ getSetting('currency_symbol') .$order->transaction?->amount}}</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <a href="{{ route('admin.users.show',$order->user) }}" style="width: 100%;">
                            <div class="card-style">
                                <h6 class="pb-3">{{ __('app.user_details') }}</h6><br>
                                <div class="d-flex gap-3">
                                    <img style="width: 20%" src="{{ asset($order->user->image) }}" class="rounded-circle"
                                        alt="{{ $order->name }}">
                                    <div>
                                        <p>{{ $order->user->name }}</p>
                                        <p>{{ $order->user->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-12 mb-4">
                        <div class="card-style">
                            <h6>{{ __('app.summary') }}</h6>
                            <div class="table-wrapper table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <p>{{ __('app.invoice_id') }}</p>
                                            </td>
                                            <td>
                                                <p class="fw-semibold">#{{ $order->invoice_id }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>{{ __('app.payment_status') }}</p>
                                            </td>
                                            <td>
                                                <p onclick="updatePaymentStatus({{ $order->id }})"
                                                    class="fw-semibold cursor-pointer text-{{ getPaymentStatusColor($order->payment_status) }}">
                                                    {{ ucwords($order->payment_status) }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>{{ __('app.order_status') }}</p>
                                            </td>
                                            <td>
                                                <p onclick="updateStatus({{ $order->id }})"
                                                    class="fw-semibold cursor-pointer text-{{ getOrderStatusColor($order->order_status) }}">
                                                    {{ ucwords($order->order_status) }}
                                                </p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <p>{{ __('app.cancel_order_request') }}</p>
                                            </td>
                                            <td>
                                                <p onclick="updateCancelStatus({{ $order->id }})"
                                                    class="fw-semibold cursor-pointer text-{{ getCancelRequestStatusColor($order->is_cancel_request) }}">
                                                    {{ getCancelRequestStatus($order->is_cancel_request) }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>{{ __('app.gift') }}</p>
                                            </td>
                                            <td>
                                                <p onclick="updateGiftStatus({{ $order->id }})"
                                                    class="fw-semibold cursor-pointer  }} ">
                                                    {{ ucwords($order->is_gift ? __('app.yes'):__('app.no')) }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>{{ __('app.date') }}</p>
                                            </td>
                                            <td>
                                                <p class="fw-semibold">{{ $order->created_at?->format('D, d M Y') }}
                                                </p>
                                            </td>
                                        </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="card-style">
                                <h6 class="pb-3">{{ __('app.shipping_address') }}</h6>
                                @if(is_array($shipping_address) || is_object($shipping_address))
                                @forelse ($shipping_address as $key => $value)

                                    @php
                                        $key = str_replace(['shipping_', 'billing_'], '', $key);
                                    @endphp

                                    <p class="my-2 border-bottom pb-2">
                                        {{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</p>
                                @empty
                                    <p>{{ __('app.no_address') }}</p>
                                @endforelse
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="card-style">
                                <h6 class="pb-3">{{ __('app.billing_address') }}</h6>
                                @if(is_array($billing_address) || is_object($billing_address))
                               @forelse ($billing_address as $key => $value)

                                    @php
                                        $key = str_replace(['shipping_', 'billing_'], '', $key);
                                    @endphp

                                    <p class="my-2 border-bottom pb-2">{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</p>
                                @empty
                                <p>{{ __('app.no_address') }}</p>
                                @endforelse
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="card-style">
                                <h6 class="pb-3">{{ __('app.delivery_instruction') }}</h6>
                                <p>{{ $order->delivery_instruction }}</p>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="card-style">
                                <h6 class="mb-2">{{ __('app.payment_method') }}</h6>
                                <p class="mb-4">{{ $order->payment_method }}</p>
                                <h6 class="mb-2">{{ __('app.payment_status') }}</h6>
                                <p>{{ $order->payment_status }}</p>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="card-style">
                                <h6 class="pb-3">{{ __('app.expected_date_of_delivery') }}</h6>
                                <p class="text-success">{{ $order->delivery_date?->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- end container -->
    </section>
    <!-- ========== section end ========== -->

@endsection
@push('script')
<script>
    function updateStatus(orderId) {

            Swal.fire({
                title: "Select Status",
                input: "select",
                inputOptions: {
                    "{{ App\Models\Order::ORDER_STATUS['placed'] }}": "{{ Str::ucfirst(App\Models\Order::ORDER_STATUS['placed']) }}",
                    "{{ App\Models\Order::ORDER_STATUS['approved'] }}": "{{ Str::ucfirst(App\Models\Order::ORDER_STATUS['approved']) }}",
                    "{{ App\Models\Order::ORDER_STATUS['shipped'] }}": "{{ Str::ucfirst(App\Models\Order::ORDER_STATUS['shipped']) }}",
                    "{{ App\Models\Order::ORDER_STATUS['delivered'] }}": "{{ Str::ucfirst(App\Models\Order::ORDER_STATUS['delivered']) }}",
                    "{{ App\Models\Order::ORDER_STATUS['cancelled'] }}": "{{ Str::ucfirst(App\Models\Order::ORDER_STATUS['cancelled']) }}",
                },
                showCancelButton: true,
                confirmButtonText: "{{ __('app.confirm') }}",
                allowOutsideClick: () => !Swal.isLoading(),
                showLoaderOnConfirm: true,

            }).then((status) => {
                if (status.isConfirmed) {

                    Swal.fire({
                        title: "{{ __('app.loading') }}",
                        text: "{{ __('app.please_wait') }}",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading()
                        },
                    });

                    let url = "{{ route('admin.orders.status', ':id') }}";
                    url = url.replace(':id', orderId);
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    $.ajax({
                        url: url,
                        type: "PATCH",
                        data: {
                            status: status.value,
                            _token: token
                        },
                        success: function(response) {
                            if (response.success) {

                                setTimeout(() => {
                                    Swal.fire({
                                        title: "{{ __('app.updated') }}",
                                        text: response.message,
                                        icon: "success",
                                        allowOutsideClick: false,
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                }, 1000);

                            } else {

                                setTimeout(() => {
                                    Swal.fire({
                                        title: "{{ __('app.error') }}",
                                        text: response.message,
                                        icon: "error",
                                    });
                                }, 1000);

                            }
                        },
                        error: function(response) {
                            setTimeout(() => {
                                Swal.fire({
                                    title: "{{ __('app.error') }}",
                                    text: response.message,
                                    icon: "error",
                                });
                            }, 1000);

                            console.log(response);
                        }
                    });
                }
            });
        }

        function updatePaymentStatus(orderId) {

            Swal.fire({
                title: "Select Status",
                input: "select",
                inputOptions: {
                    "{{ App\Models\Order::PAYMENT_STATUS['pending'] }}": "{{ Str::ucfirst(App\Models\Order::PAYMENT_STATUS['pending']) }}",
                    "{{ App\Models\Order::PAYMENT_STATUS['paid'] }}": "{{ Str::ucfirst(App\Models\Order::PAYMENT_STATUS['paid']) }}",
                },
                showCancelButton: true,
                confirmButtonText: "{{ __('app.confirm') }}",
                allowOutsideClick: () => !Swal.isLoading(),
                showLoaderOnConfirm: true,

            }).then((status) => {
                if (status.isConfirmed) {

                    Swal.fire({
                        title: "{{ __('app.loading') }}",
                        text: "{{ __('app.please_wait') }}",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading()
                        },
                    });

                    let url = "{{ route('admin.orders.payment.status', ':id') }}";
                    url = url.replace(':id', orderId);
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    $.ajax({
                        url: url,
                        type: "PATCH",
                        data: {
                            status: status.value,
                            _token: token
                        },
                        success: function(response) {
                            if (response.success) {

                                setTimeout(() => {
                                    Swal.fire({
                                        title: "{{ __('app.updated') }}",
                                        text: response.message,
                                        icon: "success",
                                        allowOutsideClick: false,
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                }, 1000);

                            } else {

                                setTimeout(() => {
                                    Swal.fire({
                                        title: "{{ __('app.error') }}",
                                        text: response.message,
                                        icon: "error",
                                    });
                                }, 1000);

                            }
                        },
                        error: function(response) {
                            setTimeout(() => {
                                Swal.fire({
                                    title: "{{ __('app.error') }}",
                                    text: response.message,
                                    icon: "error",
                                });
                            }, 1000);

                            console.log(response);
                        }
                    });
                }
            });
        }
        function updateGiftStatus(orderId) {

            Swal.fire({
                title: "Select Status",
                input: "select",
                inputOptions: {
                    "{{ App\Models\Order::GIFT_STATUS['yes'] }}":"{{ __('app.yes') }}",
                   "{{ App\Models\Order::GIFT_STATUS['no'] }}":"{{ __('app.no') }}",
                },
                showCancelButton: true,
                confirmButtonText: "{{ __('app.confirm') }}",
                allowOutsideClick: () => !Swal.isLoading(),
                showLoaderOnConfirm: true,

            }).then((status) => {
                if (status.isConfirmed) {

                Swal.fire({
                    title: "{{ __('app.loading') }}",
                    text: "{{ __('app.please_wait') }}",
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                    Swal.showLoading()
                    },
                });

                let url = "{{ route('admin.orders.gift.status', ':id') }}";
                url = url.replace(':id', orderId);
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                $.ajax({
                url: url,
                type: "PATCH",
                data: {
                    status: status.value,
                    _token: token
                },
                success: function(response) {
                if (response.success) {

                setTimeout(() => {
                    Swal.fire({
                        title: "{{ __('app.updated') }}",
                        text: response.message,
                        icon: "success",
                        allowOutsideClick: false,
                    }).then(() => {
                    window.location.reload();
                    });
                }, 1000);

                } else {

                setTimeout(() => {
                    Swal.fire({
                        title: "{{ __('app.error') }}",
                        text: response.message,
                        icon: "error",
                    });
                }, 1000);

                }
                },
                error: function(response) {
                setTimeout(() => {
                    Swal.fire({
                        title: "{{ __('app.error') }}",
                        text: response.message,
                        icon: "error",
                    });
                }, 1000);

                console.log(response);
                }
            });
            }
            });
        }


        function updateCancelStatus(orderId) {

            Swal.fire({
                title: "Select",
                input: "select",
                inputOptions: {
                    "2": "Approve",
                    "3": "Reject",
                },
                showCancelButton: true,
                confirmButtonText: "{{ __('app.confirm') }}",
                allowOutsideClick: () => !Swal.isLoading(),
                showLoaderOnConfirm: true,

            }).then((status) => {
                if (status.isConfirmed) {

                    Swal.fire({
                        title: "{{ __('app.loading') }}",
                        text: "{{ __('app.please_wait') }}",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading()
                        },
                    });

                    let url = "{{ route('admin.orders.cancel.request.update', ':id') }}";
                    url = url.replace(':id', orderId);
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    $.ajax({
                        url: url,
                        type: "PATCH",
                        data: {
                            status: status.value,
                            _token: token
                        },
                        success: function(response) {
                            if (response.success) {

                                setTimeout(() => {
                                    Swal.fire({
                                        title: "{{ __('app.updated') }}",
                                        text: response.message,
                                        icon: "success",
                                        allowOutsideClick: false,
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                }, 1000);

                            } else {

                                setTimeout(() => {
                                    Swal.fire({
                                        title: "{{ __('app.error') }}",
                                        text: response.message,
                                        icon: "error",
                                    });
                                }, 1000);

                                console.log(response);

                            }
                        },
                        error: function(response) {
                            setTimeout(() => {
                                Swal.fire({
                                    title: "{{ __('app.error') }}",
                                    text: response.message,
                                    icon: "error",
                                });
                            }, 1000);
                            console.log(response);

                        }
                    });
                }
            });
        }
</script>
@endpush
