<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Payment;
use App\Models\Student;

class PaymentController extends Controller
{
    //
    public function addPayment(Request $request)
    {
        //call the getStudent function and subtract the amount to the balance
        $student = Student::findOrFail($request->student_id);

        if ($student->balance >= $request->amount) {
            Payment::create($request->all());
            $student->balance -= $request->amount;
            $student->save();

            return response()->json([
                'message' => 'Payment added',
                'payment' => $request->all(),
            ]);
        } else {
            return response()->json([
                'statusCode' => 400,
                'status' => 'failed',
                'message' => 'Already paid the remaining balance',
            ]);
        }
    }

    public function getTotalPayment(int $college_id)
    {
        $all_payment = Payment::join(
            'students',
            'students.student_id',
            '=',
            'payments.student_id'
        )
            ->join(
                'programs',
                'programs.program_id',
                '=',
                'students.program_id'
            )
            ->join(
                'colleges',
                'colleges.college_id',
                '=',
                'programs.college_id'
            )
            ->where('colleges.college_id', $college_id)
            ->sum('amount');

        return response()->json([
            'total_payment' => $all_payment,
        ]);
    }

    public function getPaymentByStudentId(Request $request)
    {
        $payment = Payment::findOrFail('student_id', $request->student_id);

        return response()->json([
            'message' => 'Student record retrieved',
            'payment' => $payment,
        ]);
    }

    public function getAllPayment()
    {
        return response()->json([
            'message' => 'All payments retrieved',
            'payments' => Payment::with([
                'semester',
                'student',
                'collector',
                'program',
            ])->get(),
        ]);
    }

    public function filterStudent(Request $request)
    {
        $student = Student::where(
            $request->parameters,
            $request->input_value
        )->first();

        return response()->json([
            'message' => 'Student record retrieved',
            'student' => $student,
        ]);
    }
}
