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
                'cloud_name' => config('services.cloudinary.cloud_name'),
                'api_key'    => config('services.cloudinary.api_key'),
                'api_secret' => config('services.cloudinary.api_secret'),
            ],
        ]);
    }

    public function index()
    {
        $anuncios = Anuncio::where('activo', true)
            ->orderByRaw('fecha_evento IS NULL ASC')
            ->orderBy('fecha_evento', 'asc')
            ->orderByDesc('created_at')
            ->get();
        
        $cultos = Culto::where('activo', true)->get();

        return view('anuncios.index', compact('anuncios', 'cultos'));
    }

    public function admin()
    {
        $anuncios = Anuncio::orderByDesc('created_at')->get();
        $cultos = Culto::all();
        return view('anuncios.admin', compact('anuncios', 'cultos'));
    }

    public function create()
    {
        return view('anuncios.create');
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

        if ($request->hasFile('imagen')) {
            try {
                $this->configureCloudinary();
                $result = (new UploadApi())->upload($request->file('imagen')->getRealPath(), ['folder' => 'anuncios']);
                $validated['imagen'] = $result['secure_url'];
            } catch (Exception $e) {
                Log::error("Error Cloudinary: " . $e->getMessage());
                return back()->withErrors(['imagen' => 'No se pudo subir la imagen a la nube.']);
            }
        }

        Anuncio::create($validated);
        return redirect()->route('anuncios.admin')->with('success', 'Anuncio creado correctamente.');
    }

    public function edit(Anuncio $anuncio)
    {
        return view('anuncios.edit', compact('anuncio'));
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

        if ($request->hasFile('imagen')) {
            try {
                $this->configureCloudinary();
                $result = (new UploadApi())->upload($request->file('imagen')->getRealPath(), ['folder' => 'anuncios']);
                $validated['imagen'] = $result['secure_url'];
            } catch (Exception $e) {
                Log::error("Error Cloudinary: " . $e->getMessage());
                return back()->withErrors(['imagen' => 'Error subiendo la imagen.']);
            }
        } elseif ($request->boolean('eliminar_imagen')) {
            $validated['imagen'] = null;
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
        return back()->with('success', 'Estado actualizado.');
    }
}