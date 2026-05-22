<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\District;
use App\Models\Taluka;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;
use League\Csv\Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImportController extends Controller
{
    public function index()
    {
        $countries = Country::all(['id', 'name']);
        return view('admin.settings.import.index', compact('countries'));
    }

    /**
     * Export Countries CSV
     */
    public function exportCountries()
    {
        $countries = Country::all(['id', 'name', 'phonecode']);
        
        $csv = Writer::createFromString('');
        $csv->insertOne(['id', 'name', 'phonecode']);
        
        foreach ($countries as $country) {
            $csv->insertOne([$country->id, $country->name, $country->phonecode]);
        }

        $response = new StreamedResponse();
        $response->setCallback(function() use ($csv) {
            echo $csv->toString();
        });
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="countries.csv"');
        
        return $response;
    }

    /**
     * Export States CSV
     */
    public function exportStates()
    {
        $states = State::with('country')->get(['id', 'name', 'country_id']);
        
        $csv = Writer::createFromString('');
        $csv->insertOne(['id', 'name', 'country_id', 'country_name']);
        
        foreach ($states as $state) {
            $csv->insertOne([
                $state->id, 
                $state->name, 
                $state->country_id, 
                $state->country ? $state->country->name : ''
            ]);
        }

        $response = new StreamedResponse();
        $response->setCallback(function() use ($csv) {
            echo $csv->toString();
        });
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="states.csv"');
        
        return $response;
    }

    /**
     * Export Cities CSV
     */
    public function exportCities()
    {
        $cities = City::with(['state.country'])->get(['id', 'name', 'state_id']);
        
        $csv = Writer::createFromString('');
        $csv->insertOne(['id', 'name', 'state_id', 'state_name', 'country_id', 'country_name']);
        
        foreach ($cities as $city) {
            $csv->insertOne([
                $city->id, 
                $city->name, 
                $city->state_id,
                $city->state ? $city->state->name : '',
                $city->state && $city->state->country ? $city->state->country->id : '',
                $city->state && $city->state->country ? $city->state->country->name : ''
            ]);
        }

        $response = new StreamedResponse();
        $response->setCallback(function() use ($csv) {
            echo $csv->toString();
        });
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="cities.csv"');
        
        return $response;
    }

    /**
     * Export Districts CSV
     */
    public function exportDistricts()
    {
        $districts = District::with(['state.country'])->get(['id', 'name', 'state_id']);
        
        $csv = Writer::createFromString('');
        $csv->insertOne(['id', 'name', 'state_id', 'state_name', 'country_id', 'country_name']);
        
        foreach ($districts as $district) {
            $csv->insertOne([
                $district->id, 
                $district->name, 
                $district->state_id,
                $district->state ? $district->state->name : '',
                $district->state && $district->state->country ? $district->state->country->id : '',
                $district->state && $district->state->country ? $district->state->country->name : ''
            ]);
        }

        $response = new StreamedResponse();
        $response->setCallback(function() use ($csv) {
            echo $csv->toString();
        });
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="districts.csv"');
        
        return $response;
    }

    /**
     * Export Talukas CSV
     */
    public function exportTalukas()
    {
        $talukas = Taluka::with(['city.state.country'])->get(['id', 'name', 'city_id']);
        
        $csv = Writer::createFromString('');
        $csv->insertOne(['id', 'name', 'city_id', 'city_name', 'state_id', 'state_name', 'country_id', 'country_name']);
        
        foreach ($talukas as $taluka) {
            $csv->insertOne([
                $taluka->id, 
                $taluka->name, 
                $taluka->city_id,
                $taluka->city ? $taluka->city->name : '',
                $taluka->city && $taluka->city->state ? $taluka->city->state->id : '',
                $taluka->city && $taluka->city->state ? $taluka->city->state->name : '',
                $taluka->city && $taluka->city->state && $taluka->city->state->country ? $taluka->city->state->country->id : '',
                $taluka->city && $taluka->city->state && $taluka->city->state->country ? $taluka->city->state->country->name : ''
            ]);
        }

        $response = new StreamedResponse();
        $response->setCallback(function() use ($csv) {
            echo $csv->toString();
        });
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="talukas.csv"');
        
        return $response;
    }

    /**
     * Export Villages CSV
     */
    public function exportVillages()
    {
        $villages = Village::with(['taluka.city.state.country'])->get(['id', 'name', 'taluka_id']);
        
        $csv = Writer::createFromString('');
        $csv->insertOne(['id', 'name', 'taluka_id', 'taluka_name', 'city_id', 'city_name', 'state_id', 'state_name', 'country_id', 'country_name']);
        
        foreach ($villages as $village) {
            $csv->insertOne([
                $village->id, 
                $village->name, 
                $village->taluka_id,
                $village->taluka ? $village->taluka->name : '',
                $village->taluka && $village->taluka->city ? $village->taluka->city->id : '',
                $village->taluka && $village->taluka->city ? $village->taluka->city->name : '',
                $village->taluka && $village->taluka->city && $village->taluka->city->state ? $village->taluka->city->state->id : '',
                $village->taluka && $village->taluka->city && $village->taluka->city->state ? $village->taluka->city->state->name : '',
                $village->taluka && $village->taluka->city && $village->taluka->city->state && $village->taluka->city->state->country ? $village->taluka->city->state->country->id : '',
                $village->taluka && $village->taluka->city && $village->taluka->city->state && $village->taluka->city->state->country ? $village->taluka->city->state->country->name : ''
            ]);
        }

        $response = new StreamedResponse();
        $response->setCallback(function() use ($csv) {
            echo $csv->toString();
        });
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="villages.csv"');
        
        return $response;
    }

    /**
     * Download CSV Template
     */
    public function downloadTemplate($type)
    {
        $templates = [
            'countries' => ['name', 'phonecode'],
            'states' => ['name', 'country_id'],
            'cities' => ['name', 'state_id'],
            'districts' => ['name', 'state_id'],
            'talukas' => ['name', 'city_id'],
            'villages' => ['name', 'taluka_id']
        ];

        if (!isset($templates[$type])) {
            return redirect()->back()->with('error', 'Invalid template type.');
        }

        $csv = Writer::createFromString('');
        $csv->insertOne($templates[$type]);
        
        // Add example data
        $examples = [
            'countries' => ['United States', '1'],
            'states' => ['California', '1'],
            'cities' => ['Los Angeles', '1'],
            'districts' => ['Central District', '1'],
            'talukas' => ['Downtown Taluka', '1'],
            'villages' => ['Village Center', '1']
        ];

        if (isset($examples[$type])) {
            $csv->insertOne($examples[$type]);
        }

        $response = new StreamedResponse();
        $response->setCallback(function() use ($csv) {
            echo $csv->toString();
        });
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $type . '_template.csv"');
        
        return $response;
    }

    /**
     * Import CSV Data
     */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:countries,states,cities,districts,talukas,villages',
            'file' => 'required|file|mimes:csv,txt|max:10240'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $type = $request->type;
        $file = $request->file('file');

        try {
            $csv = Reader::createFromPath($file->getPathname());
            $csv->setHeaderOffset(0);
            $records = $csv->getRecords();

            $imported = 0;
            $errors = [];

            DB::beginTransaction();

            foreach ($records as $index => $record) {
                try {
                    switch ($type) {
                        case 'countries':
                            $this->importCountry($record, $index + 1);
                            break;
                        case 'states':
                            $this->importState($record, $index + 1);
                            break;
                        case 'cities':
                            $this->importCity($record, $index + 1);
                            break;
                        case 'districts':
                            $this->importDistrict($record, $index + 1);
                            break;
                        case 'talukas':
                            $this->importTaluka($record, $index + 1);
                            break;
                        case 'villages':
                            $this->importVillage($record, $index + 1);
                            break;
                    }
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
                }
            }

            DB::commit();

            $message = "Successfully imported {$imported} records.";
            if (!empty($errors)) {
                $message .= " " . count($errors) . " errors occurred.";
                session()->flash('import_errors', $errors);
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    private function importCountry($record, $rowNumber)
    {
        $validator = Validator::make($record, [
            'name' => 'required|string|max:255',
            'phonecode' => 'required|integer'
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation failed: ' . implode(', ', $validator->errors()->all()));
        }

        Country::updateOrCreate(
            ['name' => $record['name']],
            ['phonecode' => $record['phonecode']]
        );
    }

    private function importState($record, $rowNumber)
    {
        $validator = Validator::make($record, [
            'name' => 'required|string|max:255',
            'country_id' => 'required|integer|exists:countries,id'
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation failed: ' . implode(', ', $validator->errors()->all()));
        }

        State::updateOrCreate(
            ['name' => $record['name'], 'country_id' => $record['country_id']],
            ['country_id' => $record['country_id']]
        );
    }

    private function importCity($record, $rowNumber)
    {
        $validator = Validator::make($record, [
            'name' => 'required|string|max:255',
            'state_id' => 'required|integer|exists:states,id'
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation failed: ' . implode(', ', $validator->errors()->all()));
        }

        City::updateOrCreate(
            ['name' => $record['name'], 'state_id' => $record['state_id']],
            ['state_id' => $record['state_id']]
        );
    }

    private function importDistrict($record, $rowNumber)
    {
        $validator = Validator::make($record, [
            'name' => 'required|string|max:255',
            'state_id' => 'required|integer|exists:states,id'
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation failed: ' . implode(', ', $validator->errors()->all()));
        }

        District::updateOrCreate(
            ['name' => $record['name'], 'state_id' => $record['state_id']],
            ['state_id' => $record['state_id']]
        );
    }

    private function importTaluka($record, $rowNumber)
    {
        $validator = Validator::make($record, [
            'name' => 'required|string|max:255',
            'city_id' => 'required|integer|exists:cities,id'
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation failed: ' . implode(', ', $validator->errors()->all()));
        }

        Taluka::updateOrCreate(
            ['name' => $record['name'], 'city_id' => $record['city_id']],
            ['city_id' => $record['city_id']]
        );
    }

    private function importVillage($record, $rowNumber)
    {
        $validator = Validator::make($record, [
            'name' => 'required|string|max:255',
            'taluka_id' => 'required|integer|exists:talukas,id'
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation failed: ' . implode(', ', $validator->errors()->all()));
        }

        Village::updateOrCreate(
            ['name' => $record['name'], 'taluka_id' => $record['taluka_id']],
            ['taluka_id' => $record['taluka_id']]
        );
    }
}
