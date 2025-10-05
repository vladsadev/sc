<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;

// Agregar al inicio si no está
use App\Models\DrillingGrid;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class MallaDetail extends Component
{
    use WithFileUploads;

    public $grid = null;
    public $showModal = false;
    public $showDeleteModal = false; // Nueva propiedad para el modal de confirmación
    public $totalPages = 0; // Agregar esta propiedad


    // Form fields
    public $name;
    public $pdfFile = null;
    public $existingPdfFile = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'pdfFile' => 'nullable|file|mimes:pdf|max:10240',
    ];

    protected $messages = [
        'name.required' => 'El nombre de la malla es obligatorio.',
        'name.max' => 'El nombre no puede exceder 255 caracteres.',
        'pdfFile.mimes' => 'El archivo debe ser un PDF.',
        'pdfFile.max' => 'El archivo no puede exceder 10MB.',
    ];



    public function mount()
    {
        $this->loadGrid();
    }

    public function loadGrid()
    {
        $this->grid = DrillingGrid::first();

        // Obtener el número total de páginas si existe PDF
        if ($this->grid && $this->grid->pdf_file) {
            try {
                $response = Http::get(route('malla.pdf.pages', $this->grid->id));
                if ($response->successful()) {
                    $this->totalPages = $response->json()['total_pages'] ?? 0;
                }
            } catch (\Exception $e) {
                $this->totalPages = 1; // Fallback
            }
        }
    }

    public function openModal()
    {
        \Log::info('OpenModal llamado'); // Agrega esta línea temporalmente

        $this->resetErrorBag();
        $this->resetValidation();

        if ($this->grid) {
            // Edit mode - load existing data
            $this->name = $this->grid->name;
            $this->existingPdfFile = $this->grid->pdf_file;
        } else {
            // Create mode - reset form
            $this->name = '';
            $this->existingPdfFile = null;
        }

        $this->pdfFile = null;
        $this->showModal = true;
    }

    public function openDeleteModal()
    {
        $this->showDeleteModal = true;
    }

    // Nuevo método para abrir modal de confirmación de eliminación

    public function save()
    {
        // Validate only if creating new or if PDF is being uploaded
        if (!$this->grid) {
            $this->validate([
                'name' => 'required|string|max:255',
                'pdfFile' => 'required|file|mimes:pdf|max:10240',
            ]);
        } else {
            $this->validate();
        }

        try {
            $pdfPath = $this->existingPdfFile;

            // Handle file upload if present
            if ($this->pdfFile) {
                // Delete old PDF if exists
                if ($this->grid && $this->grid->pdf_file && Storage::disk('public')->exists($this->grid->pdf_file)) {
                    Storage::disk('public')->delete($this->grid->pdf_file);
                }

                $filename = 'malla_' . time() . '.pdf';
                $pdfPath = $this->pdfFile->storeAs('drilling-grids', $filename, 'public');
            }

            if ($this->grid) {
                // Update existing grid
                $this->grid->update([
                    'name' => $this->name,
                    'pdf_file' => $pdfPath,
                ]);
                session()->flash('message', 'Malla de perforaciones actualizada exitosamente.');
            } else {
                // Create new grid
                DrillingGrid::create([
                    'name' => $this->name,
                    'pdf_file' => $pdfPath,
                ]);
                session()->flash('message', 'Malla de perforaciones creada exitosamente.');
            }

            $this->closeModal();
            $this->loadGrid();

        } catch (\Exception $e) {
            session()->flash('error', 'Error al guardar la malla: ' . $e->getMessage());
        }
    }

    // Nuevo método para cerrar modal de confirmación de eliminación

    public function delete()
    {
        try {
            if ($this->grid) {
                // Eliminar el archivo PDF del storage si existe
                if ($this->grid->pdf_file && Storage::disk('public')->exists($this->grid->pdf_file)) {
                    Storage::disk('public')->delete($this->grid->pdf_file);
                }

                // Eliminar el registro de la base de datos
                $this->grid->delete();

                // Mensaje de éxito
                session()->flash('message', 'Malla de perforaciones eliminada exitosamente.');

                // Recargar datos y cerrar modal
                $this->closeDeleteModal();
                $this->loadGrid();
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar la malla: ' . $e->getMessage());
            $this->closeDeleteModal();
        }
    }

    // Nuevo método para eliminar la malla

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->pdfFile = null;
        $this->existingPdfFile = null;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.malla-detail');
    }
}
