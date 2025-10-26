<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a wire:navigate href="/admin" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('img/zapp.svg') }}" alt="zapp">
            </span>
        </a>

        <a href="javascript:void(0)" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @foreach ($menus->where('parent_id', null) as $menu)
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">{{ $menu->menu }}</span>
            </li>
            @php
                $children = $menus->where('parent_id', $menu->id);
            @endphp
            @foreach ($children as $child)
                @if ($child->segment)
                    @can('r_' . $child->segment)
                        <li class="menu-item">
                            <a wire:navigate href="{{ $child->segment ?? '#' }}" class="menu-link">
                                <i class="menu-icon tf-icons bx {{ $child->icon ?? 'bx-circle' }}"></i>
                                <div>{{ $child->menu }}</div>
                            </a>
                        </li>
                    @endcan
                @endif
            @endforeach
        @endforeach
    </ul>


</aside>
