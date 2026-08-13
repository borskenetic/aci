<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceFeedback;

class FeedController extends Controller
{
   
    public function store(Request $request)
    {
        AttendanceFeedback::create([
            'student_id' => $request->student_id,
            'rating' => $request->rating,
            'declined' => $request->declined ?? 0
        ]);
    
        return response()->json(['success' => true]);
    }
    
    public function index(Request $request)
    {
        $query = AttendanceFeedback::with('student')->latest();
    
        // 🔥 FILTERING LOGIC
        if ($request->rating) {
    
            if ($request->rating === 'declined') {
                $query->where('declined', 1);
            } else {
                $query->where('rating', $request->rating)
                      ->where('declined', 0);
            }
        }
    
        $feedbacks = $query->get();
    
        // Breakdown counts (ALWAYS full dataset)
        $all = AttendanceFeedback::all();
    
        $total     = $all->count();
        $excellent = $all->where('rating', 'excellent')->count();
        $good      = $all->where('rating', 'good')->count();
        $medium    = $all->where('rating', 'medium')->count();
        $poor      = $all->where('rating', 'poor')->count();
        $veryBad   = $all->where('rating', 'very_bad')->count();
        $declined  = $all->where('declined', 1)->count();
    
        return view('admin.feedbacks', compact(
            'feedbacks',
            'total',
            'excellent',
            'good',
            'medium',
            'poor',
            'veryBad',
            'declined'
        ));
    }
}