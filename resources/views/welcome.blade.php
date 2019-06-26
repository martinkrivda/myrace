<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Martin Křivda">
    <link rel="icon" href="favicon.ico">

    <title>MyRace / ChytrýOddíl</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('/css/bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
     <link href="{{ asset('/css/fontawesome5.css') }}" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous" rel="stylesheet" type="text/css" />
    <!-- Custom styles for this template -->
    <link href="{{ asset('/css/pricing.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/product.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/carousel.css') }}" rel="stylesheet">

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  </head>

  <body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
      <h5 class="my-0 mr-md-auto font-weight-normal"><img src="{{ asset('img/myrace_logo_black.png') }}" width="40%"></h5>
      <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="#features">Features</a>
        <a class="p-2 text-dark" href="#">Support</a>
        <a class="p-2 text-dark" href="#pricing">Pricing</a>
      </nav>
      <a class="btn btn-outline-primary" href="{{url('login')}}">Log in</a>
    </div>

        <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
      <div class="col-md-5 p-lg-5 mx-auto my-5">
        <h1 class="display-4 font-weight-normal">My<strong>Race</strong></h1>
        <p class="lead font-weight-normal">App for organizing and timing running races.<br />Make your race smartly simple with our low-cost solution.</p>
        <a class="btn btn-outline-secondary" href="{{url('login')}}">Coming soon</a>
      </div>
      <div class="product-device box-shadow d-none d-md-block"><p class="tag-number">6578923</p></div>
      <div class="product-device product-device-2 box-shadow d-none d-md-block"><p class="tag-number light">1359785</p></div>
    </div>

 <div class="container marketing">
     <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading"><a name="features">Organize races without worries. <span class="text-muted">Simply, smartly and automatically.</span></a></h2>
            <p class="lead">With our app, organizers don't have to be worried about it. You have always everything at hand and readily available. In&nbsp;addition, with chips you measure the race with your feet on the table.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" src="{{ asset('img/myrace_registration.png') }}" alt="Generic placeholder image">
          </div>
        </div>
      </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <h1 class="display-4"><a name="pricing">Pricing</a></h1>
      <p class="lead">Build an effective application for our potential customers. It's build only as example for landing page. The prices are not real.</p>
    </div>

    <div class="container">
      <div class="card-deck mb-3 text-center">
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Free</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">0Kč <small class="text-muted">/ race</small></h1>
            <ul class="list-unstyled mt-3 mb-4">
              <li>5 users included</li>
              <li>up to 200 registrations</li>
              <li>Email support</li>
              <li>&nbsp;</li>
            </ul>
            <button type="button" class="btn btn-lg btn-block btn-outline-primary">Sign up for free</button>
          </div>
        </div>
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Pro</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">999Kč <small class="text-muted">/ race</small></h1>
            <ul class="list-unstyled mt-3 mb-4">
              <li>10 users included</li>
              <li>up to 1000 registrations</li>
              <li>Phone & email support</li>
              <li>Help center access</li>
            </ul>
            <button type="button" class="btn btn-lg btn-block btn-primary">Get started</button>
          </div>
        </div>
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Service</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">3999Kč <small class="text-muted">/ race</small></h1>
            <ul class="list-unstyled mt-3 mb-4">
              <li>20 users included</li>
              <li>registrations not limited</li>
              <li>Phone and email support</li>
              <li>specialist in the place</li>
            </ul>
            <button type="button" class="btn btn-lg btn-block btn-primary">Contact us</button>
          </div>
        </div>
      </div>

      <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
          <div class="col-12 col-md">
            <img class="mb-2" src="{{ asset('img/logo_sm.png') }}" alt="MyRace logo" width="24">
            <small class="d-block mb-3 text-muted">&copy; 2018-2019</small>
          </div>
          <div class="col-6 col-md">
            <h5>Features</h5>
            <ul class="list-unstyled text-small">
              <li><a class="text-muted" href="#">Cool stuff</a></li>
              <li><a class="text-muted" href="#">Team feature</a></li>
              <li><a class="text-muted" href="#">Stuff for developers</a></li>
            </ul>
          </div>
          <div class="col-6 col-md">
            <h5>About us</h5>
            <ul class="list-unstyled text-small">
              <li><a class="text-muted" href="https://github.com/martinkrivda/myrace">See code at GitHub</a></li>
              <li><a class="text-muted" href="#">Team</a></li>
              <li><a class="text-muted" href="#">Privacy</a></li>
              <li><a class="text-muted" href="#">Terms</a></li>
            </ul>
          </div>
          <div class="col-6 col-md">
            <h5>Connect with us</h5>
            <ul class="list-unstyled text-small">
              <li><a class="text-muted" href="#"><i class="fab fa-facebook-f"></i> Facebook</a></li>
              <li><a class="text-muted" href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
              <li><a class="text-muted" href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
              <li><a class="text-muted" href="#"><i class="fab fa-medium-m"></i> Medium</a></li>
            </ul>
          </div>
        </div>
      </footer>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../../../assets/js/vendor/popper.min.js"></script>
    <script src="../../../../dist/js/bootstrap.min.js"></script>
    <script src="../../../../assets/js/vendor/holder.min.js"></script>-->
    @section('scripts')
        @include('adminlte::layouts.partials.scripts')
    @show
    <script>
      Holder.addTheme('thumb', {
        bg: '#55595c',
        fg: '#eceeef',
        text: 'Thumbnail'
      });
    </script>
  </body>
</html>
