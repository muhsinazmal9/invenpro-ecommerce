@extends('backend.layouts.app')
@section('title', __('app.news_letter'))
@section('content')

    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">

                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ __('app.news_letter') }}</h2>
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
                                    <li class="breadcrumb-item ">
                                        <a href="{{ route('admin.newsletter.index') }}">{{ __('app.news_letter') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ __('app.create') }}
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
                <div class="col-md-12">
                    <div class="card-style">
                        <form action="{{ route('admin.newsletter.store.mail') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 my-2">
                                    <label for="to_emails" class="mb-1"><strong>{{ __('app.to') }}</strong></label>
                                    <input type="text" id="to_emails" name="to_emails" class="form-control hideMe"
                                        placeholder="{{ __('app.enter_to_emails') }}" />

                                    @error('to_emails')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 my-2">
                                    @if (old('select_all'))
                                        <x-success-checkbox :id="'select_all'" :checked="true" :value="1"
                                            :name="'select_all'">
                                            {{ __('app.select_all') }}
                                        </x-success-checkbox>
                                    @else
                                        <x-success-checkbox :id="'select_all'" :value="1" :name="'select_all'">
                                            {{ __('app.select_all') }}
                                        </x-success-checkbox>
                                    @endif
                                    @error('select_all')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 my-2">
                                    <label for="subject" class="mb-1"><strong>{{ __('app.subject') }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('subject')" :name="'subject'" :placeholder="__('app.enter_the_subject')"
                                        :id="'subject'">
                                    </x-input-group>

                                    @error('subject')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mt-2">

                                    <label for="body" class="mb-1"><strong>{{ __('app.body') }}</strong></label>

                                    <textarea name="body" id="body" class="form-control" rows="5">{{ old('body') }}</textarea>

                                    @error('body')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mt-3">
                                    <input class="main-btn primary-btn btn-hover btn-sm " type="submit" name="status"
                                        value="Send">
                                    <input class="main-btn secondary-btn btn-hover btn-sm " type="submit" name="status"
                                        value="Draft">

                                </div>
                            </div>
                        </form>
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
        $(".select2").select2();
        $(document).ready(function() {
            $('#body').summernote({
                height: 400,

                toolbar: [
                    // hide font family button
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph', 'style']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });


        });

        var inputElem = document.querySelector(
            '#to_emails')

        const subscriberEmails = @json($subscribers);
        console.log(subscriberEmails)
        var tagify = new Tagify(inputElem, {
            whitelist: subscriberEmails,
            dropdown: {
                classname: "color-blue",
                enabled: 0, // show the dropdown immediately on focus
                maxItems: 5,
            },
            enforceWhitelist: true,
        })

        const selectAllCheckbox = document.getElementById('select_all');
        const toInput = document.getElementById('to');

        selectAllCheckbox.addEventListener('change', function() {

            if (this.checked) {
                $(".hideMe").attr('disabled', true)
                toInput.hidden = true;
            } else {
                $(".hideMe").removeAttr('disabled')
            }
        });
    </script>
@endpush
