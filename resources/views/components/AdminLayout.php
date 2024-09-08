<?php

   namespace App\View\Components;

   use Illuminate\View\Component;
   

   class AdminLayout extends Component
   {
       public function render()
       {
           return view('layouts.admin'); // Ensure this points to the correct layout file
       }
   }