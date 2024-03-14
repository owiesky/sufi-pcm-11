<div>
    @php
        //$customers = App\Models\Customer::paginate(10);
        $headers = [
        ['key' => 'id', 'label' => 'ID', 'class' => 'bg-red-100 w-1'],
        ['key' => 'name', 'label' => 'Nama'],
        ['key' => 'description', 'label' => 'Deskripsi', 'class' => 'hidden lg:table-cell']];

        //$customerProjects = App\Models\Project::paginate(3);
    @endphp

    <x-mary-header title="Customer Index" subtitle="Manajemen Data">
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-magnifying-glass" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-plus" class="btn-primary" wire:click="add()" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-table :headers="$headers" :rows="$customers" with-pagination >
        @scope('cell_id', $customer)
            <strong>{{ $customer->id }}</strong>
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

        @scope('actions', $customer)
        <div class="flex justify-center">
            <x-mary-button icon="o-eye" wire:click="showProject({{ $customer->id }})" spinner class="btn-sm" />
            <x-mary-button icon="o-pencil" wire:click="edit({{ $customer->id }})" spinner class="btn-sm" />
            <x-mary-button icon="o-trash" wire:click="delete({{ $customer->id }})" spinner class="btn-sm" />
        </div>
        @endscope
    </x-mary-table>

    <x-mary-modal  wire:model="showCustomerModal" title="Detail Info" separator>
        <div>
            <x-mary-form wire:submit="save($id)">
                <x-mary-input class="bg-slate-50" label="Name" wire:model.blur="form.name" />
                <x-mary-input class="bg-slate-50"  label="Deskripsi" wire:model.blur="form.description" />
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

    <x-mary-modal wire:model="showProjectModal" title="Project" separator>
        <div >
            {{-- @foreach($projects as $project)
                <x-mary-list-item class="bg-slate-50" :item="$project" link="#" />
            @endforeach --}}
            @if (is_iterable($projects))
                @forelse ($projects as $project )
                    <div class="flex">
                        <div>{{$project->name}}</div>
                        <div>{{$project->description}}</div>
                        <div class="divider divider-accent"></div>
                    </div>
                @empty
                    <span class="bg-slate-50">Customer Tidak Mempunyai Project</span>
                @endforelse
            @else
                <span>!iterable</span>
            @endif
        </div>
    </x-mary-modal>
</div>
