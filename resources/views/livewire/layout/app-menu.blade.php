<div>
    <x-slot:sidebar drawer="main-drawer" class="bg-neutral-100">
        {{-- Activates the menu item when a route matches the `link` property --}}
        <x-mary-menu activate-by-route>
            <x-mary-menu-item title="Home" icon="o-home" link="/dashboard" />
            <x-mary-menu-separator />
            {{-- Submenu --}}
            <x-mary-menu-sub title="Master" icon="fas.wand-magic-sparkles">
                <x-mary-menu-item title="User" icon="fas.user" link="/user"/>
                <x-mary-menu-item title="Role" icon="fas.user-group" />
                <x-mary-menu-item title="Permission" icon="fas.user-shield" />
                <x-mary-menu-item title="Customer" icon="fas.people-arrows" link="/customer" />
                <x-mary-menu-item title="Vendor" icon="fas.people-carry-box" link="/vendor"/>
                <x-mary-menu-item title="Armada" icon="o-truck" />
                <x-mary-menu-item title="Biaya" icon="o-banknotes" />
            </x-mary-menu-sub>

            <x-mary-menu-sub title="Manajemen" icon="fas.briefcase">
                <x-mary-menu-item title="Project" icon="fas.handshake" link="/project" />
                <x-mary-menu-item title="Project Item" icon="fas.cart-shopping" />
                <x-mary-menu-item title="Invoice" icon="fas.file-invoice-dollar" />
                {{-- <x-mary-menu-item title="> Order Detail" icon="fas.cart-plus" /> --}}
                <x-mary-menu-item title="Ka Lap Project" icon="fas.helmet-safety" />
                <x-mary-menu-item title="> PiC Surat Jalan" icon="fas.person-running" />
                <x-mary-menu-item title="> Pengajuan Keuangan" icon="far.pen-to-square" />
            </x-mary-menu-sub>

            <x-mary-menu-separator title="Transaksi" icon="o-sparkles" />
                <x-mary-menu-item title="Surat Jalan" icon="fas.file-signature" />
                <x-mary-menu-item title="Absensi" icon="far.address-book" />
                <x-mary-menu-item title="Timesheet" icon="fas.snowplow" />
                <x-mary-menu-item title="Kas Kecil" icon="fas.money-bill-1" />

            {{-- Separator with title and icon --}}
            <x-mary-menu-separator />
            <x-mary-menu-item title="Profile" icon="fas.user-pen" :href="route('profile')" wire:navigate/>
            <x-mary-menu-item title="Logout" icon="fas.right-from-bracket" link="/logout" wire:navigate/>
        </x-mary-menu>
    </x-slot:sidebar>
</div>
