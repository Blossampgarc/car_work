<!-- Header Start -->
<div class="container header2">
    <div class="row">
        <div class="col-md-1">
            <div class="logo logo2">
                <a href="{{route('welcome')}}"><img src="{{asset('web/images/logo.png')}}" /></a>
            </div>
        </div>
        <div class="col-md-11 header-2-nav">
            <nav id="cssmenu">
                <div id="head-mobile"></div>
                <div class="button"></div>
                <ul class="hdr-menu">
                    <li class="{{(isset($menu) && $menu  == 'shopall'?'active':'')}}"><a class="anchor" href="{{route('shopall','shopall')}}">Shop All</a></li>
                    <li class=""><a class="anchor" href="{{route('shopall','shirt')}}">Shirts</a></li>
                    <li><a class="anchor" href="{{route('shopall','outerwear')}}">Outerwear</a></li>
                    <li><a class="anchor" href="{{route('shopall','hat')}}">Hats</a></li>
                    <li><a class="anchor" href="{{route('onlinelesson')}}">Online Programs</a></li>
                    <li><a class="anchor" href="{{route('welcome')}}">BB HOME</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
