<?php

namespace App\Livewire\Forms;

use App\Models\Vendor;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class VendorForm extends Form
{
    public ?Vendor $vendor = null;
    public string $id = '';

    #[Validate()]
    public string $name = '';
    #[Validate()]
    public string $description = '';

    public bool $isAdd = false;
    public bool $isEdit = false;

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:5',
                Rule::unique('vendors', 'name')->ignore($this->vendor),
            ],
            'description' => ['required', 'min:5'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama wajib di-isi',
            'name.min' => 'Minimal 5 karakter',
            'description.required' => 'Deskripsi wajib di-isi',
            'description.min' => 'Minimal 5 karakter',
        ];
    }

    public function setCreate(): void
    {
        $this->isAdd = true;
        $this->isEdit = false;
    }

    public function setUpdate(Vendor $vendor = null): void
    {
        $this->isAdd = false;
        $this->isEdit = true;

        $this->vendor = $vendor;
        $this->name = $vendor->name;
        $this->description = $vendor->description;
        //dd($this->name);
    }

    public function doDelete($id): void
    {
        try {
            Vendor::find($id)->delete();
            session()->flash('success', "Berhasil dihapus");
        } catch (\Exception $e) {
            session()->flash('error', "Gagal dihapus");
        }
    }

    public function doCancel(): void
    {
        //dd('doCancel');
        $this->reset();
    }

    public function store(): void
    {
        $validated = $this->validate();
        if ($this->isAdd === true) {
            try {
                //dd('doCreate');
                Vendor::create($validated);
                $this->reset();
                $this->isAdd = false;
                session()->flash('success', 'Data baru tersimpan.');
            } catch (\Exception $ex) {
                session()->flash('error', 'Terjadi kesalahan.');
            }
        } elseif ($this->isEdit === true) {
            try {
                //dd('doUpdate');
                $this->vendor->update($validated);
                $this->reset();
                $this->isEdit = false;
                session()->flash('success', 'Data perubahan tersimpan.');
            } catch (\Exception $ex) {
                session()->flash('error', 'Terjadi kesalahan.');
            }
        }
        $this->reset();
    }
}
