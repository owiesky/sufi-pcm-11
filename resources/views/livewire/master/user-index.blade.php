<div>
    @php
        $users = App\Models\User::paginate(10);
        $headers = [
        ['key' => 'id', 'label' => 'ID', 'class' => 'bg-red-100 w-1'],
        ['key' => 'name', 'label' => 'Nama'],
        ['key' => 'username', 'label' => 'Username', 'class' => 'hidden lg:table-cell'],
        ['key' => 'phone', 'label' => 'Handphone', 'class' => 'hidden lg:table-cell'],
    ];
    @endphp

    <x-mary-header title="User Index" subtitle="Manajemen Data">
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-magnifying-glass" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-plus" class="btn-primary" wire:click="add()" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-table :headers="$headers" :rows="$users" with-pagination >
        @scope('cell_id', $user)
            <strong>{{ $user->id }}</strong>
        @endscope

        @scope('header_id', $header)
        <h2 class="text-base ">{{ $header['label'] }}</h2>
        @endscope

        @scope('header_name', $header)
            <h2 class="text-base ">{{ $header['label'] }}</h2>
        @endscope

        @scope('header_username', $header)
            <div class="text-base">{{ $header['label'] }}</div>
        @endscope

        @scope('header_phone', $header)
            <div class="text-base">{{ $header['label'] }}</div>
        @endscope

        @scope('actions', $user)
        <div class="flex justify-center">
            <x-mary-button icon="o-pencil" wire:click="edit({{ $user->id }})" spinner class="btn-sm" />
            <x-mary-button icon="o-trash" wire:click="delete({{ $user->id }})" spinner class="btn-sm" wire:confirm="Anda yakin akan menghapus data ?" />
        </div>
        @endscope
    </x-mary-table>

    <x-mary-modal  wire:model="showUserModal" title="Detail Info" separator>
        <div>
            <x-mary-form wire:submit="save($id)">
                <x-mary-input class="bg-slate-50" label="Name" wire:model.blur="form.name" />
                <x-mary-input class="bg-slate-50" label="Username" wire:model.blur="form.username" />
                <x-mary-input class="bg-slate-50" label="Handphone" wire:model.blur="form.phone" />
                <x-mary-input class="bg-slate-50" label="Email" wire:model.blur="form.email" />
                <x-mary-input class="bg-slate-50" label="Password" wire:model="form.password" type="password"/>
                <x-slot:actions>
                    <x-mary-button label="Batal" wire:click="cancel()" />
                    <x-mary-button type="submit" label="Simpan" class="btn-primary"  spinner="save" />
                </x-slot:actions>
            </x-mary-form>
        </div>
    </x-mary-modal>

    @if(session()->has('success'))
    <x-mary-alert icon="o-exclamation-triangle" class="alert-info mt-5">
        {{ session()->get('success') }}
    </x-mary-alert>
    @endif
    @if(session()->has('error'))
    <x-mary-alert icon="o-exclamation-triangle" class="alert-warning mt-5">
        {{ session()->get('error') }}
    </x-mary-alert>
    @endif
</div>
