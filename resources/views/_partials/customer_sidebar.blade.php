<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Tableau de bord
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('orders.index') }}" class="nav-link">
                <i class="nav-icon fas fa-shopping-bag"></i>
                <p>
                    Commandes
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                    Données
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('budgets.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Budgets</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('accounts.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Comptes budgets</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/layout/fixed-footer.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Groupes budgets</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Catégories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dictionaries.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dictionnaire</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/layout/fixed-sidebar-custom.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Nature dépenses</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/layout/fixed-topnav.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Unités de mesure</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('natures.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Nature comptes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('entities.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Entités</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('currencies.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Devises</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p>
                    Paramètres
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('investments.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Investissements</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-header">Configuration</li>
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link">
                <i class="fas fa-users nav-icon"></i>
                <p>Utilisateus</p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user-lock"></i>
                <p>
                    Privilèges et Rôles
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('privileges.index')}}" class="nav-link">
                            <i class="fas fa-lock nav-icon"></i>
                            <p>Privilèges</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('roles.index') }}" class="nav-link">
                            <i class="fas fa-cog nav-icon"></i>
                            <p>Rôles</p>
                        </a>
                    </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="{{ route('reporting.index') }}" class="nav-link">
                <i class="nav-icon fas fa-chart-bar"></i>
                <p>
                    Rapports
                </p>
            </a>
        </li>
        <li><hr></li>
        <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link"
               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                    Se déconnecter
                </p>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>
