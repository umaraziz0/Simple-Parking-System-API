<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Exports\ParkingsExport;
use App\Exports\ParkingsExportByDate;
use Maatwebsite\Excel\Facades\Excel;


class ParkingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parkingData = Parking::orderBy("updated_at", "desc")->get();

        return response($parkingData, 200);
    }

    /**
     * Exports all parking data
     *
     */
    public function export()
    {
        return Excel::download(new ParkingsExport, 'parking-data.xlsx');
    }

    /**
     * Helper function to generate unique code
     *
     */
    public function generateUniqueCode()
    {
        $uniqueCode = Str::random(6);

        // ! Validate if code is not already in database
        $codeExists = Parking::query()
            ->where("unique_code", $uniqueCode)
            ->exists();

        if ($codeExists) {
            $this->generateUniqueCode();
        }

        return $uniqueCode;
    }

    /**
     * Enters a car into the parking lot
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * Example Request
         * {
         *   license_plate: "6ZRN866"
         * }
         */

        // ! Validate license plate input
        $request->validate([
            "license_plate" => "required|string",
        ]);

        // ! Validate if vehicle entered already and hasn't exited
        $car = Parking::query()
            ->where("license_plate", $request->input("license_plate"))
            ->latest()
            ->first();

        if ($car && !$car->exit_time) {
            return response([
                "message" => "Vehicle has not yet exited the parking lot.",
                "unique_code" => $car->unique_code
            ], 403);
        }

        // Generate 6 character unique code
        $uniqueCode = $this->generateUniqueCode();
        $request->request->add(["unique_code" => $uniqueCode]);

        $car = Parking::create($request->all());

        return response([
            "message" => "Car entered the parking lot.",
            "license_plate" => $car->license_plate,
            "entered_at" => $car->created_at,
            "unique_code" => $car->unique_code,
        ], 200);
    }

    /**
     * Exits a car from the parking lot
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exit(Request $request)
    {
        /**
         * Example Request
         * {
         *   unique_code: "6ZRN866"
         * }
         */

        // ! Validate license plate input
        $request->validate([
            "unique_code" => "required|string|exists:parkings",
        ]);

        $car = Parking::query()
            ->where("unique_code", $request->input("unique_code"))
            ->where("exit_time", null)
            ->first();

        // ! Validate if car is not in parking lot
        if (!$car) {
            return response(["message" => "Car is not in parking lot."], 404);
        }

        // Calculate parking fee
        $enterTime = Carbon::parse($car->created_at);
        $exitTime = Carbon::now();

        $parkingFee = ceil($enterTime->floatDiffInHours($exitTime)) * 3000;

        $car->exit_time = $exitTime;
        $car->parking_fee = $parkingFee;
        $car->save();

        return response(
            [
                "message" => "Car exited from the parking lot.",
                "license_plate" => $car->license_plate,
                "unique_code" => $car->unique_code,
                "exit_time" => $car->exit_time,
                "parking_fee" => $car->parking_fee
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Displays parking records by a given date range
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showByDateRange(Request $request)
    {
        /**
         * Example Request
         * {
         *   fromDate: "2021-05-30 08:21:16",
         *   toDate: "2021-05-30 08:50:51",
         * }
         */

        // ! Validate from and to date inputs
        $request->validate([
            "fromDate" => "required|date",
            "toDate" => "required|date"
        ]);

        $results = Parking::query()
            ->whereBetween("updated_at", [$request->input("fromDate"), $request->input("toDate")])
            ->get();

        if ($results->isEmpty()) {
            return response(["message" => "No results found between the given date range."], 404);
        }

        return response($results, 200);
    }

    /**
     * Exports parking records by a given date range
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportByDateRange(Request $request)
    {
        /**
         * Example Request
         * {
         *   fromDate: "2021-05-30 08:21:16",
         *   toDate: "2021-05-30 08:50:51",
         * }
         */

        // ! Validate from and to date inputs
        $request->validate([
            "fromDate" => "required|date",
            "toDate" => "required|date"
        ]);

        $results = Parking::query()
            ->whereBetween("updated_at", [$request->input("fromDate"), $request->input("toDate")])
            ->get();

        if ($results->isEmpty()) {
            return response(["message" => "No results found between the given date range."], 404);
        }

        return (new ParkingsExportByDate)
            ->dateRange($request->input("fromDate"), $request->input("toDate"))
            ->download("parking-data-by-date.xlsx");
    }

    // TODO: show by license plate
    // TODO: show by unique id

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
