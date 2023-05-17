<header class="header shop">
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="top-left">
                        <ul class="list-main">
                            @php
                                #$settings=DB::table('settings')->get();
                                
                            @endphp
                            {{-- <li><i class="ti-headphone-alt"></i><?php //@foreach($settings as $data) {{$data->phone}} @endforeach ?></li>
                            <li><i class="ti-email"></i><?php //@foreach($settings as $data) {{$data->email}} @endforeach ?></li>  --}}
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="right-content">
                        <ul class="list-main">
                        {{-- <li><i class="ti-location-pin"></i> <a href="{{route('order.track')}}">Acompanhar Pedido</a></li> --}}
                            {{-- <li><i class="ti-alarm-clock"></i> <a href="#">Promoção do Dia</a></li> --}}
                            @auth 
                                @if(Auth::user()->role=='admin')
                                    <li><i class="ti-user"></i> <a href="{{route('admin')}}"  target="_blank">Conrtole</a></li>
                                @else 
                                    <li><i class="ti-user"></i> <a href="{{route('user')}}"  target="_blank">Conrtole</a></li>
                                @endif
                                <li><i class="ti-power-off"></i> <a href="{{route('user.logout')}}">Sair</a></li>

                            @else
                                <li><i class="ti-power-off"></i><a href="{{route('login.form')}}">Entrar /</a> <a href="{{route('register.form')}}">Registrar</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
   
</header>