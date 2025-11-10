<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Providers\App\Events\informationHasBeenRemoved;
use App\Http\Requests\CustomersRequest;

class CustomersController extends Controller
{
    public function index()
    {
        return redirect('providers');
    }

    public function store(CustomersRequest $request)
    {
      DB::beginTransaction();
      try {

          DB::table('customers')->insert([
              'id_document_type' => $request->type_document,
              'document' => $request->document,
              'business_name' => $request->business_name,
              'email' => $request->email,
              'phone' => $request->phone,
              'phone_secondary' => $request->phone_secondary,
              'retention_agent' => $request->retention_agent ?? 0,
          ]);

          DB::commit();
          return redirect()->back()->with('success', "Cliente agregado");
      } catch (\Throwable $th) {
          DB::rollback();
          return back()->withErrors(['error' => $th->getMessage()]);
      }
    }

    public function update(CustomersRequest $request, $id)
    {
      DB::beginTransaction();
      try {

          DB::table('customers')->where('id',$id)->update([
              'id_document_type' => $request->type_document,
              'document' => $request->document,
              'business_name' => $request->business_name,
              'email' => $request->email,
              'phone' => $request->phone,
              'phone_secondary' => $request->phone_secondary,
              'retention_agent' => $request->retention_agent ?? 0,
          ]);

          DB::commit();
          return redirect()->back()->with('success', "Cliente editado");
      } catch (\Throwable $th) {
          DB::rollback();
          return back()->withErrors(['error' => $th->getMessage()]);
      }
    }

    public function destroy($id)
    {
      DB::beginTransaction();
      try {
          event(new informationHasBeenRemoved($id, 'customers', $this->queryOperationsCustomer($id)));
          DB::commit();
          return redirect()->back()->with('success', "Cliente eliminado");
      } catch (\Throwable $th) {
          DB::rollback();
          return back()->withErrors(['error' => $th->getMessage()]);
      }
    }

    private function queryOperationsCustomer($idCustomer){
        return DB::table('sales_invoices')->where('id_customer', $idCustomer)->exists();
    }

    public function searchCustomer(Request $request){
        $customers = DB::table('customers')
        ->leftJoin('document_types', 'document_types.id', '=', 'customers.id_document_type')
        ->orderBy('customers.status', 'DESC')
        ->orderBy('customers.business_name', 'ASC')
        ->where('customers.business_name', 'like', "%$request->customer%")
        ->select('customers.*', 'document_types.name as document_type', 'document_types.id as id_document_type')
        ->paginate(10);

        $document_types = DB::table('document_types')->orderBy('name', 'ASC')->get();

        return view('pages/customers')->with('customers', $customers)->with('document_types', $document_types);
    }
}
