<header class="header">
    <div class="div-header-logo">
        <img src="{{auth()->user()->logo ? public_path(auth()->user()->logo) : public_path('assets/images/logo-pdf.png')}}" onerror="this.onerror=null;this.src=`{{public_path('assets/images/default-image.png')}}`" alt="" class="img-header-logo">
    </div>
    <div class="div-header-title">
        <span class="header-title">{{$title}}</span>
    </div>
</header>