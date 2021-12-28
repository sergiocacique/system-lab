<?php

namespace App\Http\Controllers;

use App\Http\Requests\AulaRequest;
use App\Models\Aula;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Inertia\Inertia;

class AulaController extends Controller
{
    public function index()
    {
        $aulas = Aula::orderBy('day', 'DESC')->get();

        $filter = request('filter');

        if ($filter) {
            if ($filter === 'Dia') {
                $aulas = Aula::where('day', today()->format('Y-m-d'))
                    ->orderBy('day', 'DESC')
                    ->get();
            } elseif ($filter === 'Semana') {
                $aulas = Aula::whereBetween(
                    'day',
                    [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
                )
                    ->orderBy('day', 'DESC')
                    ->get();
            }
        }

        return Inertia::render('Aulas/Index', ['aulas' => $aulas, 'filterInit' => $filter ?? 'Todos']);
    }

    public function create()
    {
        return Inertia::render('Aulas/Create');
    }

    public function store(AulaRequest $request)
    {
        $existAula = $this->timeCourseValid($request);

        if ($existAula) {
            $message = <<<MSG
                Já existem aulas neste mesmo intervalo de data e horário.
                Favor, tente com outra data.
            MSG;

            $error = new MessageBag(['timeCourse' => $message]);

            return back()->withErrors($error);
        }

        Aula::create($request->all());

        return redirect()->route('dashboard.aulas.index');
    }

    public function edit(Aula $aula)
    {
        return Inertia::render('Aulas/Edit', ['aula' => $aula]);
    }

    public function update(AulaRequest $request, Aula $aula)
    {
        $existAula = $this->timeCourseValid($request, $request->id);

        if ($existAula) {
            $message = <<<MSG
                Já existem aulas neste mesmo intervalo de data e horário.
                Favor, tente com outra data.
            MSG;

            $error = new MessageBag(['timeCourse' => $message]);

            return back()->withErrors($error);
        }

        $aula->update($request->all());

        return back();
    }

    public function destroy(Aula $aula)
    {
        $aula->delete();
        return back();
    }

    public function checkin(Request $request)
    {
        $aluno = Auth::user()->aluno;
        $aula = Aula::find($request->aula['id']);

        $aulaCurrent = $aula->alunos()->firstWhere('aluno_id', $aluno->id);

        if (!$aulaCurrent) {
            $aluno->aulas()->attach($aula->id, ['checkin' => false]);
            $aulaCurrent = $aula->alunos()->firstWhere('aluno_id', $aluno->id);
        }

        $checkin_request = $request->aula['checkin_pivot'];

        if ($aula->checkin_count < $aula->seat_limit) {

            $aulaCurrent->pivot->checkin = $checkin_request;
            $aulaCurrent->pivot->save();

            $this->updateCheckin($aulaCurrent, $request, $aula);

            return redirect()->back();
        }

        return redirect()->back()->withErrors(new MessageBag(['seat_limit' => 'Esta aula não possui mais vagas']));
    }

    private function updateCheckin($aulaCurrent, Request $request, Aula $aula)
    {
        $aulaCurrent->pivot->checkin = $request->aula['checkin_pivot'];
        $aulaCurrent->pivot->save();

        if ($aulaCurrent->pivot->checkin) {
            $aula->seat_limit--;
            $aula->save();
        } elseif (
            !$aulaCurrent->pivot->checkin  &&
            $request->aula['seat_limit'] === $aula->seat_limit
        ) {
            $aula->seat_limit++;
            $aula->save();
        }
    }

    private function timeCourseValid(Request $request, $aula_id = null): bool
    {
        $existAula = null;

        if ($aula_id) {
            $existAula = Aula::where([
                ['day', $request->day],
                ['id', '!=', $aula_id],
            ])
                ->where(function ($query) use ($request) {
                    $query
                        ->whereBetween('hour_start', [$request->hour_start, $request->hour_end])
                        ->orWhereBetween('hour_end', [$request->hour_start, $request->hour_end]);
                })->exists();
        } else {
            $existAula = Aula::where('day', $request->day)
                ->where(function ($query) use ($request) {
                    $query
                        ->whereBetween('hour_start', [$request->hour_start, $request->hour_end])
                        ->orWhereBetween('hour_end', [$request->hour_start, $request->hour_end]);
                })->exists();
        }

        return $existAula;
    }
}
