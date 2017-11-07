				<ul class="nav" id="side-menu">
                    <li class="sidebar-profile">
                        <span class="profile-picture">
                            <img src="{{ asset('storage/user_photos/'.Auth::user()->photo) }}" />
                        </span>
                        <span class="profile-details">{{ Auth::user()->name }}<br />Administrator</span>
                    </li>
                    <li>
                        <a href="{{url('dashboard/index')}}" ><i class="mnc-icon mnc-dashboard"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="{{url('dashboard/orders')}}"><i class="mnc-icon mnc-orders"></i>Orders</a>
                    </li>
					<li>
                        <a href="{{url('dashboard/customers')}}"><i class="mnc-icon mnc-customers"></i>Customers</a>
                    </li>
					<li>
                        <a href="{{url('dashboard/products')}}"><i class="mnc-icon mnc-products"></i>Products</a>
                    </li>
					<li>
                        <a href="{{url('dashboard/categories')}}"><i class="mnc-icon mnc-categories"></i>Categories</a>
                    </li>
					<li>
                        <a href="{{url('dashboard/pages')}}"><i class="mnc-icon mnc-pages"></i>Edit Pages</a>
                    </li>
                    <!--<li>
                        <a href="{{url('dashboard/modules')}}"><i class="mnc-icon mnc-pages"></i>Modules</a>
                    </li>-->
                    <li>
                        <a href="{{url('dashboard/admins')}}"><i class="mnc-icon mnc-admins"></i>Admins</a>
                    </li>                    
                </ul>