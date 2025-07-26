
<ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
        <a class="nav-link " href="{{ route('dashboard') }}">
            <i class="bi bi-grid-fill"></i>
            <span>TABLEAU DE BORD</span>
        </a>
    </li><!-- End Dashboard Nav -->

    @role('gestionnaire')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('vetements.*','categories.*') ? '' : 'collapsed' }}" data-bs-target="#vetement-nav" data-bs-toggle="collapse" href="#">
          <i class="ri-wallet-3-fill"></i><span>VETEMENTS</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="vetement-nav" class="nav-content collapse {{ request()->routeIs('vetements.*','categories.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('vetements.*','categories.*') ? '' : 'collapsed' }}" data-bs-target="#categorie-nav" data-bs-toggle="collapse" href="#">
                    <i class="ri-wallet-3-fill"></i><span>CATEGORIES</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="categorie-nav" class="nav-content collapse {{ request()->routeIs('vetements.*','categories.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                
                        <li>
                            <a href="{{route('categories.index') }}">
                            <i class="bi bi-circle"></i><span>Liste des categories</span>
                            </a>
                        </li>
                        {{-- <li>
                            <a href="{{route('categories.create') }}">
                            <i class="bi bi-circle"></i><span>Ajouter une catégorie</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <i class="bi bi-circle"></i><span>Modifier une catégorie</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <i class="bi bi-circle"></i><span>Supprimer une catégorie</span>
                            </a>
                        </li> --}}
                </ul>
          </li>
                
            
          <li>
            <a href="{{route('vetements.index') }}">
              <i class="bi bi-circle"></i><span>Liste des vetements</span>
            </a>
          </li>
          {{-- <li>
            <a href="{{route('vetements.create') }}">
              <i class="bi bi-circle"></i><span>Ajouter un vetement</span>
            </a>
          </li>
          <li>
                <a href="#">
                    <i class="bi bi-circle"></i><span>Modifier un vetement</span>
                </a>
          </li>
          <li>
                <a href="#">
                    <i class="bi bi-circle"></i><span>Supprimer un vetement</span>
                </a>
          </li> --}}
        </ul>
    </li><!-- End vetement Nav -->

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('pressings.*') ? '' : 'collapsed' }}" data-bs-target="#pressing-nav" data-bs-toggle="collapse" href="#">
            <i class="ri-store-3-fill"></i><span>PRESSING</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="pressing-nav" class="nav-content collapse {{ request()->routeIs('pressings.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li>
                <a href="{{route('pressings.index') }}">
                    <i class="bi bi-circle"></i><span>Liste des pressings</span>
                </a>
            </li>
            <li>
                <a href="{{route('pressings.create') }}">
                    <i class="bi bi-circle"></i><span>Enregistrer un pressing</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bi bi-circle"></i><span>---</span>
                </a>
            </li>
        </ul>
    </li><!-- End pressing Nav -->
    @endrole

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('commandes.*') ? '' : 'collapsed' }}" data-bs-target="#commande-nav" data-bs-toggle="collapse" href="#">
            <i class="ri-shopping-cart-2-fill"></i><span>COMMANDES</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="commande-nav" class="nav-content collapse {{ request()->routeIs('commandes.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            @role('gestionnaire')
                <li>
                    <a href="#">
                        <i class="bi bi-circle"></i><span>Toutes Les commandes</span>
                    </a>
                </li>
            @endrole
            <li>
                <a href="#">
                    <i class="bi bi-circle"></i><span>Commandes livrées</span>
                </a>
            </li>
            <li>
                <a href="{{ route('commandes.endIndex') }}">
                    <i class="bi bi-circle"></i><span>Commandes terminées</span>
                </a>
            </li>
            <li>
                <a href="{{ route('commandes.pendingIndex') }}">
                    <i class="bi bi-circle"></i><span>Commandes en attentes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('commandes.create') }}">
                    <i class="bi bi-circle"></i><span>Enregistrer une commande</span>
                </a>
            </li>
            
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
            @endrole
        </ul>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('paiements.*') ? '' : 'collapsed' }}" data-bs-target="#paiement-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-cash-coin"></i><span>PAIEMENTS</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="paiement-nav" class="nav-content collapse {{ request()->routeIs('paiements.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li>
                <a href="#">
                    <i class="bi bi-circle"></i><span>Enregistrer un paiement</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bi bi-circle"></i><span>----</span>
                </a>
            </li>
        </ul>
    </li><!-- End payement Nav -->

    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#rapport-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-file-word-fill"></i><span>RAPPORT</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="rapport-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
                <a href="icons-bootstrap.html">
                    <i class="bi bi-circle"></i><span>Rapport de revenu</span>
                </a>
            </li>
            <li>
                <a href="icons-remix.html">
                    <i class="bi bi-circle"></i><span>Rapport performance</span>
                </a>
            </li>
        </ul>
    </li><!-- End Rapport Nav -->

    @role('gestionnaire')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('personnels.*') ? '' : 'collapsed' }}" data-bs-target="#compte-nav" data-bs-toggle="collapse" href="#">
            <i class="ri-user-2-fill"></i><span>COMPTES</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="compte-nav" class="nav-content collapse {{ request()->routeIs('personnels.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li>
                <a href="{{ route('personnels.index') }}">
                    <i class="bi bi-circle"></i><span>Liste des personnels</span>
                </a>
            </li>
            <li>
                <a href="{{route('personnels.create') }}">
                    <i class="bi bi-circle"></i><span>Ajouter un compte</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bi bi-circle"></i><span>Gerer les compte</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bi bi-circle"></i><span>Gerer les roles</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bi bi-circle"></i><span>---</span>
                </a>
            </li>

        </ul>
    </li><!-- End Components Nav -->
    @endrole

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
