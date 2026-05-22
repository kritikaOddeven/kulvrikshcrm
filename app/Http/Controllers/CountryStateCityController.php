<?php
namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\State;
use App\Models\Taluka;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CountryStateCityController extends Controller
{
    public function getState($country_id)
    {
        $states = State::where('country_id', $country_id)->get();
        return response()->json($states);
    }

    public function getCities($state_id)
    {
        $cities = City::where('state_id', $state_id)->get();
        return response()->json($cities);
    }

    public function getDistrict($state_id)
    {
        $districts = District::where('state_id', $state_id)->get();
        return response()->json($districts);
    }

    public function getTaluka($city_id)
    {
        $talukas = Taluka::where('city_id', $city_id)->get();
        return response()->json($talukas);
    }

    public function getVillages($taluka_id)
    {
        $villages = Village::where('taluka_id', $taluka_id)->get();
        return response()->json($villages);
    }

    public function getPhoneCode($country_id)
    {
        $country = Country::find($country_id);
        if ($country) {
            return response()->json(['phonecode' => '+' . $country->phonecode]);
        }
        return response()->json(['phonecode' => '']);
    }

    public function getCountryData(Request $request)
    {
        $countries = Country::select('id', 'name', 'phonecode')
            ->withCount('states'); // 👈 counts related states

        // Apply filters if required
        if ($request->filled('name')) {
            $countries->where('name', 'like', '%' . $request->name . '%');
        }

        return DataTables::of($countries)
            ->addColumn('action', function ($item) {
                // If country has states, don't show edit/delete
                if ($item->states_count > 0) {
                    return '';
                }

                $buttons = '<div class="d-flex">';

                if (auth()->user()->can('edit_country')) {
                    $buttons .= '<a class="edit-icon-btn btn-sm btn-action rounded-pill mr-1 edit-country"
                            data-id="' . $item->id . '"
                            data-name="' . $item->name . '"
                            data-phonecode="' . $item->phonecode . '">
                             <i class="ri-edit-line"></i>
                        </a>';
                }

                if (auth()->user()->can('delete_country')) {
                    $buttons .= '<form action="' . url('admin/settings/countries/delete/' . $item->id) . '"
                                method="POST"
                                id="deleteForm_' . $item->id . '"
                                style="display:inline;">' .
                    csrf_field() . method_field('DELETE') .
                    '<button type="button"
                                    class="delete-icon-btn btn-sm btn-action mr-1"
                                    onclick="deleteAccount(this, ' . $item->id . ')">
                                    <i class="ri-delete-bin-6-line"></i>
                                </button>
                            </form>';
                }

                $buttons .= '</div>';
                return $buttons;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getStateData(Request $request)
    {
        $states = State::with('country')->select('id', 'name', 'country_id')
            ->withCount('cities');

        // Apply filters if required
        if ($request->filled('name')) {
            $states->where('name', 'like', '%' . $request->name . '%');
        }

        return DataTables::of($states)
            ->addColumn('country_name', function ($item) {
                return $item->country ? $item->country->name : 'N/A';
            })
            ->addColumn('action', function ($item) {
                // If state has city, don't show edit/delete
                if ($item->cities_count > 0) {
                    return '';
                }

                $buttons = '';
                if (auth()->user()->can('edit_state')) {
                    $buttons .= '<button class="btn btn-sm btn-warning edit-state" data-id="' . $item->id . '" data-name="' . $item->name . '" data-country-id="' . $item->country_id . '">Edit</button> ';
                }
                if (auth()->user()->can('delete_state')) {
                    $buttons .= '<button class="btn btn-sm btn-danger delete-state" data-id="' . $item->id . '">Delete</button>';
                }
                return $buttons;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getDistrictData(Request $request)
    {
        $districts = District::with('state')->select('id', 'name', 'state_id');

        // Apply filters if required
        if ($request->filled('name')) {
            $districts->where('name', 'like', '%' . $request->name . '%');
        }

        return DataTables::of($districts)
            ->addColumn('state_name', function ($item) {
                return $item->state ? $item->state->name : 'N/A';
            })
            ->addColumn('action', function ($item) {
                $buttons = '';
                if (auth()->user()->can('edit_district')) {
                    $buttons .= '<button class="btn btn-sm btn-warning edit-district" data-id="' . $item->id . '" data-name="' . $item->name . '" data-state-id="' . $item->state_id . '">Edit</button> ';
                }
                if (auth()->user()->can('delete_district')) {
                    $buttons .= '<button class="btn btn-sm btn-danger delete-district" data-id="' . $item->id . '">Delete</button>';
                }
                return $buttons;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getCityData(Request $request)
    {
        $cities = City::with('state')->select('id', 'name', 'state_id')
            ->withCount('talukas');

        // Apply filters if required
        if ($request->filled('name')) {
            $cities->where('name', 'like', '%' . $request->name . '%');
        }

        return DataTables::of($cities)
            ->addColumn('state_name', function ($item) {
                return $item->state ? $item->state->name : 'N/A';
            })
            ->addColumn('action', function ($item) {
                // If state has city, don't show edit/delete
                if ($item->talukas_count > 0) {
                    return '';
                }

                $buttons = '';
                if (auth()->user()->can('edit_city')) {
                    $buttons .= '<button class="btn btn-sm btn-warning edit-city" data-id="' . $item->id . '" data-name="' . $item->name . '" data-state-id="' . $item->state_id . '">Edit</button> ';
                }
                if (auth()->user()->can('delete_city')) {
                    $buttons .= '<button class="btn btn-sm btn-danger delete-city" data-id="' . $item->id . '">Delete</button>';
                }
                return $buttons;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getTalukaData(Request $request)
    {
        $talukas = Taluka::with(['city.state'])->select('id', 'name', 'city_id')
            ->withCount('villages');

        // Apply filters if required
        if ($request->filled('name')) {
            $talukas->where('name', 'like', '%' . $request->name . '%');
        }

        return DataTables::of($talukas)
            ->addColumn('city_name', function ($item) {
                return $item->city ? $item->city->name : 'N/A';
            })
            ->addColumn('state_name', function ($item) {
                return $item->city && $item->city->state ? $item->city->state->name : 'N/A';
            })
            ->addColumn('action', function ($item) {
                // If state has city, don't show edit/delete
                if ($item->villages_count > 0) {
                    return '';
                }

                $buttons = '';
                if (auth()->user()->can('edit_taluka')) {
                    $buttons .= '<button class="btn btn-sm btn-warning edit-taluka" data-id="' . $item->id . '" data-name="' . $item->name . '" data-city-id="' . $item->city_id . '">Edit</button> ';
                }
                if (auth()->user()->can('delete_taluka')) {
                    $buttons .= '<button class="btn btn-sm btn-danger delete-taluka" data-id="' . $item->id . '">Delete</button>';
                }
                return $buttons;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getVillageData(Request $request)
    {
        $villages = Village::with(['taluka.city.state'])->select('id', 'name', 'taluka_id');

        // Apply filters if required
        if ($request->filled('name')) {
            $villages->where('name', 'like', '%' . $request->name . '%');
        }

        return DataTables::of($villages)
            ->addColumn('taluka_name', function ($item) {
                return $item->taluka ? $item->taluka->name : 'N/A';
            })
            ->addColumn('city_name', function ($item) {
                return $item->taluka && $item->taluka->city ? $item->taluka->city->name : 'N/A';
            })
            ->addColumn('state_name', function ($item) {
                return $item->taluka && $item->taluka->city && $item->taluka->city->state ? $item->taluka->city->state->name : 'N/A';
            })
            ->addColumn('action', function ($item) {
                $buttons = '';
                if (auth()->user()->can('edit_village')) {
                    $buttons .= '<button class="btn btn-sm btn-warning edit-village" data-id="' . $item->id . '" data-name="' . $item->name . '" data-taluka-id="' . $item->taluka_id . '">Edit</button> ';
                }
                if (auth()->user()->can('delete_village')) {
                    $buttons .= '<button class="btn btn-sm btn-danger delete-village" data-id="' . $item->id . '">Delete</button>';
                }
                return $buttons;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function countryStore(Request $request)
    {
        $request->validate([
            'country_name' => 'required|string|max:255|unique:countries,name',
            'phonecode'    => 'required|unique:countries,phonecode',
        ]);

        Country::create([
            'name'      => $request->country_name,
            'phonecode' => $request->phonecode,
        ]);

        return redirect()->back()->with('success', 'Country added successfully!');
    }

    public function stateStore(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'state_name' => 'required|string|max:255|unique:states,name',
        ]);

        State::create([
            'country_id' => $request->country_id,
            'name'       => $request->state_name,
        ]);

        return redirect()->back()->with('success', 'State created successfully.');
    }

    public function districtStore(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'state_id'   => 'required|exists:states,id',
            'district_name'       => [
                'required',
                'string',
                'max:255',
                Rule::unique('districts', 'name')->where(function ($query) use ($request) {
                    return $query->where('state_id', $request->state_id);
                }),
            ],
        ]);

        District::create([
            'state_id' => $request->state_id,
            'name'     => $request->district_name,
        ]);

        return redirect()->back()->with('success', 'District created successfully.');
    }

    public function cityStore(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'state_id'   => 'required|exists:states,id',
             'city_name'       => [
                'required',
                'string',
                'max:255',
                Rule::unique('cities', 'name')->where(function ($query) use ($request) {
                    return $query->where('state_id', $request->state_id);
                }),
            ],
        ]);

        City::create([
            'state_id' => $request->state_id,
            'name'     => $request->city_name,
        ]);

        return redirect()->back()->with('success', 'City created successfully.');
    }

    public function talukaStore(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'state_id'   => 'required|exists:states,id',
            'city_id'    => 'required|exists:cities,id',
           'taluka_name'       => [
                'required',
                'string',
                'max:255',
                Rule::unique('talukas', 'name')->where(function ($query) use ($request) {
                    return $query->where('city_id', $request->city_id);
                }),
            ],
        ]);

        Taluka::create([
            'city_id' => $request->city_id,
            'name'    => $request->taluka_name,
        ]);

        return redirect()->back()->with('success', 'Taluka created successfully.');
    }

    // public function villageStore(Request $request)
    // {
    //     $request->validate([
    //         'country_id' => 'required|exists:countries,id',
    //         'state_id'   => 'required|exists:states,id',
    //         'city_id'    => 'required|exists:cities,id',
    //         'taluka_id'  => 'required|exists:talukas,id',
    //         'village_name'       => [
    //             'required',
    //             'string',
    //             'max:255',
    //             Rule::unique('talukas', 'name')->where(function ($query) use ($request) {
    //                 return $query->where('taluka_id', $request->taluka_id);
    //             }),
    //         ],
    //     ]);

    //     Village::create([
    //         'taluka_id' => $request->taluka_id,
    //         'name'      => $request->village_name,
    //     ]);

    //     return redirect()->back()->with('success', 'Village created successfully.');
    // }

    public function villageStore(Request $request)
{
    $request->validate([
        'country_id' => 'required|exists:countries,id',
        'state_id'   => 'required|exists:states,id',
        'city_id'    => 'required|exists:cities,id',
        'taluka_id'  => 'required|exists:talukas,id',
        'village_name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('villages', 'name')->where(function ($query) use ($request) {
                return $query->where('taluka_id', $request->taluka_id);
            }),
        ],
    ]);

    Village::create([
        'taluka_id' => $request->taluka_id,
        'name'      => $request->village_name,
    ]);

    return redirect()->back()->with('success', 'Village created successfully.');
}

    // Update methods
    public function countryUpdate(Request $request, $id)
    {
        $request->validate([
            'country_name' => 'required|string|max:255|unique:countries,name,' . $id,
            'phonecode'    => 'required|unique:countries,phonecode,' . $id,
        ]);

        $country = Country::findOrFail($id);
        $country->update([
            'name'      => $request->country_name,
            'phonecode' => $request->phonecode,
        ]);

        return response()->json(['success' => true, 'message' => 'Country updated successfully']);
    }

    public function stateUpdate(Request $request, $id)
    {
        $request->validate([
            'state_name'       => 'required|string|max:255|unique:states,name,' . $id,
            'country_id' => 'required|exists:countries,id',
        ]);

        $state = State::findOrFail($id);
        $state->update([
            'name'       => $request->state_name,
            'country_id' => $request->country_id,
        ]);

        return response()->json(['success' => true, 'message' => 'State updated successfully']);
    }

    public function districtUpdate(Request $request, $id)
    {
        $request->validate([
            'district_name'     => 'required|string|max:255|unique:districts,name,' . $id,
            'state_id' => 'required|exists:states,id',
        ]);

        $district = District::findOrFail($id);
        $district->update([
            'name'     => $request->district_name,
            'state_id' => $request->state_id,
        ]);

        return response()->json(['success' => true, 'message' => 'District updated successfully']);
    }

    public function cityUpdate(Request $request, $id)
    {
        $request->validate([
            'city_name'     => 'required|string|max:255|unique:cities,name,' . $id,
            'state_id' => 'required|exists:states,id',
        ]);

        $city = City::findOrFail($id);
        $city->update([
            'name'     => $request->city_name,
            'state_id' => $request->state_id,
        ]);

        return response()->json(['success' => true, 'message' => 'City updated successfully']);
    }

    public function talukaUpdate(Request $request, $id)
    {
        $request->validate([
            'taluka_name'    => 'required|string|max:255|unique:talukas,name,' . $id,
            'city_id' => 'required|exists:cities,id',
        ]);

        $taluka = Taluka::findOrFail($id);
        $taluka->update([
            'name'    => $request->taluka_name,
            'city_id' => $request->city_id,
        ]);

        return response()->json(['success' => true, 'message' => 'Taluka updated successfully']);
    }

    public function villageUpdate(Request $request, $id)
    {
        $request->validate([
            'village_name'      => 'required|string|max:255|unique:villages,name,' . $id,
            'taluka_id' => 'required|exists:talukas,id',
        ]);

        $village = Village::findOrFail($id);
        $village->update([
            'name'      => $request->village_name,
            'taluka_id' => $request->taluka_id,
        ]);

        return response()->json(['success' => true, 'message' => 'Village updated successfully']);
    }

    // Delete methods
    public function countryDelete($id)
    {
        $country = Country::findOrFail($id);
        $country->delete();
        return redirect()->back()->with(['success' => "Country deleted successfully"]);
    }

    public function stateDelete($id)
    {
        $state = State::findOrFail($id);
        $state->delete();
        return response()->json(['success' => true, 'message' => 'State deleted successfully']);
    }

    public function districtDelete($id)
    {
        $district = District::findOrFail($id);
        $district->delete();
        return response()->json(['success' => true, 'message' => 'District deleted successfully']);
    }

    public function cityDelete($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        return response()->json(['success' => true, 'message' => 'City deleted successfully']);
    }

    public function talukaDelete($id)
    {
        $taluka = Taluka::findOrFail($id);
        $taluka->delete();
        return response()->json(['success' => true, 'message' => 'Taluka deleted successfully']);
    }

    public function villageDelete($id)
    {
        $village = Village::findOrFail($id);
        $village->delete();
        return response()->json(['success' => true, 'message' => 'Village deleted successfully']);
    }
}