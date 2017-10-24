				<ul class="nav" id="side-menu">
                    <li class="sidebar-profile">
                        <span class="profile-picture">
                            <img src="{{ asset('storage/user_photos/'.Auth::user()->photo) }}" />
                        </span>
                        <span class="profile-details">{{ Auth::user()->name }}<br />Administrator</span>
                    </li>
                    <li>
                        <a href="#" class="active"><i class="mnc-icon mnc-dashboard"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="/dashboard/orders/"><i class="mnc-icon mnc-orders"></i>Orders</a>
                    </li>
					<li>
                        <a href="/dashboard/customers/"><i class="mnc-icon mnc-customers"></i>Customers</a>
                    </li>
					<li>
                        <a href="/dashboard/products/"><i class="mnc-icon mnc-products"></i>Products</a>
                    </li>
					<li>
                        <a href="#"><i class="mnc-icon mnc-categories"></i>Categories</a>
                    </li>
					<li>
                        <a href="#"><i class="mnc-icon mnc-pages"></i>Edit Pages</a>
                    </li>
                    <li>
                        <a href="#"><i class="mnc-icon mnc-pages"></i>Modules</a>
                    </li>
                    <li>
                        <a href="#"><i class="mnc-icon mnc-admins"></i>Admins</a>
                    </li>
                    
                </ul>