<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Notifications\GlobalNotification;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard method
    public function dashboard()
    {
        // Fetching data to pass to the view
        $products = Product::all();  // Fetching all products
        $users = User::all();        // Fetching all users

        // Passing variables to the view
        return view('admin.dashboard', compact('products', 'users', 'registrations'));
    }

    // Reports method
    public function reports()
    {
        // Fetching user reports with related activities (if any)
        $userReports = User::with('activities')->get();



        // Passing the reports to the view
        return view('admin.reports', compact('userReports'));
    }

     public function notifyAllUsers(Request $request)
    {
        $message = $request->input('message');

        foreach (User::all() as $user) {
            $user->notify(new GlobalNotification($message));
        }

        return back()->with('success', 'Notification sent!');
    }
}
