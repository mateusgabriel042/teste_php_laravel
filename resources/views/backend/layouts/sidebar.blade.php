<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin')}}">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="{{route('admin')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Controle</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


    <!--  -->
    <!--  -->

    <!-- Heading 
    <div class="sidebar-heading">
        Marker
    </div>

    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-image"></i>
        <span>Markers</span>
      </a>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{route('api.casasbahia')}}">Casas Bahia</a>
            <a class="collapse-item" href="{{route('api.mercadolivre')}}">Mercado Livre</a>
            <a class="collapse-item" href="{{route('api.amazon')}}">Amazon</a>
            <a class="collapse-item" href="{{route('api.magalu')}}">Magalu</a>
            <a class="collapse-item" href="{{route('api.olist')}}">Olist</a>
            <a class="collapse-item" href="{{route('api.shopee')}}">Shopee</a>
            <a class="collapse-item" href="{{route('api.americanas')}}">Americanas</a>
        </div>
      </div>
    </li>
    -->
    <!-- Divider -->
    <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
          Vendas
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
    <!-- Nav Item - Charts 
    <li class="nav-item">
        <a class="nav-link" href="{{route('file-manager')}}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Gerencia mídia</span></a>
    </li>
    -->

    <!-- Categories 
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#categoryCollapse" aria-expanded="true" aria-controls="categoryCollapse">
          <i class="fas fa-sitemap"></i>
          <span>Categoria</span>
        </a>
        <div id="categoryCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Categorias</h6>
            <a class="collapse-item" href="{{route('category.index')}}">Ver</a>
            <a class="collapse-item" href="{{route('category.create')}}">Adicionar</a>
          </div>
        </div>
    </li>
    -->
    {{-- Products 
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productCollapse" aria-expanded="true" aria-controls="productCollapse">
          <i class="fas fa-cubes"></i>
          <span>Produtos</span>
        </a>
        <div id="productCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Produtos:</h6>
            <a class="collapse-item" href="{{route('product.index')}}">Ver</a>
            <a class="collapse-item" href="{{route('product.create')}}">Adicionar</a>
            <a class="collapse-item" href="{{route('product.import')}}">Importar</a>
            <a class="collapse-item" href="{{route('products.index.to.api')}}">Publicados</a>
            
          </div>
        </div>
    </li>
    --}}
    {{-- Brands 
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#brandCollapse" aria-expanded="true" aria-controls="brandCollapse">
          <i class="fas fa-table"></i>
          <span>Marcas</span>
        </a>
        <div id="brandCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Marcas:</h6>
            <a class="collapse-item" href="{{route('brand.index')}}">Ver</a>
            <a class="collapse-item" href="{{route('brand.create')}}">Adicionar</a>
          </div>
        </div>
    </li>
    --}}
    {{-- Shipping 
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#shippingCollapse" aria-expanded="true" aria-controls="shippingCollapse">
          <i class="fas fa-truck"></i>
          <span>Envios</span>
        </a>
        <div id="shippingCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Envios:</h6>
            <a class="collapse-item" href="{{route('shipping.index')}}">Ver</a>
            <a class="collapse-item" href="{{route('shipping.create')}}">Adicionar</a>
          </div>
        </div>
    </li>
    --}}
    {{-- Financial --}}
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#financialCollapse" aria-expanded="true" aria-controls="financialCollapse">
        <i class="fas fa-money-bill"></i>
        <span>Financeiro</span>
      </a>
      <div id="financialCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Financeiro:</h6>
          <a class="collapse-item" href="{{route('financial.index')}}">Vendas</a>
          <a class="collapse-item" href="{{route('financial.index')}}">Relatório</a>
        </div>
      </div>
  </li>

    <!--Orders 
    <li class="nav-item">
        <a class="nav-link" href="{{route('order.index')}}">
            <i class="fas fa-hammer fa-chart-area"></i>
            <span>Pedidos</span>
        </a>
    </li>
    -->
    <!-- Reviews 
    <li class="nav-item">
        <a class="nav-link" href="{{route('review.index')}}">
            <i class="fas fa-comments"></i>
            <span>Avaliações</span></a>
    </li>
    -->

    <!-- Divider 
    <hr class="sidebar-divider">
      -->
    <!-- Heading 
    <div class="sidebar-heading">
      Posts
    </div>
    -->
    <!-- Posts 
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#postCollapse" aria-expanded="true" aria-controls="postCollapse">
        <i class="fas fa-fw fa-folder"></i>
        <span>Postagens</span>
      </a>
      <div id="postCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Postagens:</h6>
          <a class="collapse-item" href="{{route('post.index')}}">Ver</a>
          <a class="collapse-item" href="{{route('post.create')}}">Adicionar</a>
        </div>
      </div>
    </li>
    -->
     <!-- Category 
     <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#postCategoryCollapse" aria-expanded="true" aria-controls="postCategoryCollapse">
          <i class="fas fa-sitemap fa-folder"></i>
          <span>Categorias</span>
        </a>
        <div id="postCategoryCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Categorias:</h6>
            <a class="collapse-item" href="{{route('post-category.index')}}">Ver</a>
            <a class="collapse-item" href="{{route('post-category.create')}}">Adicionar</a>
          </div>
        </div>
      </li>
      -->
      <!-- Tags 
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#tagCollapse" aria-expanded="true" aria-controls="tagCollapse">
            <i class="fas fa-tags fa-folder"></i>
            <span>Etiquetes</span>
        </a>
        <div id="tagCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Etiquetes</h6>
            <a class="collapse-item" href="{{route('post-tag.index')}}">Ver</a>
            <a class="collapse-item" href="{{route('post-tag.create')}}">Adicionar</a>
            </div>
        </div>
    </li>
    -->
      <!-- Comments 
      <li class="nav-item">
        <a class="nav-link" href="{{route('comment.index')}}">
            <i class="fas fa-comments fa-chart-area"></i>
            <span>Compentários</span>
        </a>
      </li>
      -->

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
     <!-- Heading -->
    <div class="sidebar-heading">
        Gerencia Configurações
    </div>
    <!-- Heading 
    <li class="nav-item">
      <a class="nav-link" href="{{route('coupon.index')}}">
          <i class="fas fa-table"></i>
          <span>Cupons</span></a>
    </li>
    -->
     <!-- Users 
     <li class="nav-item">
        <a class="nav-link" href="{{route('users.index')}}">
            <i class="fas fa-users"></i>
            <span>Usuários</span></a>
    </li>
    -->
     <!-- General settings -->
     <li class="nav-item">
        <a class="nav-link" href="{{route('settings')}}">
            <i class="fas fa-cog"></i>
            <span>Configurações</span></a>
    </li>
    <!-- Multiuser -->
    <li class="nav-item">
        <a  class="{{ request()->is('admin/multiuser*') ? 'nav-link' : 'nav-link collapsed' }}" href="#" data-toggle="collapse" data-target="#multiuser" aria-expanded="true" aria-controls="multiuser">
            <i class="fas fa-tags fa-folder"></i>
            <span>Multiusuários</span>
        </a>
        <div id="multiuser" class="{{ request()->is('admin/multiuser*') ? 'collapse show' : 'collapse' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Multiusuários</h6>
            <a class="{{ request()->is('admin/multiuser') ? 'collapse-item active' : 'collapse-item' }}" href="{{route('multiuser.index')}}">Ver</a>
            <a class="{{ request()->is('admin/multiuser/create') ? 'collapse-item active' : 'collapse-item' }}" href="{{route('multiuser.create')}}">Adicionar</a>
            </div>
        </div>
    </li>
    <!-- Announcement -->
    <li class="nav-item">
      <a  class="{{ request()->is('admin/announcement*') ? 'nav-link' : 'nav-link collapsed' }}" href="#" data-toggle="collapse" data-target="#announcement" aria-expanded="true" aria-controls="announcement">
          <i class="fas fa-tags fa-folder"></i>
          <span>Gestão de Anúncios</span>
      </a>
      <div id="announcement" class="{{ request()->is('admin/announcement*') ? 'collapse show' : 'collapse' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Gestão de Anúncios</h6>
          <a class="{{ request()->is('admin/announcement') ? 'collapse-item active' : 'collapse-item' }}" href="{{route('announcement.index')}}">Ver</a>
          <a class="{{ request()->is('admin/announcement/create') ? 'collapse-item active' : 'collapse-item' }}" href="{{route('announcement.create')}}">Importar</a>
          <a class="{{ request()->is('admin/announcement/alter') ? 'collapse-item active' : 'collapse-item' }}" href="{{route('announcement.alter')}}">Alterar Anúncios</a>

        </div>
      </div>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>