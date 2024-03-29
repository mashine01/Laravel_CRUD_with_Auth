<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employee;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ExcelController extends Controller {

    public function download(Request $request) {
        $downloadType = $request->input('downloadType');
    
        if ($downloadType === 'withData') {
            return $this->download_with_data();
        } elseif ($downloadType === 'withoutData') {
            return $this->download_without_data();
        } else {
            return response()->json(['error' => 'Invalid request']);
        }
    }    

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
    $filePath = storage_path('emp_with_data.xlsx');
    $writer->save($filePath);

    return response()->download($filePath, 'emp_with_data.xlsx')->deleteFileAfterSend(true);
}

    public function download_without_data() {
        $employees = Employee::all();
        $spreadsheet = new Spreadsheet();
    
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Full Name');
        $sheet->setCellValue('B1', 'E-Mail');
        $sheet->setCellValue('C1', 'Phone #');
    
        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('emp_without_data.xlsx');
        $writer->save($filePath);

        return response()->download($filePath, 'emp_without_data.xlsx')->deleteFileAfterSend(true);
    }

    public function upload_data(Request $request)
    {
    
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
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, false, true, true);
    
        $errors = [];

        foreach ($sheetData as $row) {
            $requiredHeaders = ['Full Name', 'E-Mail', 'Phone #'];
            if (!array_key_exists('A', $row) || !array_key_exists('B', $row) || !array_key_exists('C', $row) ||
                $row['A'] !== $requiredHeaders[0] || $row['B'] !== $requiredHeaders[1] || $row['C'] !== $requiredHeaders[2]) {
                $errors[] = 'Invalid or missing headers in one or more rows. The headers should be Full Name, E-Mail, Phone #';
                return redirect(route('employee.download'))
                    ->withErrors($errors)
                    ->withInput();
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
                $errors = array_merge($errors, $validator->errors()->all());
                return redirect(route('employee.download'))
                    ->withErrors($errors)
                    ->withInput();
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
