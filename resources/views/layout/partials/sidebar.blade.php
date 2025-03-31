<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Main</h6>
                    <ul>
                        <li>
                            <a href="{{ Route('dashboard') }}"><i data-feather="grid"></i><span>Dashboard</span></a>
                        </li>
                        
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Expense & Accounts</h6>	
                    <ul>
                        <li>
                            <a href="{{ Route('accounts.list') }}">
                                <img src="{{ url('assets/img/icons/wallet1.svg') }}" alt="img" class="me-1">
                                <span>Bank Accounts</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ Route('category.list') }}">
                                <i data-feather="copy"></i><span>Expense Category</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ Route('income.list') }}">
                                <i data-feather="download-cloud"></i><span>Incomes</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ Route('expense.list') }}">
                                <i data-feather="external-link"></i><span>Expense</span>
                            </a>
                        </li>
                        
                        
                    </ul>
                </li>

                <li class="submenu-open">
                    <h6 class="submenu-hdr">Analytics</h6>								
                    <ul>
                        <li><a href="{{ Route('analytics.spend_analytics') }}"><i data-feather="pie-chart"></i><span>Spend Analytics</span></a></li>
                        <li><a href="{{ Route('transaction.history') }}"><i data-feather="shuffle"></i><span>Transaction history</span></a></li>
                    </ul>
                </li>
                
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Settings</h6>								
                    <ul>
                        <li>
                            <a href="{{ route('logout') }}"><i data-feather="log-out"></i><span>Logout</span> </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
