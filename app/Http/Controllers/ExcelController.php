<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employee;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Validator;

class ExcelController extends Controller {

public function download_with_data() {
    $employees = Employee::all();
    $spreadsheet = new Spreadsheet();

    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Full Name');
    $sheet->setCellValue('B1', 'E-Mail');
    $sheet->setCellValue('C1', 'Phone #');

    $row = 2;
    foreach ($employees as $employee) {
        $sheet->setCellValue('A' . $row, $employee->fullname);
        $sheet->setCellValue('B' . $row, $employee->email);
        $sheet->setCellValue('C' . $row, $employee->phone);

        $row++;
    }

    $writer = new Xlsx($spreadsheet);
    $filePath = storage_path('excel.xlsx');
    $writer->save($filePath);

    return response()->download($filePath, 'excel.xlsx')->deleteFileAfterSend(true);
}

    public function download_without_data() {
        $employees = Employee::all();
        $spreadsheet = new Spreadsheet();
    
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Full Name');
        $sheet->setCellValue('B1', 'E-Mail');
        $sheet->setCellValue('C1', 'Phone #');
    
        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('excel.xlsx');
        $writer->save($filePath);

        return response()->download($filePath, 'excel.xlsx')->deleteFileAfterSend(true);
    }


    public function upload_data(Request $request)
    {
        $request->validate([
            'myfile' => 'required|mimes:xlsx',
        ]);
    
        $validator = Validator::make($request->all(), [
            'myfile' => 'required|mimes:xlsx',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
    
        $uploadedFile = $request->file('myfile');
        $spreadsheet = $reader->load($uploadedFile->getRealPath());
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
    
        foreach ($sheetData as $row) {
            if ($row['A'] == 'Full Name' && $row['B'] == 'E-Mail' && $row['C'] == 'Phone #') {
                continue;
            }
            $validator = Validator::make($row, [
                'A' => [
                    'required',
                    'string',
                    'regex:/^[a-zA-Z\s]+$/',
                    'max:255',
                ],
                'B' => 'required|email',
                'C' => 'required|numeric|digits:11',
            ], [
                'A.required' => 'Full Name is required',
                'A.regex' => 'Full Name can only contain alphabets',
                'B.required' => 'E-Mail is required',
                'B.email' => 'Invalid E-Mail format',
                'C.required' => 'Phone # is required',
                'C.numeric' => 'Phone # must be numeric',
                'C.digits' => 'Phone # must be 11 digits',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            if ($row['A'] == 'Full Name' && $row['B'] == 'E-Mail' && $row['C'] == 'Phone #') {
                continue;
            }
    
            $existingRecord = Employee::where('email', $row['B'])->first();
            Employee::updateOrCreate(
                ['email' => $row['B']],
                [
                    'fullname' => $row['A'],
                    'phone' => $row['C'],
                ]
            );
        }
    
        return redirect(route('employee.index'))->with('success', 'Data uploaded successfully!');
    }    
}
