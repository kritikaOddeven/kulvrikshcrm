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
use Illuminate\Support\Facades\Validator;
use League\Csv\Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    private $exportConfig = [
        'countries' => [
            'model' => Country::class,
            'columns' => ['id', 'name', 'phonecode'],
            'headers' => ['id', 'name', 'phonecode'],
            'filename' => 'countries.csv',
            'relations' => [],
            'filters' => []
        ],
        'states' => [
            'model' => State::class,
            'columns' => ['id', 'name', 'country_id'],
            'headers' => ['id', 'name', 'country_id', 'country_name'],
            'filename' => 'states.csv',
            'relations' => ['country'],
            'filters' => ['country_id']
        ],
        'cities' => [
            'model' => City::class,
            'columns' => ['id', 'name', 'state_id'],
            'headers' => ['id', 'name', 'state_id', 'state_name', 'country_id', 'country_name'],
            'filename' => 'cities.csv',
            'relations' => ['state.country'],
            'filters' => ['country_id', 'state_id']
        ],
        'districts' => [
            'model' => District::class,
            'columns' => ['id', 'name', 'state_id'],
            'headers' => ['id', 'name', 'state_id', 'state_name', 'country_id', 'country_name'],
            'filename' => 'districts.csv',
            'relations' => ['state.country'],
            'filters' => ['country_id', 'state_id']
        ],
        'talukas' => [
            'model' => Taluka::class,
            'columns' => ['id', 'name', 'city_id'],
            'headers' => ['id', 'name', 'city_id', 'city_name', 'state_id', 'state_name', 'country_id', 'country_name'],
            'filename' => 'talukas.csv',
            'relations' => ['city.state.country'],
            'filters' => ['country_id', 'state_id', 'city_id']
        ],
        'villages' => [
            'model' => Village::class,
            'columns' => ['id', 'name', 'taluka_id'],
            'headers' => ['id', 'name', 'taluka_id', 'taluka_name', 'city_id', 'city_name', 'state_id', 'state_name', 'country_id', 'country_name'],
            'filename' => 'villages.csv',
            'relations' => ['taluka.city.state.country'],
            'filters' => ['country_id', 'state_id', 'city_id', 'taluka_id']
        ]
    ];

    public function export(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:countries,states,cities,districts,talukas,villages',
            'country_id' => 'nullable|integer|exists:countries,id',
            'state_id' => 'nullable|integer|exists:states,id',
            'city_id' => 'nullable|integer|exists:cities,id',
            'taluka_id' => 'nullable|integer|exists:talukas,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $type = $request->type;
        $config = $this->exportConfig[$type];

        if (!$config) {
            return redirect()->back()->with('error', 'Invalid export type.');
        }

        $query = $config['model']::query();

        // Add relations if specified
        if (!empty($config['relations'])) {
            $query->with($config['relations']);
        }

        // Apply filters
        $this->applyFilters($query, $request, $type);

        // Select specific columns
        $data = $query->get($config['columns']);

        // Generate CSV
        $csv = Writer::createFromString('');
        $csv->insertOne($config['headers']);

        foreach ($data as $item) {
            $row = $this->formatRow($item, $type);
            $csv->insertOne($row);
        }

        // Create response
        $response = new StreamedResponse();
        $response->setCallback(function() use ($csv) {
            echo $csv->toString();
        });
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $config['filename'] . '"');

        return $response;
    }

    private function applyFilters($query, $request, $type)
    {
        switch ($type) {
            case 'states':
                if ($request->filled('country_id')) {
                    $query->where('country_id', $request->country_id);
                }
                break;

            case 'cities':
                if ($request->filled('country_id')) {
                    $query->whereHas('state', function($q) use ($request) {
                        $q->where('country_id', $request->country_id);
                    });
                }
                if ($request->filled('state_id')) {
                    $query->where('state_id', $request->state_id);
                }
                break;

            case 'districts':
                if ($request->filled('country_id')) {
                    $query->whereHas('state', function($q) use ($request) {
                        $q->where('country_id', $request->country_id);
                    });
                }
                if ($request->filled('state_id')) {
                    $query->where('state_id', $request->state_id);
                }
                break;

            case 'talukas':
                if ($request->filled('country_id')) {
                    $query->whereHas('city.state', function($q) use ($request) {
                        $q->where('country_id', $request->country_id);
                    });
                }
                if ($request->filled('state_id')) {
                    $query->whereHas('city', function($q) use ($request) {
                        $q->where('state_id', $request->state_id);
                    });
                }
                if ($request->filled('city_id')) {
                    $query->where('city_id', $request->city_id);
                }
                break;

            case 'villages':
                if ($request->filled('country_id')) {
                    $query->whereHas('taluka.city.state', function($q) use ($request) {
                        $q->where('country_id', $request->country_id);
                    });
                }
                if ($request->filled('state_id')) {
                    $query->whereHas('taluka.city', function($q) use ($request) {
                        $q->where('state_id', $request->state_id);
                    });
                }
                if ($request->filled('city_id')) {
                    $query->whereHas('taluka', function($q) use ($request) {
                        $q->where('city_id', $request->city_id);
                    });
                }
                if ($request->filled('taluka_id')) {
                    $query->where('taluka_id', $request->taluka_id);
                }
                break;
        }
    }

    private function formatRow($item, $type)
    {
        switch ($type) {
            case 'countries':
                return [$item->id, $item->name, $item->phonecode];

            case 'states':
                return [
                    $item->id,
                    $item->name,
                    $item->country_id,
                    $item->country ? $item->country->name : ''
                ];

            case 'cities':
                return [
                    $item->id,
                    $item->name,
                    $item->state_id,
                    $item->state ? $item->state->name : '',
                    $item->state && $item->state->country ? $item->state->country->id : '',
                    $item->state && $item->state->country ? $item->state->country->name : ''
                ];

            case 'districts':
                return [
                    $item->id,
                    $item->name,
                    $item->state_id,
                    $item->state ? $item->state->name : '',
                    $item->state && $item->state->country ? $item->state->country->id : '',
                    $item->state && $item->state->country ? $item->state->country->name : ''
                ];

            case 'talukas':
                return [
                    $item->id,
                    $item->name,
                    $item->city_id,
                    $item->city ? $item->city->name : '',
                    $item->city && $item->city->state ? $item->city->state->id : '',
                    $item->city && $item->city->state ? $item->city->state->name : '',
                    $item->city && $item->city->state && $item->city->state->country ? $item->city->state->country->id : '',
                    $item->city && $item->city->state && $item->city->state->country ? $item->city->state->country->name : ''
                ];

            case 'villages':
                return [
                    $item->id,
                    $item->name,
                    $item->taluka_id,
                    $item->taluka ? $item->taluka->name : '',
                    $item->taluka && $item->taluka->city ? $item->taluka->city->id : '',
                    $item->taluka && $item->taluka->city ? $item->taluka->city->name : '',
                    $item->taluka && $item->taluka->city && $item->taluka->city->state ? $item->taluka->city->state->id : '',
                    $item->taluka && $item->taluka->city && $item->taluka->city->state ? $item->taluka->city->state->name : '',
                    $item->taluka && $item->taluka->city && $item->taluka->city->state && $item->taluka->city->state->country ? $item->taluka->city->state->country->id : '',
                    $item->taluka && $item->taluka->city && $item->taluka->city->state && $item->taluka->city->state->country ? $item->taluka->city->state->country->name : ''
                ];

            default:
                return [];
        }
    }

    public function getStates(Request $request)
    {
        $states = State::where('country_id', $request->country_id)->get(['id', 'name']);
        return response()->json($states);
    }

    public function getCities(Request $request)
    {
        $cities = City::where('state_id', $request->state_id)->get(['id', 'name']);
        return response()->json($cities);
    }

    public function getTalukas(Request $request)
    {
        $talukas = Taluka::where('city_id', $request->city_id)->get(['id', 'name']);
        return response()->json($talukas);
    }
}