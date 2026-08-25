<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use App\Models\Culto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnuncioController extends Controller
{
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
            $validated['imagen'] = $request->file('imagen')->store('anuncios', 'public');
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
            $this->borrarImagenLocal($anuncio->imagen);
            $validated['imagen'] = $request->file('imagen')->store('anuncios', 'public');
        } elseif ($request->boolean('eliminar_imagen')) {
            $this->borrarImagenLocal($anuncio->imagen);
            $validated['imagen'] = null;
        }

        unset($validated['eliminar_imagen']);
        $anuncio->update($validated);
        return redirect()->route('anuncios.admin')->with('success', 'Anuncio actualizado correctamente.');
    }

    public function destroy(Anuncio $anuncio)
    {
        $this->borrarImagenLocal($anuncio->imagen);
        $anuncio->delete();
        return redirect()->route('anuncios.admin')->with('success', 'Anuncio eliminado correctamente.');
    }

    public function toggle(Anuncio $anuncio)
    {
        $anuncio->activo = !$anuncio->activo;
        $anuncio->save();
        return back()->with('success', 'Estado actualizado.');
    }

    private function borrarImagenLocal(?string $ruta): void
    {
        if ($ruta && !str_starts_with($ruta, 'http')) {
            Storage::disk('public')->delete($ruta);
        }
    }
}
