<?php

namespace App\Http\Controllers;

use App\Models\DrillingGrid;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\File;

class ImageMagickPdfController extends Controller
{
    public function viewAsImage($id, $page = 1)
    {
        $grid = DrillingGrid::findOrFail($id);

        if (!$grid->pdf_file || !Storage::disk('public')->exists($grid->pdf_file)) {
            abort(404, 'Archivo no encontrado.');
        }

        $pdfPath = Storage::disk('public')->path($grid->pdf_file);

        // Crear directorio temporal
        $tempDir = storage_path('app/temp/pdf_images');
        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0755, true);
        }

        $imagePath = $tempDir . DIRECTORY_SEPARATOR . 'pdf_' . $id . '_page_' . ($page - 1) . '.png';

        // Verificar si necesitamos regenerar las imágenes
        if (!File::exists($imagePath) || File::lastModified($pdfPath) > File::lastModified($imagePath)) {
            $this->convertPdfToImages($pdfPath, $tempDir, $id);
        }

        if (!File::exists($imagePath)) {
            abort(500, 'No se pudo generar la imagen del PDF');
        }

        return response()->file($imagePath, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache'
        ]);
    }

    public function getPageCount($id)
    {
        $grid = DrillingGrid::findOrFail($id);

        if (!$grid->pdf_file || !Storage::disk('public')->exists($grid->pdf_file)) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }

        $pdfPath = Storage::disk('public')->path($grid->pdf_file);

        try {
            // Usar ImageMagick para contar páginas
            $command = sprintf('magick identify -format "%%n\n" "%s"', $pdfPath);
            $result = Process::run($command);

            if ($result->successful()) {
                $lines = array_filter(explode("\n", trim($result->output())));
                $pageCount = count($lines);

                return response()->json([
                    'total_pages' => $pageCount > 0 ? $pageCount : 1,
                    'grid_name' => $grid->name
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('Error contando páginas: ' . $e->getMessage());
        }

        return response()->json(['total_pages' => 1, 'grid_name' => $grid->name]);
    }

    private function convertPdfToImages($pdfPath, $outputDir, $gridId)
    {
        // Usar ImageMagick para convertir todas las páginas
        $outputPattern = $outputDir . DIRECTORY_SEPARATOR . 'pdf_' . $gridId . '_page_%d.png';

        $command = sprintf(
            'magick -density 150 -quality 85 "%s" "%s"',
            $pdfPath,
            $outputPattern
        );

        try {
            $result = Process::run($command);

            if (!$result->successful()) {
                \Log::error('Error en ImageMagick: ' . $result->errorOutput());
                throw new \Exception('Conversión falló: ' . $result->errorOutput());
            }

            return true;

        } catch (\Exception $e) {
            \Log::error('Error ejecutando ImageMagick: ' . $e->getMessage());
            throw $e;
        }
    }
}
