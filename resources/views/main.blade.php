<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko Paramonth</title>
    <link rel="shortcut icon" type="image/x-icon" href="/1.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/../../plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="/dist/css/karusel.css">
    <style>
      
    </style>
  </head>
  
  <body >
    <div class="wrapper">
    @include('navbar')
    <div class="container mt-4" style="min-height: 65vh;">
      @yield('container')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="/../../plugins/summernote/summernote-bs4.min.js"></script>
    <script>
      $(function () {
        // Summernote
        $('#summernote').summernote()
      })
    </script>
    @yield('scripts')
    @include('footer')
    </div>
  </body>
  
</html>