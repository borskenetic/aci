@php
    $isActive = fn (array $patterns) => collect($patterns)->contains(fn ($pattern) => request()->routeIs($pattern));
    $user = Auth::user();
    $navLink = function (string $route, array $attrs) {
        if (! \Illuminate\Support\Facades\Route::has($route)) {
            return null;
        }

        return array_merge($attrs, ['route' => $route]);
    };

    $navLinks = [
        [
            'label'    => 'Home',
            'route'    => 'book.index',
            'patterns' => ['book.index', 'book.show', 'book.create', 'book.edit', 'books.*'],
            'icon'     => 'home',
        ],
        [
            'label'    => 'Attendance',
            'icon'     => 'calendar-check',
            'patterns' => [
                'attendance.scan',
                'attendance.process',
                'attendance.changeVideo',
                'attendance.uploadVideo',
                'attendance_logs.*',
                'admin.attendance.feedbacks',
            ],
            'children' => array_values(array_filter([
                $navLink('attendance.scan', [
                    'label'    => 'Attendance',
                    'patterns' => ['attendance.scan', 'attendance.process'],
                    'icon'     => 'scan',
                    'target'   => '_blank',
                ]),
                $navLink('attendance_logs.index', [
                    'label'    => 'Attendance Logs',
                    'patterns' => ['attendance_logs.*'],
                    'icon'     => 'clock',
                ]),
                $navLink('attendance.changeVideo', [
                    'label'    => 'Change Video',
                    'patterns' => ['attendance.changeVideo', 'attendance.uploadVideo'],
                    'icon'     => 'settings',
                ]),
                $navLink('admin.attendance.feedbacks', [
                    'label'    => 'View Feedback Responses',
                    'patterns' => ['admin.attendance.feedbacks'],
                    'icon'     => 'list',
                ]),
            ])),
        ],
        [
            'label'    => 'Data',
            'icon'     => 'users',
            'patterns' => [
                'students.*',
                'employees.*',
                'pending.*',
            ],
            'children' => array_values(array_filter([
                $navLink('students.index', [
                    'label'    => 'Student Data',
                    'patterns' => ['students.*', 'pending.index'],
                    'icon'     => 'users',
                ]),
                $navLink('employees.index', [
                    'label'    => 'Faculty & Staff Data',
                    'patterns' => ['employees.*', 'pending.employees'],
                    'icon'     => 'badge',
                ]),
            ])),
        ],
        [
            'label'    => 'OPAC',
            'route'    => 'landing',
            'patterns' => ['landing', 'opac.*'],
            'icon'     => 'search',
            'target'   => '_blank',
        ],
        [
            'label'    => 'Circulation',
            'icon'     => 'book',
            'patterns' => [
                'logs.*',
                'fines.*',
                'catalog.copy.*',
                'book.report.download',
                'circulation.*',
            ],
            'children' => array_values(array_filter([
                $navLink('logs.index', [
                    'label'    => 'Circulation',
                    'patterns' => ['logs.*'],
                    'icon'     => 'book',
                ]),
                auth()->user()?->can('isAdmin') ? $navLink('fines.outstanding', [
                    'label'    => 'Outstanding Fines',
                    'patterns' => ['fines.outstanding'],
                    'icon'     => 'alert',
                ]) : null,
                $navLink('catalog.copy.openlibrary.form', [
                    'label'    => 'Copy Cataloging',
                    'patterns' => ['catalog.copy.*'],
                    'icon'     => 'copy',
                ]),
                $navLink('book.report.download', [
                    'label'    => 'Download Book Report',
                    'patterns' => ['book.report.download'],
                    'icon'     => 'download',
                ]),
                auth()->user()?->can('isAdmin') ? $navLink('fines.edit', [
                    'label'    => 'Fines and Due Dates',
                    'patterns' => ['fines.edit', 'fines.update'],
                    'icon'     => 'settings',
                ]) : null,
            ])),
        ],
        [
            'label'    => 'Admin',
            'icon'     => 'shield',
            'patterns' => [
                'feedback.*',
                'files.*',
                'prospectus.*',
                'users.*',
                'admin.catalog_frameworks.*',
                'ebooks.*',
            ],
            'children' => array_values(array_filter([
                $navLink('feedback.index', [
                    'label'    => 'Student Feedback',
                    'patterns' => ['feedback.index'],
                    'icon'     => 'message',
                ]),
                $navLink('files.index', [
                    'label'    => 'Repository',
                    'patterns' => ['files.*'],
                    'icon'     => 'folder',
                ]),
                $navLink('prospectus.index', [
                    'label'    => 'Prospectus Manager',
                    'patterns' => ['prospectus.*'],
                    'icon'     => 'grid',
                ]),
                $navLink('ebooks.index', [
                    'label'    => 'E-Books',
                    'patterns' => ['ebooks.*'],
                    'icon'     => 'book',
                ]),
                auth()->user()?->can('isAdmin') ? $navLink('users.index', [
                    'label'    => 'View Pantas Users',
                    'patterns' => ['users.*'],
                    'icon'     => 'user-plus',
                ]) : null,
                auth()->user()?->can('isAdmin') ? $navLink('admin.catalog_frameworks.index', [
                    'label'    => 'MARC Catalog Frameworks',
                    'patterns' => ['admin.catalog_frameworks.*'],
                    'icon'     => 'list',
                ]) : null,
            ])),
        ],
        [
            'label'    => 'Room Reservations',
            'icon'     => 'door',
            'patterns' => [
                'rooms.*',
                'room-reservations.*',
                'sms.*',
            ],
            'children' => array_values(array_filter([
                $navLink('rooms.index', [
                    'label'    => 'Manage Rooms',
                    'patterns' => ['rooms.index', 'rooms.create', 'rooms.edit', 'rooms.store', 'rooms.update', 'rooms.destroy'],
                    'icon'     => 'door',
                ]),
                $navLink('rooms.book', [
                    'label'    => 'Book a Room',
                    'patterns' => ['rooms.book', 'room-reservations.store'],
                    'icon'     => 'calendar-check',
                ]),
                $navLink('rooms.schedule', [
                    'label'    => 'View Schedule',
                    'patterns' => ['rooms.schedule', 'rooms.show'],
                    'icon'     => 'clock',
                ]),
                $navLink('rooms.pending', [
                    'label'    => 'Pending Reservations',
                    'patterns' => ['rooms.pending', 'rooms.approve', 'rooms.reject'],
                    'icon'     => 'alert',
                ]),
                $navLink('rooms.logs', [
                    'label'    => 'Reservation Logs',
                    'patterns' => ['rooms.logs'],
                    'icon'     => 'list',
                ]),
                auth()->user()?->can('isAdmin') ? $navLink('sms.page', [
                    'label'    => 'SMS Blast',
                    'patterns' => ['sms.*'],
                    'icon'     => 'send',
                ]) : null,
            ])),
        ],
    ];

    $icon = function (string $name) {
        return match ($name) {
            'home'           => '<path d="M3 10.5 12 3l9 7.5"/><path d="M5 10v10h14V10"/><path d="M9 20v-6h6v6"/>',
            'book'           => '<path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5z"/><path d="M4 5.5v16"/><path d="M8 7h8"/>',
            'scan'           => '<path d="M7 3H4a1 1 0 0 0-1 1v3"/><path d="M17 3h3a1 1 0 0 1 1 1v3"/><path d="M7 21H4a1 1 0 0 1-1-1v-3"/><path d="M17 21h3a1 1 0 0 0 1-1v-3"/><path d="M8 12h8"/>',
            'calendar-check' => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/><path d="m9 16 2 2 4-4"/>',
            'clock'          => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
            'chart'          => '<path d="M4 19V5"/><path d="M4 19h16"/><path d="M8 16v-5"/><path d="M12 16V8"/><path d="M16 16v-3"/>',
            'users'          => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
            'badge'          => '<rect x="4" y="5" width="16" height="14" rx="2"/><path d="M9 9h6"/><path d="M9 13h6"/>',
            'message'        => '<path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z"/>',
            'send'           => '<path d="m22 2-7 20-4-9-9-4z"/><path d="M22 2 11 13"/>',
            'settings'       => '<path d="M4 21v-7"/><path d="M4 10V3"/><path d="M12 21v-9"/><path d="M12 8V3"/><path d="M20 21v-5"/><path d="M20 12V3"/><path d="M2 14h4"/><path d="M10 8h4"/><path d="M18 16h4"/>',
            'grid'           => '<path d="M4 4h6v6H4z"/><path d="M14 4h6v6h-6z"/><path d="M4 14h6v6H4z"/><path d="M14 14h6v6h-6z"/>',
            'user-plus'      => '<path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><path d="M20 8v6"/><path d="M23 11h-6"/>',
            'list'           => '<path d="M8 6h13"/><path d="M8 12h13"/><path d="M8 18h13"/><path d="M3 6h.01"/><path d="M3 12h.01"/><path d="M3 18h.01"/>',
            'shield'         => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
            'search'         => '<circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>',
            'folder'         => '<path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.5L10 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"/>',
            'door'           => '<path d="M5 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16"/><path d="M3 21h18"/><path d="M14 11h.01"/>',
            'copy'           => '<rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>',
            'download'       => '<path d="M12 3v12"/><path d="m7 10 5 5 5-5"/><path d="M5 21h14"/>',
            'alert'          => '<path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><path d="M12 9v4"/><path d="M12 17h.01"/>',
            'sliders'        => '<path d="M4 21v-7"/><path d="M4 10V3"/><path d="M12 21v-9"/><path d="M12 8V3"/><path d="M20 21v-5"/><path d="M20 12V3"/><path d="M2 14h4"/><path d="M10 8h4"/><path d="M18 16h4"/>',
            default          => '<circle cx="12" cy="12" r="9"/>',
        };
    };
