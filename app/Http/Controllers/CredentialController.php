<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Business;
use App\Models\Employee;
use App\Models\Credential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateCredentialRequest;

class CredentialController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('credentials as c')->select('c.*', 'u.name as user_name', 'b.name as business_name', 'ceo.name as ceo_name', 'contact.name as contact_name', 'contact.phone as contact_phone')->leftJoin('users as u', 'u.id', '=', 'c.user_id')->leftJoin('businesses as b', 'b.id' , '=', 'c.business_id')->leftJoin('employees as ceo', 'ceo.id', '=', 'b.ceo_id')->leftJoin('employees as contact', 'contact.id', '=', 'b.contact_id')->orderBy('c.code');
        if ($request->has('search')) {
            if (strlen($request->search) > 0) {
                $query->where(function($q) use ($request) {
                    return $q->orWhere(DB::raw('upper(c.code)'), 'like', '%'.trim(mb_strtoupper($request->search)).'%')->orWhere(DB::raw('upper(b.name)'), 'like', '%'.trim(mb_strtoupper($request->search)).'%');
                });
            }
        }

        return [
            'message' => 'Lista de registros',
            'payload' => $query->paginate($request->per_page ?? 8, ['*'], 'page', $request->page ?? 1),
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'min:1', 'max:255', 'unique:credentials,code'],
            'year_start' => ['required', 'integer', 'min:2000', 'max:2030'],
            'year_end' => ['required', 'integer', 'min:2000', 'max:2030'],
            'business_name' => ['required', 'string', 'min:1', 'max:255', 'unique:businesses,name'],
            'nit' => ['sometimes', 'nullable', 'numeric', 'min:0', 'max:18446744073709551615'],
            'business_code' => ['sometimes', 'nullable', 'string', 'min:1', 'max:255'],
            'address' => ['sometimes', 'nullable', 'string', 'min:1', 'max:255'],
            'ceo_name' => ['required', 'string', 'min:1', 'max:255'],
            'ceo_ci' => ['required', 'numeric', 'min:0', 'max:18446744073709551615'],
            'ceo_ci_complement' => ['sometimes', 'nullable', 'string', 'min:1', 'max:3'],
            'ceo_city_id' => ['sometimes', 'nullable', 'integer', 'exists:cities,id'],
            'ceo_phone' => ['sometimes', 'nullable', 'numeric', 'min:0', 'max:79999999'],
            'contact_name' => ['required', 'string', 'min:1', 'max:255'],
            'contact_ci' => ['required', 'numeric', 'min:0', 'max:18446744073709551615'],
            'contact_ci_complement' => ['sometimes', 'nullable', 'string', 'min:1', 'max:3'],
            'contact_city_id' => ['sometimes', 'nullable', 'integer', 'exists:cities,id'],
            'contact_phone' => ['sometimes', 'nullable', 'numeric', 'min:0', 'max:79999999'],
        ]);
        if ($request->year_end <= $request->year_start) {
            return response()->json([
                'message' => 'Error en los datos del formulario',
                'errors' => [
                    'year_end' => ['La gestión final debe ser mayor a la inicial']
                ]
            ], 422);
        }

        DB::beginTransaction();
        try {
            $ceo = Employee::create([
                'name' => $request->ceo_name,
                'phone' => $request->ceo_phone,
                'ci' => $request->ceo_ci,
                'ci_complement' => $request->ceo_ci_complement,
                'city_id' => $request->ceo_city_id,
            ]);
            $contact = Employee::create([
                'name' => $request->contact_name,
                'phone' => $request->contact_phone,
                'ci' => $request->contact_ci,
                'ci_complement' => $request->contact_ci_complement,
                'city_id' => $request->contact_city_id,
            ]);
            $business = Business::create([
                'name' => $request->business_name,
                'nit' => $request->nit,
                'code' => $request->business_code,
                'address' => $request->address,
                'ceo_id' => $ceo->id,
                'contact_id' => $contact->id,
            ]);
            $credential = Credential::create([
                'code' => $request->code,
                'year_start' => $request->year_start,
                'year_end' => $request->year_end,
                'user_id' => Auth::user()->id,
                'business_id' => $business->id,
            ]);
            DB::commit();
            return [
                'message' => 'Registro almacenado',
                'payload' => [
                    'credential' => $credential,
                    'business' => $business,
                ],
            ];
        } catch(Exception $error) {
            logger($error);
            DB::rollBack();
            return response()->json([
                'message' => 'Error de registro',
            ], 500);
        }
    }

    public function show(Credential $credential)
    {
        return [
            'message' => 'Detalle del registro',
            'payload' => DB::table('credentials as c')->select('c.*', 'u.name as user_name', 'b.name as business_name', 'b.nit', 'b.code as business_code', 'b.address', 'b.ceo_id', 'b.contact_id', 'ceo.name as ceo_name', 'ceo.ci as ceo_ci', 'ceo.ci_complement as ceo_ci_complement', 'ceo.city_id as ceo_city_id', 'ceo.phone as ceo_phone', 'contact.name as contact_name', 'contact.ci as contact_ci', 'contact.ci_complement as contact_ci_complement', 'contact.city_id as contact_city_id', 'contact.phone as contact_phone')->leftJoin('users as u', 'u.id', '=', 'c.user_id')->leftJoin('businesses as b', 'b.id' , '=', 'c.business_id')->leftJoin('employees as ceo', 'ceo.id', '=', 'b.ceo_id')->leftJoin('employees as contact', 'contact.id', '=', 'b.contact_id')->where('c.id', $credential->id)->first(),
        ];
    }

    public function update(Request $request, Credential $credential)
    {
        $request->validate([
            'id' => ['required', 'integer', 'exists:credentials,id'],
            'code' => ['required', 'string', 'min:1', 'max:255', 'unique:credentials,code,'.$request->id],
            'year_start' => ['required', 'integer', 'min:2000', 'max:2030'],
            'year_end' => ['required', 'integer', 'min:2000', 'max:2030'],
            'business_id' => ['required', 'integer', 'exists:businesses,id'],
            'business_name' => ['required', 'string', 'min:1', 'max:255', 'unique:businesses,name,'.$request->business_id],
            'nit' => ['sometimes', 'nullable', 'numeric', 'min:0', 'max:18446744073709551615'],
            'business_code' => ['sometimes', 'nullable', 'string', 'min:1', 'max:255'],
            'address' => ['sometimes', 'nullable', 'string', 'min:1', 'max:255'],
            'ceo_id' => ['required', 'integer', 'exists:employees,id'],
            'ceo_name' => ['required', 'string', 'min:1', 'max:255'],
            'ceo_ci' => ['required', 'numeric', 'min:0', 'max:18446744073709551615'],
            'ceo_ci_complement' => ['sometimes', 'nullable', 'string', 'min:1', 'max:3'],
            'ceo_city_id' => ['sometimes', 'nullable', 'integer', 'exists:cities,id'],
            'ceo_phone' => ['sometimes', 'nullable', 'numeric', 'min:0', 'max:79999999'],
            'contact_id' => ['required', 'integer', 'exists:employees,id'],
            'contact_name' => ['required', 'string', 'min:1', 'max:255'],
            'contact_ci' => ['required', 'numeric', 'min:0', 'max:18446744073709551615'],
            'contact_ci_complement' => ['sometimes', 'nullable', 'string', 'min:1', 'max:3'],
            'contact_city_id' => ['sometimes', 'nullable', 'integer', 'exists:cities,id'],
            'contact_phone' => ['sometimes', 'nullable', 'numeric', 'min:0', 'max:79999999'],
        ]);
        if ($request->year_end <= $request->year_start) {
            return response()->json([
                'message' => 'Error en los datos del formulario',
                'errors' => [
                    'year_end' => ['La gestión final debe ser mayor a la inicial']
                ]
            ], 422);
        }

        DB::beginTransaction();
        try {
            Employee::find($request->ceo_id)->update([
                'name' => $request->ceo_name,
                'phone' => $request->ceo_phone,
                'ci' => $request->ceo_ci,
                'ci_complement' => $request->ceo_ci_complement,
                'city_id' => $request->ceo_city_id,
            ]);
            Employee::find($request->contact_id)->update([
                'name' => $request->contact_name,
                'phone' => $request->contact_phone,
                'ci' => $request->contact_ci,
                'ci_complement' => $request->contact_ci_complement,
                'city_id' => $request->contact_city_id,
            ]);
            Business::find($request->business_id)->update([
                'name' => $request->business_name,
                'nit' => $request->nit,
                'code' => $request->business_code,
                'address' => $request->address,
            ]);
            Credential::find($request->id)->update([
                'code' => $request->code,
                'year_start' => $request->year_start,
                'year_end' => $request->year_end,
                'user_id' => Auth::user()->id,
            ]);
            DB::commit();
            return [
                'message' => 'Registro actualizado',
                'payload' => [
                    'credential' => $credential,
                    'business' => $credential->business,
                ],
            ];
        } catch(Exception $error) {
            logger($error);
            DB::rollBack();
            return response()->json([
                'message' => 'Error de registro',
            ], 500);
        }
    }

    public function destroy(Credential $credential)
    {
        $credential->delete();
        return [
            'message' => 'Registro eliminado',
        ];
    }
}
