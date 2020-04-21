<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegistroRequest;
use App\Registro;
use App\Tag;
use App\Http\Controllers\Controller;
use App\Services\RegistrosService;
use Carbon\Carbon;
use Illuminate\Http\Response;
use DB;

class RegistrosController extends Controller
{
    private $registro;

    public function __construct(RegistrosService $registrosService)
    {
        return $this->registrosService = $registrosService;
    }

    public function index()
    {
        return $this->registrosService->index();
    }

    public function show($id)
    {
        return $this->registrosService->index($id);
    }

    public function store(RegistroRequest $request)
    {
        return $this->registrosService->index($request);
    }

    public function update($id, RegistroRequest $request)
    {
        return $this->registrosService->index($id, $request);
    }

    public function destroy($id)
    {
        return $this->registrosService->index($id);
    }

    public function baixa($id)
    {
        return $this->registrosService->index($id);
    }

    public function searchForTags($id)
    {
        return $this->registrosService->index($id);
    }
}