@endphp

@once
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.querySelector('[data-admin-sidebar-toggle]');
            const overlay = document.querySelector('[data-admin-sidebar-overlay]');
            const collapseBtn = document.getElementById('sidebarCollapseBtn');
            const body = document.body;

            const setOpen = (open) => body.classList.toggle('admin-sidebar-open', open);
            toggle?.addEventListener('click', () => setOpen(!body.classList.contains('admin-sidebar-open')));
            overlay?.addEventListener('click', () => setOpen(false));
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 992) setOpen(false);
            });

            const STORAGE_KEY = 'aci-sidebar-collapsed';
            const closeAllSubmenus = () => {
                document.querySelectorAll('.admin-sidebar-item.open, .admin-sidebar-subitem.open').forEach(item => {
                    item.classList.remove('open');
                    item.querySelector('[aria-expanded]')?.setAttribute('aria-expanded', 'false');
                });
            };
            const setCollapsed = (collapsed) => {
                body.classList.toggle('sidebar-collapsed', collapsed);
                if (collapsed) closeAllSubmenus();
                try { localStorage.setItem(STORAGE_KEY, collapsed ? '1' : '0'); } catch (_) {}
            };

            try {
                if (localStorage.getItem(STORAGE_KEY) === '1') body.classList.add('sidebar-collapsed');
            } catch (_) {}

            collapseBtn?.addEventListener('click', () => setCollapsed(!body.classList.contains('sidebar-collapsed')));

            document.querySelectorAll('.admin-sidebar-link--parent').forEach(btn => {
                btn.addEventListener('click', () => {
                    if (body.classList.contains('sidebar-collapsed')) return;
                    const item = btn.closest('.admin-sidebar-item, .admin-sidebar-subitem');
                    if (!item) return;
                    const isOpen = item.classList.toggle('open');
                    btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                });
            });
        });
    </script>
