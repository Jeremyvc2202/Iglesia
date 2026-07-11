<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use App\Models\Culto;
use Illuminate\Http\Request;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Exception;
use Illuminate\Support\Facades\Log;

class AnuncioController extends Controller
{
    private function configureCloudinary()
    {
        Configuration::instance([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'imagen' => 'nullable|image|max:4096',
            'fecha_evento' => 'nullable|date',
        ]);

        $validated['activo'] = $request->has('activo');

        try {
            if ($request->hasFile('imagen')) {
                $this->configureCloudinary();
                $result = (new UploadApi())->upload($request->file('imagen')->getRealPath(), ['folder' => 'anuncios']);
                $validated['imagen'] = $result['secure_url'];
            }
        } catch (\Exception $e) {
            Log::error("Error Cloudinary (Store Anuncio): " . $e->getMessage());
            return back()->withErrors(['imagen' => 'Error subiendo imagen: ' . $e->getMessage()]);
        }

        Anuncio::create($validated);
        return redirect()->route('anuncios.admin')->with('success', 'Anuncio creado correctamente.');
    }

    public function update(Request $request, Anuncio $anuncio)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'imagen' => 'nullable|image|max:4096',
            'eliminar_imagen' => 'nullable|boolean',
            'fecha_evento' => 'nullable|date',
        ]);

        $validated['activo'] = $request->has('activo');

        try {
            if ($request->hasFile('imagen')) {
                $this->configureCloudinary();
                $result = (new UploadApi())->upload($request->file('imagen')->getRealPath(), ['folder' => 'anuncios']);
                $validated['imagen'] = $result['secure_url'];
            } elseif ($request->boolean('eliminar_imagen')) {
                $validated['imagen'] = null;
            }
        } catch (\Exception $e) {
            Log::error("Error Cloudinary (Update Anuncio): " . $e->getMessage());
            return back()->withErrors(['imagen' => 'Error subiendo imagen: ' . $e->getMessage()]);
        }

        unset($validated['eliminar_imagen']);
        $anuncio->update($validated);
        return redirect()->route('anuncios.admin')->with('success', 'Anuncio actualizado correctamente.');
    }

    // ... (Mantén tus otros métodos: index, admin, toggle, create, edit, destroy iguales)
}