<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Main</h6>
                    <ul>
                        <li class="">
                            <a href="{{ Route('dashboard') }}"><i data-feather="grid"></i><span>Dashboard</span></a>
                        </li>
                        
                    </ul>
                </li>

                <li class="submenu-open">
                    <h6 class="submenu-hdr">My Accounts</h6>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);"><i data-feather="user-check"></i><span>Accounts</span><span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ Route('accounts.list') }}">Bank Accounts</a></li>
                                <li><a href="{{ Route('income.list') }}">Incomes</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Expense & Credits</h6>								
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);"><i data-feather="file-text"></i><span>Expense</span><span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ Route('expense.list') }}">Expenses</a></li>
                                <li><a href="{{ Route('category.list') }}">Expense Category</a></li>
                            </ul>
                        </li>
                        
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
