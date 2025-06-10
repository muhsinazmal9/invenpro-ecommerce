@extends('backend.layouts.app')
@section('title', 'Edit Role')
@section('content')

    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ 'Edit Role' }}</h2>
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
                                        <a href="{{ route('admin.role.index') }}">{{ 'Roles' }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ 'Edit' }}
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
                        <form action="{{ route('admin.role.update', $role->id) }}" method="post">
                            @csrf
                            @method('patch')
                            <div class="row">
                                <div class="col-md-12">
                                    <x-input-group :type="'text'" :value="$role->name" :name="'name'" :placeholder="'Enter title of role'"
                                        :id="'name'">
                                        <span class="mdi mdi-account-child-circle"></span>
                                    </x-input-group>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mt-3">

                                    <h4>{{ 'Permissions' }}</h4>
                                    <hr>
                                </div>

                                @foreach ($permissions as $permission)
                                    <div class="col-md-2">
                                        @if ($permission->roles->pluck('id')->contains($role->id))
                                            <x-success-checkbox :id="$permission->id" :value="$permission->name" :name="'permissions[]'"
                                                :checked="'checked'">
                                                {{ Str::title($permission->name) }}
                                            </x-success-checkbox>
                                        @else
                                            <x-success-checkbox :id="$permission->id" :value="$permission->name" :name="'permissions[]'">
                                                {{ Str::title($permission->name) }}
                                            </x-success-checkbox>
                                        @endif
                                    </div>
                                @endforeach
                                @error('permissions')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                                <div class="col-md-12 mt-3">
                                    <x-primary-button :type="'submit'">
                                        {{ 'Update' }}
                                    </x-primary-button>
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
