<!DOCTYPE html>
<html lang="en">

    <head>
        @include('home.css')
    </head>

    <body>
        <!-- Spinner and Navbar start -->
        @include('master.navbar')
        <!-- Spinner and Navbar end -->


        <!-- Hero Start -->
        @include('home.header')
        <!-- Hero End -->

        <!-- Motto n fitur Start -->
        @include('home.fitur')
        <!-- Motto n fitur End -->

        <!-- Portfolio -->
        @include('home.portofolio')

    </br></br></br></br>
        <!-- Banner -->
        @include('home.banner')


    </br></br></br></br>
        <!-- Fact Start -->
        @include('home.tim')
        <!-- Fact End -->


        <!-- Footer Start -->
        @include('master.footer')
        <!-- Footer End -->




    </body>

</html>
