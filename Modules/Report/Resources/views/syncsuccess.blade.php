@extends('layouts.app')

@section('title')
    {{ $page_title }}
@endsection

<style type="text/css">
.dt-error-code {

    font-size: 4rem !important;
    
}


</style>

@section('content')
<div class="dt-content">

    <!-- Grid -->
    <div class="row">
        <div class="col-xl-12 pb-3">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                <li class="active breadcrumb-item">{{ $sub_title }}</li>
              </ol>
        </div>
        <!-- Grid Item -->
        <div class="col-xl-12">

            <!-- Entry Header -->
            <div class="dt-entry__header">

                <!-- Entry Heading -->
                <div class="dt-entry__heading">
                    <h2 class="dt-page__title mb-0 text-primary"><i class="{{ $page_icon }}"></i> {{ $sub_title }}</h2>
                </div>
                <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">

                    <!-- 404 Page -->
                    <div class="error-page text-center">

                        <!-- Title -->
                        <h3 class="dt-error-code">Synchronization Success</h3>
                        <!-- /title -->

                        <h4 class="mb-10">Data has been synced successfully</h4>

                        


                    </div>
                    <!-- /404 page -->
                </div>
                <!-- /card body -->

            </div>
            <!-- /card -->

        </div>
        <!-- /grid item -->

    </div>
    <!-- /grid -->

</div>

@endsection

