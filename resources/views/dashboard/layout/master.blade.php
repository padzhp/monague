<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="application/xhtml+xml" charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Startmin - Bootstrap Admin Theme</title>
    
    <!-- MetisMenu CSS -->
    <link href="{{asset('css/metisMenu.min.css')}}" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="{{asset('css/timeline.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{asset('css/dashboard.css')}}" rel="stylesheet">
    <link href="{{asset('css/dashboard-custom.css')}}" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="{{asset('css/morris.css')}}" rel="stylesheet">
	
	 <!-- DataTables CSS -->
	<link href="{{asset('css/dataTables/dataTables.bootstrap.css')}}" rel="stylesheet">

	<!-- DataTables Responsive CSS -->
	<link href="{{asset('css/dataTables/dataTables.responsive.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

     @yield('styles')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-monague navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand navbar-logo" href="#">&nbsp;</a>
        </div>

        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <!-- Top Navigation: Right Menu -->
        <ul class="nav navbar-right navbar-top-links">
            <li class="dropdown navbar-inverse">
                <a class="btn btn-yellow href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>              

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>                
            </li>            
        </ul>        
    </nav>

    <!-- Page Content -->
    <div class="body-wrapper">
        <!-- Sidebar -->
        <div class="navbar-custom sidebar" role="navigation">         
            <div class="sidebar-nav navbar-collapse">
                @include('dashboard.layout.menu')
            </div>

        </div>
        <div id="page-wrapper">                   
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    	
    	
    </div>
    <div class="clearfix"></div>

    <footer class="footer">
        <div>HELLO WORLD</div>
         <div id="confirm" class="modal fade" role="dialog">
          <div class="modal-dialog  modal-sm">

            <!-- Modal content-->
            <div class="modal-content">
             
              <div class="modal-body">
                <p>Some text in the modal.</p>
              </div>
              <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
                <button type="button" data-dismiss="modal" class="btn">Cancel</button>
              </div>
            </div>

          </div>
        </div>
    </footer>

</div>

<!-- Custom Theme JavaScript -->
<script src="{{asset('js/dashboard.js')}}"></script>
<script src="{{asset('js/metisMenu.min.js')}}"></script>
<!-- DataTables JavaScript -->
<script src="{{asset('js/dataTables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('js/dashboard-custom.js')}}"></script>

@yield('footer-scripts')

</body>
</html>
