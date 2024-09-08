<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Clearance;
use App\Models\Requirement;
use App\Models\ChecklistRequirement;



class AdminController extends Controller
{   
     /**
     * Display the admin dashboard.
     */
    public function dashboard(): View
    {
        // Check if the user is not an admin
        if (Auth::user()->user_type !== 'Admin') {
            return redirect()->route('dashboard'); // Redirect to normal user dashboard
        }
        // Get the total numbers of all Users (Admin, Faculty)
        $totalUsers = \App\Models\User::count(); // with this it counts all users in the system

        return view('admindashboard', compact('totalUsers')); // Return the admin dashboard view
    }
    /**
     * Display the clearances page.
     */
    public function clearances(Request $request): View
    {
        // Fetch users with their clearance status
        $users = User::with('clearance') // Assuming you have a relationship defined
            ->get();

        $query = Clearance::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Sorting functionality
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            $query->join('users', 'clearances.user_id', '=', 'users.id')
                  ->orderBy('users.name', $sort);
        }

        $clearances = $query->select('clearances.*')->get();

        return view('admin.clearances', compact('clearances', "users"));
    }
      /**
     * Display the Submitted Reports.
     */
    public function submittedReports(): View
    {
        return view('admin.submitted-reports');
    }

    /**
     * Display the IT faculty page.
     */
    public function Faculty(): View
    {
        $users = \App\Models\User::all(); // Fetch all users
        return view('admin.faculty', compact('users')); // Pass users to the view
    }

    /**
     * Display the shared files page.
     */
    public function sharedFiles(): View
    {
        return view('admin.sharedfiles');
    }

    public  function myFiles(): View
    {
        return view('admin.my-files');
    }

    // You can keep the existing editProfile method if you have it
    public function editProfile(): View
    {
        return view('admin.profile.edit');
    }


///////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////// Inside Contents ///////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////

    public function updateUser(Request $request)
    {
        //dd($request->all()); // Debugging line
        Log::info($request->all()); // Log all request data

        $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'program' => 'required|string|max:255',
            'units' => 'required|integer',
            'status' => 'required|string|in:Permanent,Part-Timer,Temporary',
        ]);
    
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->program = $request->program;
        $user->units = $request->units;
        $user->status = $request->status;
        $user->save();
    
        return redirect()->route('admin.faculty')->with('success', 'User updated successfully.');
    }

    // Faculty Content and Controls
    public function manageFaculty(Request $request)
    {
        $query = User::query();
    
        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('units', 'like', "%{$search}%")
                  ->orWhere('program', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
        }
    
        // Sorting functionality
        // Sorting functionality
        $sort = $request->input('sort', 'asc'); // Default sort direction
        $query->orderBy('id', $sort); // Default sort by ID

        $users = $query->get();

        return view('admin.faculty', compact('users'));
    }

    
    
    
    
    ///////////////////////////////////////////////  Clearance Content and Controls  //////////////////////////////////////////////////////////Clearance Content and Controls
    public function updateClearance(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:clearances,id',
            'status' => 'required|string|in:Pending,Approved,Rejected',
            'checked_by' => 'required|string|max:255',
        ]);

        $clearance = Clearance::find($request->id);
        $clearance->status = $request->status;
        $clearance->checked_by = $request->checked_by;
        $clearance->save();

        return redirect()->route('admin.clearances')->with('success', 'Clearance updated successfully.');
    }

    public function clearanceManagement(Request $request): View
    {
        // Retrieve the list of clearance checklists
        $clearanceChecklists = DB::table('clearance_checklists')->get();
    
        // Pass the clearance checklists to the view
        return view('admin.clearance-management', compact('clearanceChecklists'));
    }
      /**
     * Send checklist to faculty.
     */
    public function sendChecklist(Request $request)
    {
        $status = $request->input('status');
        $facultyMembers = User::where('position', $status)->get();

        foreach ($facultyMembers as $faculty) {
            // Logic to send the checklist to the faculty member
        }

        return redirect()->route('admin.clearance-management')->with('message', 'Checklist sent successfully.');
    }



    /////////////////////////////////   CHECKLIST CONTROLS   ////////////////////////////////////////////////////////

    public function addClearanceChecklist(Request $request)
    {
        Log::info('Request Data: ', $request->all());
 
        $request->validate([
            'type' => 'required|string',
            'document_name' => 'required|string',
            'units' => 'required|integer',
        ]);
        // Check for existing document name
        $existingChecklist = DB::table('clearance_checklists')
            ->where('document_name', $request->input('document_name'))
            ->first();

            if ($existingChecklist) {
                return redirect()->route('admin.clearance-management')->with('error', 'A checklist with this document name already exists.');
            }   
 
        $tableName = str_replace(' ', '_', strtolower($request->input('document_name')));
 
        // Create a new table for the clearance checklist
        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->string('requirement_name');
            $table->timestamps();
        });
 
        // Insert the new clearance checklist into the clearance_checklists table
        DB::table('clearance_checklists')->insert([            
            'document_name' => $request->input('document_name'),
            'name' => $request->input('name'),
            'units' => $request->input('units'),
            'type' => $request->input('type'),
            'table_name' => $tableName,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
 
        return redirect()->route('admin.clearance-management')->with('message', 'Checklist added successfully.');
    }

    public function editClearanceChecklist($table)
    {
        $requirements = DB::table($table)->get();
        return view('admin.partials.edit-clearance-checklist', compact('requirements', 'table'));
    }

    public function updateClearanceChecklist(Request $request, $table)
    {
        $request->validate([
            'requirement_name' => 'required|array',
            'requirement_name.*' => 'required|string',
        ]);

        DB::table($table)->truncate();

        foreach ($request->input('requirement_name') as $requirementName) {
            DB::table($table)->insert([
                'requirement_name' => $requirementName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.clearance-management')->with('message', 'Clearance checklist updated successfully.');
    }

    public function deleteClearanceChecklist($table)
    {
        // Drop the table for the clearance checklist
        Schema::dropIfExists($table);

        // Delete the clearance checklist from the clearance_checklists table
        DB::table('clearance_checklists')->where('table_name', $table)->delete();

        return redirect()->route('admin.clearance-management')->with('message', 'Clearance checklist deleted successfully.');
    }

    /**
     * Remove an existing clearance checklist.
     */
    public function removeClearanceChecklist(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:requirements,id',
        ]);

        Requirement::destroy($request->input('id'));

        return redirect()->route('admin.clearance-management')->with('success', 'Clearance checklist removed successfully.');
    }

    /**
     * Get the checklist requirements for a specific clearance.
     */
    public function getClearanceChecklist($id)
    {
        $requirements = ChecklistRequirement::where('requirement_id', $id)->get();
        return response()->json(['requirements' => $requirements]);
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

}