<div>
    @php
        $projects = App\Models\Project::paginate(5);
        $headers = [
        ['key' => 'id', 'label' => 'ID', 'class' => 'bg-red-100 w-1'],
        ['key' => 'name', 'label' => 'Nama'],
        ['key' => 'description', 'label' => 'Deskripsi', 'class' => 'hidden lg:table-cell']];
        $customers = App\Models\Customer::all();
    @endphp

    <x-mary-header title="Project Index" subtitle="Manajemen Data">
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-magnifying-glass" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-plus" class="btn-primary" wire:click="add()" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-table :headers="$headers" :rows="$projects" with-pagination >
        @scope('cell_id', $project)
            <strong>{{ $project->id }}</strong>
        @endscope

        @scope('header_id', $header)
        <h2 class="text-base ">{{ $header['label'] }}</h2>
        @endscope

        @scope('header_name', $header)
            <h2 class="text-base ">{{ $header['label'] }}</h2>
        @endscope

        @scope('header_description', $header)
            <div class="text-base">{{ $header['label'] }}</div>
        @endscope

        @scope('actions', $project)
        <div class="flex justify-center">
            <x-mary-button icon="o-pencil" wire:click="edit({{ $project->id }})" spinner class="btn-sm" />
            <x-mary-button icon="o-trash" wire:click="delete({{ $project->id }})" spinner class="btn-sm" />
        </div>
        @endscope
    </x-mary-table>

    <x-mary-modal  wire:model="showProjectModal" title="Detail Info" separator>
        <div>
            <x-mary-form wire:submit="save($id)">
                <x-mary-input class="bg-slate-50" label="Name" wire:model.blur="form.name" />
                <x-mary-input class="bg-slate-50"  label="Deskripsi" wire:model.blur="form.description" />
                <x-mary-select class="bg-slate-50" label="Customer" icon-right="fas.people-arrows" :options="$customers" wire:model="form.selectedCustomer" inline />
                <x-slot:actions>
                    <x-mary-button label="Batal" wire:click="cancel()" />
                    <x-mary-button label="Simpan" class="btn-primary" type="submit" spinner="save" />
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
