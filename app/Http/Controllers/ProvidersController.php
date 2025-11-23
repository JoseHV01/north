<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Providers\App\Events\informationHasBeenRemoved;
use App\Http\Requests\ProvidersRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class ProvidersController extends Controller
{
    public function index()
    {
        $providersQuery = DB::table('providers')
            ->select(
                'providers.id as id',
                'providers.document as document',
                'providers.email as email',
                'providers.phone as phone',
                'providers.phone_secondary as phone_secondary',
                'providers.direction as direction',
                'providers.id as retention_agent',
                'providers.business_name as business_name',
                'providers.status as status',
                DB::raw("'provider' as type"),
                'providers.id_document_type as id_document_type',
                'document_types.name as document_type'
            )
            ->leftJoin('document_types', 'document_types.id', '=', 'providers.id_document_type');

        $customersQuery = DB::table('customers')
            ->select(
                'customers.id as id',
                'customers.document as document',
                'customers.email as email',
                'customers.phone as phone',
                'customers.phone_secondary as phone_secondary',
                'customers.id as direction',
                'customers.retention_agent as retention_agent',
                'customers.business_name as business_name',
                'customers.status as status',
                DB::raw("'customer' as type"),
                'customers.id_document_type as id_document_type',
                'document_types.name as document_type'
            )
            ->leftJoin('document_types', 'document_types.id', '=', 'customers.id_document_type');

        $combined = $providersQuery->unionAll($customersQuery);

        $providersCustomers = DB::query()
            ->fromSub($combined, 'combined')
            ->orderBy('status', 'DESC')
            ->orderBy('business_name', 'ASC')
            ->paginate(10);

        $document_types = DB::table('document_types')->orderBy('name', 'ASC')->get();

        return view('pages/providers')->with('providers', $providersCustomers)->with('document_types', $document_types);
    }

    public function store(ProvidersRequest $request)
    {
        DB::beginTransaction();
        try {

            DB::table('providers')->insert([
                'id_document_type' => $request->type_document,
                'document' => $request->document,
                'business_name' => $request->business_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'phone_secondary' => $request->phone_secondary,
                'direction' => $request->direction
            ]);

            DB::commit();
            return redirect()->back()->with('success', "Proveedor agregado");
        } catch (\Throwable $th) {
            return $th;
            DB::rollback();
            return back()->withErrors(['error' => "Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function update(ProvidersRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            DB::table('providers')->where('id', $id)->update([
                'id_document_type' => $request->type_document,
                'document' => $request->document,
                'business_name' => $request->business_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'phone_secondary' => $request->phone_secondary,
                'direction' => $request->direction
            ]);

            DB::commit();
            return redirect()->back()->with('success', "Proveedor editado");
        } catch (\Throwable $th) {
            return $th;
            DB::rollback();
            return back()->withErrors(['error' => "Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            event(new informationHasBeenRemoved($id, 'providers', $this->queryOperationsProvider($id)));
            DB::commit();
            return redirect()->back()->with('success', "Proveedor eliminado");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors(['error' => "Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    private function queryOperationsProvider($idProvider)
    {
        return DB::table('purchases_invoices')->where('id_provider', $idProvider)->exists();
    }

    public function searchProvider(Request $request)
    {
        // Buscar tanto providers como customers por razon social
        $q = trim((string) ($request->provider ?? $request->customer ?? ''));
        $qLower = $q !== '' ? mb_strtolower($q) : '';
        $type = $request->type ?? '';
        $dateStart = $request->date_start;
        $dateEnd = $request->date_end;

        // Providers query (mismo formato que en index)
        $providersQuery = DB::table('providers')
            ->select(
                'providers.id as id',
                'providers.document as document',
                'providers.email as email',
                'providers.phone as phone',
                'providers.phone_secondary as phone_secondary',
                'providers.direction as direction',
                'providers.id as retention_agent',
                'providers.business_name as business_name',
                'providers.status as status',
                DB::raw("'provider' as type"),
                'providers.id_document_type as id_document_type',
                'document_types.name as document_type'
            )
            ->leftJoin('document_types', 'document_types.id', '=', 'providers.id_document_type')
            ->orderBy('providers.status', 'DESC')
            ->orderBy('providers.business_name', 'ASC')
            ->when($qLower, function ($builder) use ($qLower) {
                // case-insensitive search
                $builder->whereRaw('LOWER(providers.business_name) LIKE ?', ["%{$qLower}%"]);
            })
            ->when($dateStart, function ($builder) use ($dateStart) {
                $builder->whereDate('providers.created_at', '>=', $dateStart);
            })
            ->when($dateEnd, function ($builder) use ($dateEnd) {
                $builder->whereDate('providers.created_at', '<=', $dateEnd);
            });

        // Customers query (mismo formato que en index)
        $customersQuery = DB::table('customers')
            ->select(
                'customers.id as id',
                'customers.document as document',
                'customers.email as email',
                'customers.phone as phone',
                'customers.phone_secondary as phone_secondary',
                'customers.id as direction',
                'customers.retention_agent as retention_agent',
                'customers.business_name as business_name',
                'customers.status as status',
                DB::raw("'customer' as type"),
                'customers.id_document_type as id_document_type',
                'document_types.name as document_type'
            )
            ->leftJoin('document_types', 'document_types.id', '=', 'customers.id_document_type')
            ->orderBy('customers.status', 'DESC')
            ->orderBy('customers.business_name', 'ASC')
            ->when($qLower, function ($builder) use ($qLower) {
                $builder->whereRaw('LOWER(customers.business_name) LIKE ?', ["%{$qLower}%"]);
            })
            ->when($dateStart, function ($builder) use ($dateStart) {
                $builder->whereDate('customers.created_at', '>=', $dateStart);
            })
            ->when($dateEnd, function ($builder) use ($dateEnd) {
                $builder->whereDate('customers.created_at', '<=', $dateEnd);
            });
        // Aplicar filtro por tipo si se indica
        if ($type === 'provider') {
            $providersCustomers = $providersQuery->paginate(10);
        } elseif ($type === 'customer') {
            $providersCustomers = $customersQuery->paginate(10);
        } else {
            $combined = $providersQuery->unionAll($customersQuery);

            $providersCustomers = DB::query()
                ->fromSub($combined, 'combined')
                ->orderBy('status', 'DESC')
                ->orderBy('business_name', 'ASC')
                ->paginate(10);
        }

        $document_types = DB::table('document_types')->orderBy('name', 'ASC')->get();

        return view('pages/providers')->with('providers', $providersCustomers)->with('document_types', $document_types);
    }

    /**
     * Exportar la lista de providers/customers a PDF respetando filtros (type, provider).
     */
    public function exportProvidersPdf(Request $request)
    {
        $q = trim((string) ($request->provider ?? ''));
        $qLower = $q !== '' ? mb_strtolower($q) : '';
        $type = $request->type ?? '';
        $dateStart = $request->date_start;
        $dateEnd = $request->date_end;

        // Providers query
        $providersQuery = DB::table('providers')
            ->select(
                'providers.id as id',
                'providers.document as document',
                'providers.email as email',
                'providers.phone as phone',
                'providers.phone_secondary as phone_secondary',
                'providers.direction as direction',
                'providers.id as retention_agent',
                'providers.business_name as business_name',
                'providers.status as status',
                DB::raw("'provider' as type"),
                'providers.id_document_type as id_document_type',
                'document_types.name as document_type'
            )
            ->leftJoin('document_types', 'document_types.id', '=', 'providers.id_document_type')
            ->orderBy('providers.status', 'DESC')
            ->orderBy('providers.business_name', 'ASC')
            ->when($qLower, function ($builder) use ($qLower) {
                $builder->whereRaw('LOWER(providers.business_name) LIKE ?', ["%{$qLower}%"]);
            })
            ->when($dateStart, function ($builder) use ($dateStart) {
                $builder->whereDate('providers.created_at', '>=', $dateStart);
            })
            ->when($dateEnd, function ($builder) use ($dateEnd) {
                $builder->whereDate('providers.created_at', '<=', $dateEnd);
            });

        // Customers query
        $customersQuery = DB::table('customers')
            ->select(
                'customers.id as id',
                'customers.document as document',
                'customers.email as email',
                'customers.phone as phone',
                'customers.phone_secondary as phone_secondary',
                'customers.id as direction',
                'customers.retention_agent as retention_agent',
                'customers.business_name as business_name',
                'customers.status as status',
                DB::raw("'customer' as type"),
                'customers.id_document_type as id_document_type',
                'document_types.name as document_type'
            )
            ->leftJoin('document_types', 'document_types.id', '=', 'customers.id_document_type')
            ->orderBy('customers.status', 'DESC')
            ->orderBy('customers.business_name', 'ASC')
            ->when($qLower, function ($builder) use ($qLower) {
                $builder->whereRaw('LOWER(customers.business_name) LIKE ?', ["%{$qLower}%"]);
            })
            ->when($dateStart, function ($builder) use ($dateStart) {
                $builder->whereDate('customers.created_at', '>=', $dateStart);
            })
            ->when($dateEnd, function ($builder) use ($dateEnd) {
                $builder->whereDate('customers.created_at', '<=', $dateEnd);
            });

        if ($type === 'provider') {
            $rows = $providersQuery->get();
        } elseif ($type === 'customer') {
            $rows = $customersQuery->get();
        } else {
            $combined = $providersQuery->unionAll($customersQuery);
            $rows = DB::query()->fromSub($combined, 'combined')
                ->orderBy('status', 'DESC')
                ->orderBy('business_name', 'ASC')
                ->get();
        }

        $viewData = [
            'rows' => $rows,
            'filters' => [
                'type' => $type,
                'provider' => $q,
                'date_start' => $dateStart,
                'date_end' => $dateEnd,
            ],
        ];

        $pdf = Pdf::loadView('reports.providers_list_pdf', $viewData)->setPaper('a4', 'portrait');
        $filename = 'providers_customers_' . date('Ymd_His') . '.pdf';
        return $pdf->download($filename);
    }
}
