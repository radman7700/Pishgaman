<?php

namespace Pishgaman\Pishgaman\Http\Controllers\Api;

use Illuminate\Http\Request;
use Pishgaman\Pishgaman\Middleware\CheckMenuAccess;
use Pishgaman\Pishgaman\Repositories\LogRepository;
use Pishgaman\Pishgaman\Database\Models\Department\Department;
use Pishgaman\Pishgaman\Database\Models\Department\DepartmentUser;
use Pishgaman\Pishgaman\Database\Models\User\User;
use Validator;

class departmentsController extends Controller
{
    private $validActions = [
        'getDeps',
        'deleteDep',
        'editDep',
        'saveNewDep',
        'getEmployeeDeps',
        'saveNewEmployeeDep',
        'deleteEmployeeDep',
        'setAdminDep'
    ];
    
    protected $validMethods = [
        'GET' => ['getDeps','getEmployeeDeps'], 
        'POST' => ['saveNewDep','saveNewEmployeeDep'],
        'PUT' => ['editDep','setAdminDep'],
        'DELETE' => ['deleteDep','deleteEmployeeDep']
    ];
    
    protected $user;
    protected $logRepository;
    
    public function __construct(logRepository $logRepository)
    {
        $this->logRepository = $logRepository;
        $this->middleware(CheckMenuAccess::class);
        $this->user = auth()->user();
    }
    
    public function action(Request $request)
    {
        if ($request->has('action')) {
            $functionName = $request->action;
            $method = $request->method();
            if ($this->isValidAction($functionName, $method)) {
                return $this->$functionName($request);
            } else {
                return response()->json(['errors' => 'requestNotAllowed'], 422);
            }
        }

        return abort(404);
    }
    
    private function isValidAction($functionName, $method)
    {
        $method = strtoupper($method);
        return in_array($functionName, $this->validActions) && in_array($functionName, $this->validMethods[$method]);
    }
    
    public function getDeps(Request $request)
    {
        if (!$this->isValidAction('getDeps', 'GET')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }

        $deps = Department::get();

        return response()->json(['deps'=>$deps], 200);   
    
    }    

    public function saveNewDep(Request $request)
    {
        if (!$this->isValidAction('saveNewDep', 'POST')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }
    
        // Validate and sanitize the input data if needed.
        $validator = Validator::make($request->all(), [
            'pid' => 'required',
            'dep_name' => 'required'
        ]);
    
        $Department = new Department;
        $Department->pid = $request->pid;
        $Department->name = $request->dep_name;
        $Department->save();

        return response()->json('Success text', 200);   
    } 
    
    public function deleteDep(Request $request)
    {
        if (!$this->isValidAction('deleteDep', 'DELETE')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }

        $validator = Validator::make($request->all(), [
            'dep_id' => 'required',
        ]);

        Department::where('id',$request->dep_id)->delete();

        return response()->json('Success', 200);   
    } 
    
    
    public function editDep(Request $request)
    {
        if (!$this->isValidAction('editDep', 'PUT')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }
    
        $validator = Validator::make($request->all(), [
            'pid' => 'required',
            'dep_name' => 'required'
        ]);

        Department::where('id',$request->dep_id)->update(['name'=>$request->dep_name]);

        return response()->json('Success', 200);   
    }     

    public function getEmployeeDeps(Request $request)
    {
        if (!$this->isValidAction('getEmployeeDeps', 'get')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }
    
        // Validate and sanitize the input data if needed.
        $validator = Validator::make($request->all(), [
            'dep_id' => 'required',
        ]);
    
        $DepartmentUser = DepartmentUser::where('department_id',$request->dep_id)->with(['user:id,username,name,last_name'])->get();

        return response()->json(['DepartmentUser'=>$DepartmentUser], 200);     
    }     

    public function saveNewEmployeeDep(Request $request)
    {
        if (!$this->isValidAction('saveNewEmployeeDep', 'post')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }
    
        $validator = Validator::make($request->all(), [
            'dep_id' => 'required',
            'employee_username' => 'required' // Corrected field name
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }
    
        $user = User::where('username', $request->employee_username)->first(); // Corrected variable name
    
        if($user)
        {
            if(DepartmentUser::where('user_id',$user->id)->count() > 0)
            {
                return response()->json(['errors' => 'کاربر قبلا به عنوان کارمند این دپارتمان اضافه شده است'], 422);   
            }
            
            $departmentUser = new DepartmentUser; // Corrected variable name
            $departmentUser->department_id = $request->dep_id;
            $departmentUser->user_id = $user->id;
            $departmentUser->save();
    
            return response()->json('Success', 200);
        }
    
        return response()->json(['errors' => 'کاربر یافت نشد'], 422); // Return error if user not found
    }

    public function deleteEmployeeDep(Request $request)
    {
        if (!$this->isValidAction('deleteEmployeeDep', 'DELETE')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }

        $validator = Validator::make($request->all(), [
            'dep_user_id' => 'required',
        ]);

        DepartmentUser::where('id',$request->dep_user_id)->delete();

        return response()->json('Success', 200);   
    } 

    public function setAdminDep(Request $request)
    {
        if (!$this->isValidAction('setAdminDep', 'PUT')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        $DepartmentUser = DepartmentUser::where('id',$request->id)->first();
        DepartmentUser::where('department_id',$DepartmentUser->department_id)->update(['job_position'=>null]);
        DepartmentUser::where('id',$request->id)->update(['job_position'=>'admin']);

        return response()->json('Success', 200);   
    }
}