@endonce

<button class="admin-sidebar-toggle" type="button" aria-label="Open menu" data-admin-sidebar-toggle>
    <span></span><span></span><span></span>
</button>

<div class="admin-sidebar-overlay" data-admin-sidebar-overlay></div>

<aside class="admin-sidebar" aria-label="Staff sidebar">
    <a href="{{ route('book.index') }}" class="admin-sidebar-brand">
        <img src="{{ asset('images/pantasLogo.png') }}"
             alt="{{ config('app.name', 'Pantas') }}"
             class="admin-sidebar-brand-img"
             width="200" height="44"
             style="max-width:100%;height:auto;display:block;">
        <span class="admin-sidebar-brand-seal" aria-hidden="true">
            <img src="{{ asset('images/USM_logo.png') }}" alt="" width="40" height="40"
                 style="height:100%;width:auto;max-width:none;">
        </span>
        <span class="admin-sidebar-brand-role">
            {{ ucfirst($user->role ?? 'Staff') }} Dashboard
        </span>
    </a>

    <nav class="admin-sidebar-nav">
        @foreach($navLinks as $link)
            @php
                $hasChildren    = !empty($link['children']);
                $linkActive     = $isActive($link['patterns']);
                $anyChildActive = $hasChildren && collect($link['children'])->contains(fn($c) => $isActive($c['patterns']));
                $open           = $linkActive || $anyChildActive;
            @endphp

            @if($hasChildren)
                <div class="admin-sidebar-item {{ $open ? 'open' : '' }}">
                    <button class="admin-sidebar-link admin-sidebar-link--parent {{ $open ? 'active' : '' }}"
                            type="button" aria-expanded="{{ $open ? 'true' : 'false' }}"
                            title="{{ $link['label'] }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $icon($link['icon']) !!}</svg>
                        <span>{{ $link['label'] }}</span>
                        <svg class="admin-sidebar-caret" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div class="admin-sidebar-submenu">
                        @foreach($link['children'] as $child)
                            @php $childActive = $isActive($child['patterns']); @endphp
                            <a href="{{ route($child['route']) }}"
                               class="admin-sidebar-link admin-sidebar-link--child {{ $childActive ? 'active' : '' }}"
                               title="{{ $child['label'] }}"
                               @if(!empty($child['target'])) target="{{ $child['target'] }}" rel="noopener" @endif
                               @if($childActive) aria-current="page" @endif>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $icon($child['icon']) !!}</svg>
                                <span>{{ $child['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <a href="{{ route($link['route']) }}"
                   class="admin-sidebar-link {{ $linkActive ? 'active' : '' }}"
                   title="{{ $link['label'] }}"
                   @if(!empty($link['target'])) target="{{ $link['target'] }}" rel="noopener" @endif
                   @if($linkActive) aria-current="page" @endif>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $icon($link['icon']) !!}</svg>
                    <span>{{ $link['label'] }}</span>
                    <svg class="admin-sidebar-caret" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            @endif
        @endforeach
    </nav>

    <div class="admin-sidebar-user">
        <div class="admin-sidebar-avatar" title="{{ $user->name ?? trim(($user->fname ?? '').' '.($user->lname ?? '')) }}">
            {{ strtoupper(substr($user->fname ?? $user->name ?? 'A', 0, 1)) }}
        </div>
        <button type="button" class="admin-sidebar-logout-btn" data-bs-toggle="modal" data-bs-target="#logoutModal" aria-label="Log out" title="Log out">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 17l5-5-5-5"/><path d="M15 12H3"/><path d="M21 19V5a2 2 0 0 0-2-2h-4"/></svg>
            <span>Log out</span>
        </button>
    </div>
</aside>

<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:380px">
        <div class="modal-content" style="border:none;border-radius:14px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.18);">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <div style="width:48px;height:48px;border-radius:50%;background:#fee2e2;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10 17l5-5-5-5"/><path d="M15 12H3"/><path d="M21 19V5a2 2 0 0 0-2-2h-4"/>
                    </svg>
                </div>
            </div>
            <div class="modal-body text-center px-4 pt-3 pb-2">
                <h6 class="fw-700 mb-1" style="font-size:1rem;font-weight:700;color:#111;font-family:'Segoe UI',sans-serif;">Sign out</h6>
                <p class="text-muted mb-0" style="font-size:0.85rem;font-family:'Segoe UI',sans-serif;">Are you sure you want to log out of your account?</p>
            </div>
            <div class="modal-footer border-0 px-4 pb-4 pt-2 d-flex gap-2 justify-content-center">
                <button type="button" class="btn btn-light btn-sm px-4 fw-600" data-bs-dismiss="modal"
                    style="border-radius:8px;font-weight:600;font-family:'Segoe UI',sans-serif;border:1.5px solid #e5e7eb;">
                    Cancel
                </button>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm px-4"
                        style="border-radius:8px;background:#dc2626;border:none;color:#fff;font-weight:600;font-family:'Segoe UI',sans-serif;">
                        Yes, log out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
