<?php

    namespace App\Http\Controllers;

    use Illuminate\View\View;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Http\Response;
    use Illuminate\Http\RedirectResponse;
    use App\Models\UploadedFile;
    use App\Models\ChecklistRequirement;
    use App\Models\Requirement;


     class FacultyController extends Controller
     {
         /* public function dashboard(): View
         {
            // Check if the user is an admin
            if (Auth::user()->user_type === 'Admin') {
                return redirect()->route('admin.dashboard'); // Redirect to admin dashboard
            }
    
            return view('dashboard'); // Return the normal user dashboard
        } */

        public function dashboard() // Remove the return type hint
        {
            // Check if the user is an admin
            if (Auth::check() && Auth::user()->user_type === 'Admin') {
                return redirect()->route('admin.dashboard'); // Redirect to admin dashboard
            }
    
            return view('dashboard'); // Return the normal user dashboard
        }

         public function myFiles(): View
         {
             return view('faculty.partials.my-files'); // Return the faculty dashboard view
         }

         public function sharedFiles(): View
         {
             return view('faculty.partials.shared-files'); // Return the faculty dashboard view
         }

         public function clearances(): View
         {
             return view('faculty.partials.clearances'); // Return the faculty dashboard view
         }

         public function uploadFile(Request $request, $requirementId)
         {
             $request->validate([
                 'file' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048',
             ]);
     
             $filePath = $request->file('file')->store('uploads', 'public');
     
             UploadedFile::create([
                 'requirement_id' => $requirementId,
                 'file_path' => $filePath,
             ]);
     
             return redirect()->back()->with('success', 'File uploaded successfully.');
         }

          /**
         * Show the clearance page for the faculty.
         */
        public function showClearancePage()
        {
            // Retrieve the checklist requirements
            $checklistRequirements = ChecklistRequirement::all(); // Adjust this query as needed
    
            // Pass the checklist requirements to the view using the with method
            return view('faculty.partials.clearances')->with('checklistRequirements', $checklistRequirements);
        }

         public function submittedReports(): View
         {
             return view('faculty.partials.submitted-reports'); // Return the faculty dashboard view
         }
         
         public function archive(): View
         {
             return view('faculty.partials.archive'); // Return the faculty dashboard view
         }

         /////////////////////////////// Testing ///////////////////////////////    
         public function showTestPage()
         {
            // Retrieve the checklist requirements
            $checklistRequirements = ChecklistRequirement::all(); // Adjust this query as needed
    
            // Pass the checklist requirements to the view using the with method
            return view('faculty.test')->with('checklistRequirements', $checklistRequirements);
        }    
     }