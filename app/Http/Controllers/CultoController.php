<?php

namespace App\Http\Controllers;

use App\Models\Culto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CultoController extends Controller
{
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

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('cultos', 'public');
        }

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
            if ($culto->imagen) Storage::disk('public')->delete($culto->imagen);
            $validated['imagen'] = $request->file('imagen')->store('cultos', 'public');
        } elseif ($request->boolean('eliminar_imagen') && $culto->imagen) {
            Storage::disk('public')->delete($culto->imagen);
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
        if ($culto->imagen) Storage::disk('public')->delete($culto->imagen);
        $culto->delete();
        return redirect()->route('anuncios.admin')->with('success', 'Culto eliminado correctamente.');
    }
}