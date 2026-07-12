<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use Illuminate\Http\Request;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
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

    public function index()
    {
        // Muestra los anuncios activos en la página principal
        $anuncios = Anuncio::where('activo', true)->latest()->get();
        return view('index', compact('anuncios'));
    }

    public function admin()
    {
        // Muestra el listado de anuncios en el panel administrativo
        $anuncios = Anuncio::latest()->get();
        return view('admin.anuncios.index', compact('anuncios'));
    }

    public function create()
    {
        return view('admin.anuncios.create');
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

    public function edit(Anuncio $anuncio)
    {
        return view('admin.anuncios.edit', compact('anuncio'));
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

    public function destroy(Anuncio $anuncio)
    {
        $anuncio->delete();
        return redirect()->route('anuncios.admin')->with('success', 'Anuncio eliminado correctamente.');
    }

    public function toggle(Anuncio $anuncio)
    {
        $anuncio->activo = !$anuncio->activo;
        $anuncio->save();
        return back()->with('success', 'Estado actualizado correctamente.');
    }
}