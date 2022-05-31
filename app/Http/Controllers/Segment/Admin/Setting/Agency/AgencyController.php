<?php

namespace App\Http\Controllers\Segment\Admin\Setting\Agency;

use App\Http\Controllers\Controller;
use App\Models\Profiles\ProfilesCawanganLog;
use Illuminate\Http\Request;
use App\Models\Regular\AgencyHierarchy;
use App\Models\Regular\AgencyPenyelaras;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AgencyController extends Controller
{
    //
    public function index(Request $request) {
        $agencies = $this->load_hierarchy_lookup();
        return view('segment.admin.setting.agency.index', [
            'agencies' => $agencies
        ]);
    }

    private function load_hierarchy_lookup($arr = array(),$indent = "",$parent = NULL) {

        $query = AgencyHierarchy::where('delete_id', 0);
        if(empty($parent)) {
            $result = $query->whereNull('parent_id')->get();
        } else {
            $result = $query->where('parent_id',$parent)->get();
        }

        if(!empty($result)) {
            foreach($result as $item) {
                if($item->flag == 1) {
                    $arr[] = array(
                        'id' => $item->id,
                        'name' => $indent.' '.$item->name
                    );

                    $arr = $this->load_hierarchy_lookup($arr,$indent.'-',$item->id);
                }
            }
        }

        return $arr;
    }

    public function load_agencies_lookup(Request $request) {
        $data = $this->load_hierarchy_lookup();
        return response()->json([
            'success' => 1,
            'data' => $data
        ]);
    }

    public function load_agencies_tree() {
        $parents = AgencyHierarchy::whereNull('parent_id')->where('delete_id', 0)->get();
        $results = array();
        foreach($parents as $a) {
            $data = array(
                'id'=>$a->id,
                'name'=>$a->name,
                'flag'=>$a->flag
            );
            // check have children and put into $data
            $children = $this->retrive_agency_children($a->id);
            if(!empty($children)) {
                $data['children'] = $children;
            }
            $results[] = $data;
        }

        return response()->json(['data' => $results]);
    }

    private function retrive_agency_children($parentId) {
        $children = AgencyHierarchy::where('parent_id',$parentId)->where('delete_id', 0)->get();
        $culumative = array();

        if(!empty($children)) {
            foreach($children as $child) {
                $data = array(
                    'id'=>$child->id,
                    'name'=>$child->name,
                    'flag'=>$child->flag
                );
                $underlings = $this->retrive_agency_children($child->id);
                if(!empty($underlings)) {
                    $data['children'] = $underlings;
                }
                $culumative[] = $data;
            }
        }

        return $culumative;
    }

    public function save_agency(Request $request) {
        $model = new AgencyHierarchy;
        $process = $model->createAndUpdate($request);
        return response()->json($process);
    }

    public function active_agency(Request $request) {
        $model = new AgencyHierarchy;
        $result = $model->rekodActivate($request->input('agency_id'));
        return response()->json($result);
    }

    public function delete_agency(Request $request) {
        $agency_id = $request->input('agency_id');
        $model = AgencyHierarchy::find($agency_id);
        $model->delete_id = 1;
        if($model->save()){
            return response()->json([
                'success' => 1
            ]);
        }
    }

    public function get_agency(Request $request) {
        $process = AgencyHierarchy::getRecord($request->input('agency_id'));

        $data = [];
        if($process){
            $data = [
                'success' => 1,
                'data' => [
                    'name' => $process->name,
                    'waran_code' => $process->waran_code,
                    'parent_id' => $process->parent_id
                ]
            ];
        }
        return response()->json($data);
    }

    public function list_penyelaras($agencyId) {
        $users = AgencyPenyelaras::where('agency_id',$agencyId)->pluck('user_id')->all();

        $model = DB::table('profiles as profile')
            ->select('profile.id as p_id','users.id as u_id','users.name as u_name','users.email as u_email')
            ->join('users', 'profile.users_id', '=', 'users.id')
            ->where('profile.delete_id',0)
            ->where('profile.flag',1)
            ->whereIn('users.id',$users);

        return DataTables::of($model)
            ->setRowAttr([
                'data-profile-id' => function($data) {
                    return $data->p_id;
                },
                'data-user-id' => function($data) {
                    return $data->u_id;
                },
            ])
            ->addColumn('nama', function($data){
                return strtoupper($data->u_name);
            })
            ->addColumn('email', function($data){
                return strtoupper($data->u_email);
            })
            ->addColumn('penempatan', function($data){
                return ProfilesCawanganLog::where('profiles_id', $data->p_id)->orderBy('id', 'desc')->limit(1)->first()->penempatan_name;
            })
            ->rawColumns(['active', 'action'])
            ->make(true);
    }
}
