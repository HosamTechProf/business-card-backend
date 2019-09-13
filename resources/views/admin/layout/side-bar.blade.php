    <div class="sidebar" data-color="purple" data-background-color="white" data-image="/assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo">
        <a href="" class="simple-text logo-normal">
          بزنس كارد
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item {{ (request()->is('admin/home')) ? 'active' : '' }}">
            <a class="nav-link" href="/admin/home">
              <i class="material-icons">dashboard</i>
              <p>الرئيسية</p>
            </a>
          </li>
          <li class="nav-item {{ (request()->is('admin/users')) ? 'active' : '' }}">
            <a class="nav-link" href="/admin/users">
              <i class="material-icons">person</i>
              <p>الأعضاء</p>
            </a>
          </li>
          <li class="nav-item {{ (request()->is('admin/advertisements')) ? 'active' : '' }}">
            <a class="nav-link" href="/admin/advertisements">
              <i class="material-icons">announcement</i>
              <p>الإعلانات</p>
            </a>
          </li>
          <li class="nav-item {{ (request()->is('admin/notifications')) ? 'active' : '' }}">
            <a class="nav-link" href="/admin/notifications">
              <i class="material-icons">notifications</i>
              <p>الإشعارات</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
