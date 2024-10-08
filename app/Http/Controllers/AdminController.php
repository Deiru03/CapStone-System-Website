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

        // Get the count of pending and signed clearances
        $pendingClearances = \App\Models\User::where('clearance_status', 'Pending')->count();
        $signedClearances = \App\Models\User::where('clearance_status', 'Signed')->count();
        $totalClearances = $pendingClearances + $signedClearances;

        // Get the count of faculty by position
        $permanentFacultyCount = \App\Models\User::where('position', 'Permanent')->count();
        $partTimeFacultyCount = \App\Models\User::where('position', 'Part-Timer')->count();
        $temporaryFacultyCount = \App\Models\User::where('position', 'Temporary')->count();

        return view('admindashboard', compact('totalUsers', 'pendingClearances', 'signedClearances', 'totalClearances', 'permanentFacultyCount', 'partTimeFacultyCount', 'temporaryFacultyCount')); // Return the admin dashboard view
    }
    /**
     * Display the clearances page.
     */
    public function clearances(Request $request): View
    {
        $users = User::with('clearance') // Assuming you have a relationship defined
            ->get();
        $users = User::select('id', 'name', 'email', 'program', 'units', 'position', 'clearance_status', 'last_update', 'checked_by')->get();
        {
            $query1 = User::query();
        
            if ($request->has('search')) {
                $search = $request->input('search');
                $query1->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('program', 'like', "%{$search}%")
                        ->orWhere('position', 'like', "%{$search}%")
                        ->orWhere('clearance_status', 'like', "%{$search}%")
                        ->orWhere('id', 'like', "%{$search}%");
            }
        
            if ($request->has('sort')) {
                $sort = $request->input('sort');
                $query1->orderBy('id', $sort);
            }
        
            $users = $query1->get(); // Fetch users based on the query
        
            return view('admin.clearances', compact('users')); // Pass only the $users variable
        }
    }

        ////////////////////// OLD ClEARANCE //////////////////////
    /*{
        // Fetch users with their clearance status
        $users = User::with('clearance') // Assuming you have a relationship defined
            ->get();
        $User = User::select('id', 'name', 'email', 'program', 'units', 'position', 'clearance_status', 'last_update')->get();

        //$query = Clearance::query();
        $query1 = User::query();

        // Search functionality
        /*if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('program', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
            $query1->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('program', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
        }*/

        // Sorting functionality
        /*if ($request->has('sort')) {
            $sort = $request->input('sort');
            $query->join('users', 'clearances.user_id', '=', 'users.id')
                  ->orderBy('users.name', $sort);
        }*
        if ($request->has('search')) {
            $search = $request->input('search');
            $query1->where('name', 'like', "%{$search}%")
                   ->orWhere('email', 'like', "%{$search}%")
                   ->orWhere('program', 'like', "%{$search}%")
                   ->orWhere('position', 'like', "%{$search}%")
                   ->orWhere('clearance_status', 'like', "%{$search}%")
                   ->orWhere('id', 'like', "%{$search}%");
        }
        if ($request->has('sort')) {
            $sort = $request->has('sort');
            $query1 ->join('users', 'users.id', '=', 'clearances.user_id')
                    ->orderBy('users.id', $sort);
        }

        //$clearances = $query->select('clearances.*')->get();
        $users = $query1->select('users.*')->get();
        return view('admin.clearances', compact('users', "users", "User"));
    } */
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

    public function updateFacultyClearanceUser(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'clearance_status' => 'required|string',
            'checked_by' => 'nullable|string', // Optional if you want to track who checked it
        ]);

        $user = User::findOrFail($request->id);
        $user->clearance_status = $request->clearance_status; // Update clearance_status
        $user->checked_by = $request->checked_by; // Update checked_by if provided
        $user->last_update = now(); // Update last_update to current timestamp
        $user->save();

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'clearance_status' => $user->clearance_status,
                'checked_by' => $user->checked_by,
                'last_update' => $user->last_update->format('M d, Y H:i'),
            ]
        ]);
    }

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
            'position' => 'required|string|in:Permanent,Part-Timer,Temporary',
        ]);
    
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->program = $request->program;
        $user->units = $request->units;
        $user->position = $request->position;
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
                  ->orWhere('position', 'like', "%{$search}%");
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
            'id' => 'required|exists:users,id',
            'clearance_status' => 'required|string',
            'checked_by' => 'nullable|string', // Optional if you want to track who checked it
        ]);
    
        $user = User::findOrFail($request->id);
        $user->clearance_status = $request->clearance_status; // Update clearance_status
        $user->checked_by = $request->checked_by; // Update checked_by if provided
        $user->last_update = now(); // Update last_update to current timestamp
        $user->save();
    
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'clearance_status' => $user->clearance_status,
                'checked_by' => $user->checked_by,
                'last_update' => $user->last_update,
                'updated_at' => $user->updated_at->format('M d, Y H:i'),
            ]
        ]);
    }

    public function clearanceManagement(Request $request): View
    {
        // Retrieve the list of clearance checklists
        $clearanceChecklists = DB::table('clearance_checklists')->get();
    
        // Fetch the checklist if needed (adjust based on your logic)
        $checklist = ChecklistRequirement::first(); // or however you want to fetch it
    
        // Pass the clearance checklists and checklist to the view
        return view('admin.clearance-management', compact('clearanceChecklists', 'checklist'));
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
            $faculty->clearance_status = 'Sent'; // Update status
            $faculty->last_updated = now(); // Update timestamp
            $faculty->save(); // Save changes
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
            'units' => 'nullable|integer',
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

    public function viewClearanceChecklist($table)
    {
        $checklist = DB::table('clearance_checklists')->where('table_name', $table)->first();
        $requirements = DB::table($table)->get();
        return view('admin.partials.view-clearance-checklist', compact('checklist', 'requirements', 'table'));
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

        // Update the updated_at field in the clearance_checklists table
        DB::table('clearance_checklists')->where('table_name', $table)->update([
            'updated_at' => now(),
        ]);

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

    public function sendClearanceChecklist(Request $request, $table)
    {
        // Validate the request
        $request->validate([
            'table_name' => 'required|string',
        ]);

        // Fetch the checklist data based on the table name
        $checklist = ChecklistRequirement::table('clearance_checklists')->where('table_name', $table)->first(); // Adjust this line based on your model

        if (!$checklist) {
            return response()->json(['message' => 'Checklist not found.'], 404);
        }

        // Fetch all faculty members
        $facultyMembers = User::where('role', 'faculty')->get(); // Adjust the role as per your setup

        // Send the checklist to each faculty member
        foreach ($facultyMembers as $faculty) {
            // Implement your sending logic here (e.g., email, notification, etc.)
            // Example: Mail::to($faculty->email)->send(new ChecklistSent($checklist));
        }

        return response()->json(['message' => 'Checklist sent successfully!']);
    }
}