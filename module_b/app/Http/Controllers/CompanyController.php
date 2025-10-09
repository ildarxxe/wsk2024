<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function getCompanies(Request $request, $format = null) {
        $companies = Company::all();

        if ($format == ".json" || $request->wantsJson()) {
            return CompanyResource::collection($companies);
        }

        return view("companies")->with("companies", $companies->toArray());
    }

    public function getCompany(Request $request, $id, $format = null) {
        $cleanID = str_replace(".json", "", $id);
        $company = Company::query()->with('products')->find($cleanID);

        if ($format == ".json" || str_ends_with($id, ".json") || $request->wantsJson()) {
            return new CompanyResource($company);
        }

        return view("company")->with("company", $company->toArray());
    }

    public function createCompany(Request $request) {
        $data = $request->validate([
            "name" => "required|string",
            "address" => "required|string",
            "phone_number" => "required|string",
            "email" => "required|string",
            "owner_name" => "required|string",
            "owner_number" => "required|string",
            "owner_email" => "required|string",
            "contact_name" => "required|string",
            "contact_number" => "required|string",
            "contact_email" => "required|string",
        ]);

        try {
            Company::query()->create($data);
            return redirect()->back()->with(["success" => "Company created successfully"]);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(["error" => "failed to create company"]);
        }
    }

    public function updateCompany(Request $request, $id) {
        $data = $request->validate([
            "name" => "required|string",
            "address" => "required|string",
            "phone_number" => "required|string",
            "email" => "required|string",
            "owner_name" => "required|string",
            "owner_number" => "required|string",
            "owner_email" => "required|string",
            "contact_name" => "required|string",
            "contact_number" => "required|string",
            "contact_email" => "required|string",
        ]);

        try {
            $company = Company::query()->where("id", $id)->first();
            $company->update($data);
            return redirect()->back()->with(["success" => "Company updated successfully"]);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(["error" => "failed to update company"]);
        }
    }

    public function deactivateCompany(Request $request, $id) {
        $company = Company::query()->with("products")->find($id);

        try {
            $company->update(["is_deactivated" => true]);
            foreach ($company->products as $product) {
                $product->update(["is_hidden" => true]);
            }
            return redirect()->back()->with(["success" => "Company deactivated successfully"]);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(["error" => "Failed to deactivate company"]);
        }
    }
}
