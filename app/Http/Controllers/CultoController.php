<?php

namespace App\Http\Controllers;

use App\Models\Culto;
use Illuminate\Http\Request;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class CultoController extends Controller
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

    public function create()
    {
        return view('cultos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'horario' => 'required|string|max:255',
            'imagen' => 'nullable|image|max:4096',
        ]);

        $validated['activo'] = $request->has('activo');

        // --- CÓDIGO COMENTADO PARA TESTEO DE AISLAMIENTO ---
        /*
        if ($request->hasFile('imagen')) {
            $this->configureCloudinary();
            $result = (new UploadApi())->upload($request->file('imagen')->getRealPath(), ['folder' => 'cultos']);
            $validated['imagen'] = $result['secure_url'];
        }
        */
        // ----------------------------------------------------

        Culto::create($validated);

        return redirect()->route('anuncios.admin')->with('success', 'Culto creado correctamente.');
    }

    public function edit(Culto $culto)
    {
        return view('cultos.edit', compact('culto'));
    }

    public function update(Request $request, Culto $culto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'horario' => 'required|string|max:255',
            'imagen' => 'nullable|image|max:4096',
            'eliminar_imagen' => 'nullable|boolean',
        ]);

        $validated['activo'] = $request->has('activo');

        if ($request->hasFile('imagen')) {
            $this->configureCloudinary();
            $result = (new UploadApi())->upload($request->file('imagen')->getRealPath(), ['folder' => 'cultos']);
            $validated['imagen'] = $result['secure_url'];
        } elseif ($request->boolean('eliminar_imagen')) {
            $validated['imagen'] = null;
        }

        unset($validated['eliminar_imagen']);
        $culto->update($validated);

        return redirect()->route('anuncios.admin')->with('success', 'Culto actualizado correctamente.');
    }

    public function toggle(Culto $culto)
    {
        $culto->activo = !$culto->activo;
        $culto->save();
        return back()->with('success', 'Estado del culto actualizado.');
    }

    public function destroy(Culto $culto)
    {
        $culto->delete();
        return redirect()->route('anuncios.admin')->with('success', 'Culto eliminado correctamente.');
    }
}