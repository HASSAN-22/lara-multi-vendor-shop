
<li><a><i class="fa fa-archive"></i> Profile <span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu">
        <li><a href="{{route('profile.edit',['user'=>$user->id])}}">Profile</a></li>
        <li><a href="{{route('password.edit',['user'=>$user->id])}}">Update password</a></li>
    </ul>
</li>
