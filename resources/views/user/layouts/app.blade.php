<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ config('app.name', 'Sistem Manajemen Komunitas') }} - @yield('title')</title>

    @include('user.layouts.css')
    @yield('header')

</head>

<body id="page-top">
        <div class="berhasil" data-berhasil="{{ Session::get('success')}}"></div>
        <div class="gagal" data-gagal="{{ Session::get('error')}}"></div>
    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('user.layouts.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                @include('user.layouts.navbar')
                @yield('content')
            </div>
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Ganatech.ID @php
                            echo date('Y');
                        @endphp</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    @include('user.layouts.js')
    @yield('footer')
</body>

</html>
