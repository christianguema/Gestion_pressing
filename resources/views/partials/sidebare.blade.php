<ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
        <a class="nav-link " href="{{ route('dashboard') }}">
            <i class="bi bi-grid-fill"></i>
            <span>TABLEAU DE BORD</span>
        </a>
    </li><!-- End Dashboard Nav -->

    @role('gestionnaire')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('personnels.*') ? '' : 'collapsed' }}" data-bs-target="#compte-nav"
            data-bs-toggle="collapse" href="#">
            <i class="ri-user-2-fill"></i><span>COMPTES</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="compte-nav" class="nav-content collapse {{ request()->routeIs('personnels.*') ? 'show' : '' }}"
            data-bs-parent="#sidebar-nav">
            <li>
                <a href="{{ route('personnels.index') }}">
                    <i class="bi bi-circle"></i><span>Liste des personnels</span>
                </a>
            </li>
            <li>
                <a href="{{ route('personnels.create') }}">
                    <i class="bi bi-circle"></i><span>Ajouter un compte</span>
                </a>
            </li>
            <li>
                <a href="{{ route("personnels.compte") }}">
                    <i class="bi bi-circle"></i><span>Gerer les compte</span>
                </a>
            </li>

            {{-- <li>
                <a href="#">
                    <i class="bi bi-circle"></i><span>Gerer les roles</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bi bi-circle"></i><span>---</span>
                </a>
            </li> --}}

        </ul>
    </li>
    @endrole
    <!-- End Accompte Nav -->

    @role('gestionnaire')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('pressings.*') ? '' : 'collapsed' }}" data-bs-target="#pressing-nav"
            data-bs-toggle="collapse" href="#">
            <i class="ri-store-3-fill"></i><span>PRESSING</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="pressing-nav" class="nav-content collapse {{ request()->routeIs('pressings.*') ? 'show' : '' }}"
            data-bs-parent="#sidebar-nav">
            <li>
                <a href="{{ route('pressings.index') }}">
                    <i class="bi bi-circle"></i><span>Liste des pressings</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pressings.create') }}">
                    <i class="bi bi-circle"></i><span>Enregistrer un pressing</span>
                </a>
            </li>
            {{-- <li>
                <a href="#">
                    <i class="bi bi-circle"></i><span>---</span>
                </a>
            </li> --}}
        </ul>
    </li><!-- End pressing Nav -->

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('vetements.*','categories.*') ? '' : 'collapsed' }}"
            data-bs-target="#vetement-nav" data-bs-toggle="collapse" href="#">
            <i class="ri-wallet-3-fill"></i><span>VETEMENTS</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="vetement-nav"
            class="nav-content collapse {{ request()->routeIs('vetements.*','categories.*') ? 'show' : '' }}"
            data-bs-parent="#sidebar-nav">
            <li>
                <a href="{{ route('categories.index') }}">
                    <i class="bi bi-circle"></i><span>Categories</span>
                </a>
            </li>
            <li>
                <a href="{{ route('vetements.index') }}">
                    <i class="bi bi-circle"></i><span>Liste des vetements</span>
                </a>
            </li>
            {{-- <li>
                <a href="#">
                    <i class="bi bi-circle"></i><span>---</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bi bi-circle"></i><span>---</span>
                </a>
            </li> --}}
        </ul>
    </li><!-- End vetement Nav -->
    @endrole
    <!-- End Vetement Nav -->

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('commandes.*','type_facturations.*', 'remises.*' ,'type_prestations.*') ? '' : 'collapsed' }}"
            data-bs-target="#commande-nav" data-bs-toggle="collapse" href="#">
            <i class="ri-shopping-cart-2-fill"></i><span>COMMANDES</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="commande-nav"
            class="nav-content collapse {{ request()->routeIs('commandes.*', 'remises.*' ,'type_facturations.*', 'type_prestations.*') ? 'show' : '' }}"
            data-bs-parent="#sidebar-nav">

            <li>
                <a href="{{ route('commandes.pendingIndex') }}">
                    <i class="bi bi-circle"></i><span>Liste des commandes</span>
                </a>
            </li>
            @role('personnel')
            <li>
                <a href="{{ route('commandes.create') }}">
                    <i class="bi bi-circle"></i><span>Enregistrer une commande</span>
                </a>
            </li>
            @endrole
            @role('gestionnaire')
                <li>
                    <a href="{{route('type_facturations.index') }}">
                        <i class="bi bi-circle"></i><span>Type facturation</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('type_prestations.index') }}">
                        <i class="bi bi-circle"></i><span>Type prestation</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route("remises.index") }}">
                        <i class="bi bi-circle"></i><span>Remise</span>
                    </a>
                </li>
            @endrole
        </ul>
    </li> <!-- End Commande nav -->

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('paiements.*','mode_paiements.*') ? '' : 'collapsed' }}" data-bs-target="#payement-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-cash-coin"></i><span>PAIEMENTS</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="payement-nav" class="nav-content collapse {{ request()->routeIs('paiements.*', 'mode_paiements.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            @role("personnel")
                 <li>
                    <a href="{{ route("paiements.create") }}">
                        <i class="bi bi-circle"></i><span>Enregistrer un paiement</span>
                    </a>
                </li>
            @endrole
            @role('gestionnaire')
            <li>
                <a href="{{ route('mode_paiements.index') }}">
                    <i class="bi bi-circle"></i><span>Mode de Paiments</span>
                </a>
            </li>
            @endrole
        </ul>
    </li><!-- End payement Nav -->

    @role("gestionnaire")
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('rapports.*') ? '' : 'collapsed' }}" data-bs-target="#rapport-nav" data-bs-toggle="collapse">
            <i class="bi bi-file-word-fill"></i><span>RAPPORT</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="rapport-nav" class="nav-content collapse {{ request()->routeIs('rapports.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li>
                <a href="{{ route('rapports.index') }}">
                    <i class="bi bi-circle"></i><span>Rapport de revenu</span>
                </a>
            </li>
            {{-- <li>
                <a href="{{ route('rapports.index') }}">
                    <i class="bi bi-circle"></i><span>Rapport performance</span>
                </a>
            </li> --}}
        </ul>
    </li><!-- End Rapport Nav -->
    @endrole
    <!-- End Components Nav -->

    <li class="nav-heading">SYSTEMES</li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#">
            <i class="bi bi-gear"></i>
            <span>Parametres</span>
        </a>
    </li><!-- End Settings Nav -->

    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('profile.edit') }}">
            <i class="bi bi-person"></i>
            <span>Profile</span>
        </a>
    </li><!-- End Profile Page Nav -->

    <!-- End Sidebar-->
