<?php

namespace App\Http\Controllers;
use App\Http\Controllers\ProvideController;
use App\Models\Provide;
use Illuminate\Http\Request;
use DataTables;

class ProvideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $providers = Provide::latest()->paginate(10);
        $providers = Provide::all();
        return response($providers, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate
        $request->validate([
            'name' => 'required',
            'url' => 'required',
        ]);
        // Insert Record
        $provider = Provide::create($request->all());   
        // return response('New Record Saved Successfully.', 200);
        return response()->json([
            'message' => 'Record Saved Successfully',
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Provide  $provide
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 
        $provide = Provide::findOrFail($id);
        return response()->json([
            'message' => $provide,
            'status' => 'success'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Provide  $provide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate
        $request->validate([
            'name' => 'required',
            'url' => 'required',
        ]);

        // Update Record
        $provide = Provide::findOrFail($id)
        ->update($request->all());
        // 
        return response()->json([
            'message' => 'Record Updated Successfully.',
            'status' =>  'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Provide  $provide
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete
        $provide = Provide::findOrFail($id)->delete();
        // 
        return response()->json([
            'message' => 'Record Deleted Successfully.',
            'status' =>  'success'
        ]);
    }

    // 
    public function getProviders(Request $request) {
        //
        if ($request->ajax()) 
        { 
            $data = Provide::all();

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                //
                $actionBtn = "<div class='btn-group' aria-label='First group'>";
                $actionBtn.= "<button value='" . $row->id ."' class='btn btn-primary btn-sm mr-1 edit_provider'><i class='fas fa-edit'></i> Edit </button>" ;
                $actionBtn.= "<button value='" . $row->id ."' class='btn btn-danger btn-sm mr-1 delete_provider'><i class='fas fa-trash-alt'></i> Delete </button>" ;
                $actionBtn.= "<button value='" . $row->url ."' class='btn btn-info btn-sm mr-1 view_image'><i class='fas fa-image'></i> View Image </button>" ;
                $actionBtn.= "</div>";
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }
    
}
