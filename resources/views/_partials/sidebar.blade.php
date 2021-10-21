<div class="sidebar-user text-center">
    <a class="setting-primary" href="javascript:void(0)"><i data-feather="settings"></i></a>
    <img class="img-90 rounded-circle" src="{{ asset('assets/images/dashboard/user-profile.png') }}" alt="">
    <a href="user-profile.html">
        <h6 class="mt-3 f-14 f-w-600">{{ Auth::user()->name }}</h6></a>
    <p class="mb-0 font-roboto">Vous êtes connecté comme {{ Auth::user()->user_type_name }}</p>
</div>
