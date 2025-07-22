<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $priority = $request->query('priority');
        
        $tasks = Task::where('user_id', Auth::id())
                    ->search($search)
                    ->status($status)
                    ->priority($priority)
                    ->orderBy('due_date', 'asc')
                    ->paginate(10);
                    
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[a-zA-ZáéíóúñÑ0-9\s\-_.,]+$/'
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],
            'status' => [
                'required',
                'in:pendiente,completada'
            ],
            'priority' => [
                'required',
                'in:baja,media,alta'
            ],
            'due_date' => [
                'nullable',
                'date',
                'after_or_equal:today'
            ],
        ], [
            'title.required' => 'El título es obligatorio.',
            'title.min' => 'El título debe tener al menos 3 caracteres.',
            'title.max' => 'El título no puede exceder 255 caracteres.',
            'title.regex' => 'El título solo puede contener letras, números, espacios y algunos símbolos básicos.',
            'description.max' => 'La descripción no puede exceder 1000 caracteres.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado debe ser pendiente o completada.',
            'priority.required' => 'La prioridad es obligatoria.',
            'priority.in' => 'La prioridad debe ser baja, media o alta.',
            'due_date.date' => 'La fecha límite debe ser una fecha válida.',
            'due_date.after_or_equal' => 'La fecha límite no puede ser anterior a hoy.',
        ]);
        
        $validatedData['user_id'] = Auth::id();
        
        Task::create($validatedData);
        
        return redirect()->route('tasks.index')
            ->with('success', 'Tarea creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[a-zA-ZáéíóúñÑ0-9\s\-_.,]+$/'
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],
            'status' => [
                'required',
                'in:pendiente,completada'
            ],
            'priority' => [
                'required',
                'in:baja,media,alta'
            ],
            'due_date' => [
                'nullable',
                'date',
                'after_or_equal:today'
            ],
        ], [
            'title.required' => 'El título es obligatorio.',
            'title.min' => 'El título debe tener al menos 3 caracteres.',
            'title.max' => 'El título no puede exceder 255 caracteres.',
            'title.regex' => 'El título solo puede contener letras, números, espacios y algunos símbolos básicos.',
            'description.max' => 'La descripción no puede exceder 1000 caracteres.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado debe ser pendiente o completada.',
            'priority.required' => 'La prioridad es obligatoria.',
            'priority.in' => 'La prioridad debe ser baja, media o alta.',
            'due_date.date' => 'La fecha límite debe ser una fecha válida.',
            'due_date.after_or_equal' => 'La fecha límite no puede ser anterior a hoy.',
        ]);
        
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        $task->update($validatedData);
        
        return redirect()->route('tasks.index')
            ->with('success', 'Tarea actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        $task->delete();
        
        return redirect()->route('tasks.index')
            ->with('success', 'Tarea eliminada exitosamente.');
    }
    
    /**
     * Search for tasks
     */
    public function search(Request $request)
    {
        return $this->index($request);
    }
}
