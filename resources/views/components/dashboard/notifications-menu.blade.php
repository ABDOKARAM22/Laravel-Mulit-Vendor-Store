 <!-- Notifications Dropdown Menu -->
 <li class="nav-item dropdown">
     <a class="nav-link" data-toggle="dropdown" href="#">
         <i class="far fa-bell"></i>
         @if ($NotificationsCount)
        <span class="badge badge-warning navbar-badge">{{$NotificationsCount}}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      <span class="dropdown-item dropdown-header">{{$NotificationsCount}} Notifications</span>
      @forelse ($notifications as $notification )
          
      <div class="dropdown-divider"></div>
      <a href="{{$notification->data['url']}}?notification_id={{$notification->id}}" 
        class="dropdown-item @if($notification->unread()) font-weight-bold @endif">
         <div class="d-flex align-items-center text-truncate">
             <i class="{{$notification->data['icon']}} mr-2"></i>
             <span>{{$notification->data['title']}}</span>
         </div>
         <div class="text-muted text-sm mt-1">
           {{$notification->created_at->diffForHumans()}}
          </div>
        </a>
     
     
      @empty
      
      <p class="text-center">Not Found Notifications.</p>

      @endforelse

      @if (isset($notifications->last()->data['url']))
      <div class="dropdown-divider">
        <a href="{{$notifications->last()->data['url']}}" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
      @endif

    </div>
  </li>
 