<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use App\Models\ActionItem;
use App\Models\Capa;
use App\Models\CC;
use Illuminate\Support\Facades\App;
use App\Models\EffectivenessCheck;
use App\Models\Extension;
use App\Models\InternalAudit;
use App\Models\ManagementReview;
use App\Models\RiskManagement;
use App\Models\LabIncident;
use App\Models\Auditee;
use App\Models\AuditProgram;
use App\Models\Supplier;
use App\Models\RootCauseAnalysis;
use App\Models\Observation;
use App\Models\SupplierSite;
use App\Models\Deviation;
use App\Models\SupplierAudit;
use App\Models\MedicalDeviceRegistration;
use App\Models\SCAR;
use Helpers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // public function index(){
    //     if(Helpers::checkRoles(3)){
    //         $data = CC::where('initiator_id',Auth::user()->id)->orderbyDESC('id')->get();
    //         $child = [];
    //         $childs = [];
    //         foreach($data as $datas){
    //             $datas->originator = User::where('id',$datas->initiator_id)->value('name');
    //             $datas->actionItem = ActionItem::where('cc_id',$datas->id)->get();
    //             $datas->extension = Extension::where('cc_id',$datas->id)->get();


    //         }


    //         return view('frontend.rcms.dashboard',compact('data'));
    //     }
    // }

    public function index()
    {
        $table = [];

        $datas = CC::orderByDesc('id')->get();
        $datas1 = ActionItem::orderByDesc('id')->get();
        $datas2 = Extension::orderByDesc('id')->get();
        $datas3 = EffectivenessCheck::orderByDesc('id')->get();
        $datas4 = InternalAudit::orderByDesc('id')->get();
        $datas5 = Capa::orderByDesc('id')->get();
        $datas6 = RiskManagement::orderByDesc('id')->get();
        $datas7 = ManagementReview::orderByDesc('id')->get();
        $datas8 = LabIncident::orderByDesc('id')->get();
        $datas9 = Auditee::orderByDesc('id')->get();
        $datas10 = AuditProgram::orderByDesc('id')->get();
        $datas11 = RootCauseAnalysis::orderByDesc('id')->get();
        $datas12 = Observation::orderByDesc('id')->get();
        $datas13 = Deviation::orderByDesc('id')->get();
        $datas15 = MedicalDeviceRegistration::orderByDesc('id')->get();
        $supplier = Supplier::orderByDesc('id')->get();
        $supplierAudit =  SupplierAudit::orderByDesc('id')->get();
        $scarData =  SCAR::orderByDesc('id')->get();
        
        foreach ($supplierAudit as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_id ? $data->parent_id : "-",
                "record" => $data->record,
                "type" => "Supplier-Audit",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->create,
                "date_close" => $data->updated_at,
            ]);
        }
        $supplierSite = SupplierSite::orderByDesc('id')->get();


        foreach ($datas as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_id ? $data->parent_id : "-",
                "record" => $data->record,
                "type" => "Change-Control",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->create,
                "date_close" => $data->updated_at,
            ]);
        }

        foreach ($datas1 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_id ? $data->parent_id : "-",
                "record" => $data->record,
                "type" => "Action-Item",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->create,
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($datas2 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->cc_id ? $data->cc_id : "-",
                "record" => $data->record,
                "type" => "Extension",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->create,
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($datas3 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "Effectiveness-Check",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->create,
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($datas4 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "Internal-Audit",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->create,
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($datas5 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            $revised_date = Extension::where('parent_id', $data->id)->where('parent_type', "Capa")->value('revised_date');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_id ? $data->parent_id : "-",
                "record" => $data->record,
                "type" => "Capa",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "intiation_date" => $revised_date ? $revised_date : $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->create,
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($datas6 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_id ? $data->parent_id : "-",
                "record" => $data->record,
                "type" => "Risk-Assesment",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->create,
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($datas7 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "Management-Review",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->create,
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($datas8 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "Lab-Incident",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_desc ? $data->short_desc : "-",
                "initiator_id" => $data->initiator_id,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->create,
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($datas9 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "External-Audit",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->create,
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($datas10 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_id ? $data->parent_id : "-",
                "record" => $data->record,
                "type" => "Audit-Program",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->create,
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($datas11 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_id ? $data->parent_id : "-",
                "record" => $data->record,
                "division_id" => $data->division_id,
                "type" => "Root-Cause-Analysis",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->create,
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($datas12 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_id ? $data->parent_id : "-",
                "record" => $data->record,
                "division_id" => $data->division_code,
                "type" => "Observation",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->create,
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($datas13 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_id ? $data->parent_id : "-",
                "record" => $data->record,
                "division_id" => $data->division_id,
                "type" => "Deviation",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->create,
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($datas15 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "division_id" => $data->division_id,
                "type" => "MedicalDeviceRegistration",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->create,
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($supplier as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_id ? $data->parent_id : "-",
                "record" => $data->record,
                "division_id" => $data->division_id,
                "type" => "Supplier",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
            ]);
        }

        foreach ($supplierSite as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_id ? $data->parent_id : "-",
                "record" => $data->record,
                "division_id" => $data->division_id,
                "type" => "Supplier Site",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
            ]);
        }

        foreach ($scarData as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_id ? $data->parent_id : "-",
                "record" => $data->record,
                "division_id" => $data->division_id,
                "type" => "SCAR",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "intiation_date" => $data->initiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
            ]);
        }
        $table  = collect($table)->sortBy('record')->reverse()->toArray();
        // return $table;
        // $paginatedData = json_encode($table);

      //  $datag = $this->paginate($table);
      $datag = $this->paginate($table);
        //   $paginatedData = json_encode($datag);

        return view('frontend.rcms.dashboard', compact('datag'));
    }

    public function dashboard_child($id, $process)
    {
        $table = [];
        if ($process == 1) {
            $datas1 = ActionItem::where('cc_id', $id)->orderByDesc('id')->get();
            $datas2 = Extension::where('cc_id', $id)->orderByDesc('id')->get();
            foreach ($datas1 as $data) {
                array_push($table, [
                    "id" => $data->id,
                    "parent" => $data->cc_id ? $data->cc_id : "-",
                    "record" => $data->record,
                    "type" => "Action-Item",
                    "short_description" => $data->short_description ? $data->short_description : "-",
                    "initiator_id" => $data->initiator_id,
                    "intiation_date" => $data->intiation_date,
                    "stage" => $data->status,
                    "date_open" => $data->created_at,
                    "date_close" => $data->updated_at,
                ]);
            }

            foreach ($datas2 as $data) {
                array_push($table, [
                    "id" => $data->id,
                    "parent" => $data->cc_id ? $data->cc_id : "-",
                    "record" => $data->record,
                    "type" => "Extension",
                    "short_description" => $data->short_description ? $data->short_description : "-",
                    "initiator_id" => $data->initiator_id,
                    "intiation_date" => $data->intiation_date,
                    "stage" => $data->status,
                    "date_open" => $data->created_at,
                    "date_close" => $data->updated_at,
                ]);
            }
        } else {
            if ($process == 2) {
                $ab = ActionItem::find($id);
                $data = CC::where('id', $ab->cc_id)->orderByDesc('id')->first();
                $datas1 = ActionItem::where('cc_id', $ab->cc_id)->orderByDesc('id')->get();
                $datas2 = Extension::where('cc_id', $ab->cc_id)->orderByDesc('id')->get();
                foreach ($data as $datas) {
                    array_push($table, [
                        "id" => $data->id,
                        "parent" => $data->cc_id ? $data->cc_id : "-",
                        "record" => $data->record,
                        "type" => "Change-Control",
                        "short_description" => $data->short_description ? $data->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data->intiation_date,
                        "stage" => $data->status,
                        "date_open" => $data->created_at,
                        "date_close" => $data->updated_at,
                    ]);
                }

                foreach ($datas1 as $data) {
                    array_push($table, [
                        "id" => $data->id,
                        "parent" => $data->cc_id ? $data->cc_id : "-",
                        "record" => $data->record,
                        "type" => "Action-Item",
                        "short_description" => $data->short_description ? $data->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data->intiation_date,
                        "stage" => $data->status,
                        "date_open" => $data->created_at,
                        "date_close" => $data->updated_at,
                    ]);
                }

                foreach ($datas2 as $data) {
                    array_push($table, [
                        "id" => $data->id,
                        "parent" => $data->cc_id ? $data->cc_id : "-",
                        "record" => $data->record,
                        "type" => "Extension",
                        "short_description" => $data->short_description ? $data->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data->intiation_date,
                        "stage" => $data->status,
                        "date_open" => $data->created_at,
                        "date_close" => $data->updated_at,
                    ]);
                }
            } elseif ($process == 3) {
                $ab = Extension::find($id);
                $data = CC::where('id', $ab->cc_id)->orderByDesc('id')->first();
                $datas1 = ActionItem::where('cc_id', $ab->cc_id)->orderByDesc('id')->get();
                $datas2 = Extension::where('cc_id', $ab->cc_id)->orderByDesc('id')->get();
                foreach ($data as $datas) {
                    array_push($table, [
                        "id" => $data->id,
                        "parent" => $data->cc_id ? $data->cc_id : "-",
                        "record" => $data->record,
                        "type" => "Change-Control",
                        "short_description" => $data->short_description ? $data->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data->intiation_date,
                        "stage" => $data->status,
                        "date_open" => $data->created_at,
                        "date_close" => $data->updated_at,
                    ]);
                }

                foreach ($datas1 as $data) {
                    array_push($table, [
                        "id" => $data->id,
                        "parent" => $data->cc_id ? $data->cc_id : "-",
                        "record" => $data->record,
                        "type" => "Action-Item",
                        "short_description" => $data->short_description ? $data->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data->intiation_date,
                        "stage" => $data->status,
                        "date_open" => $data->created_at,
                        "date_close" => $data->updated_at,
                    ]);
                }

                foreach ($datas2 as $data) {
                    array_push($table, [
                        "id" => $data->id,
                        "parent" => $data->cc_id ? $data->cc_id : "-",
                        "record" => $data->record,
                        "type" => "Extension",
                        "short_description" => $data->short_description ? $data->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data->intiation_date,
                        "stage" => $data->status,
                        "date_open" => $data->created_at,
                        "date_close" => $data->updated_at,
                    ]);
                }
            }
        }
        $table = collect($table)->sortBy('date_open')->reverse()->toArray();
        $datag = json_encode($table);
        return view('frontend.rcms.dashboard', compact('datag'));
    }
    public function dashboard_child_new($id, $process)
    {
        $table = [];

        if ($process == "extension") {

            $data = Extension::where('id', $id)->orderByDesc('id')->first();

            if ($data->parent_type == "Capa") {
                $data2 = Capa::where('id', $data->parent_id)->first();
                $data2->create = Carbon::parse($data2->created_at)->format('d-M-Y h:i A');
                array_push(
                    $table,
                    [
                        "id" => $data2->id,
                        "parent" => $data2->parent_record ? $data2->parent_record : "-",
                        "record" => $data2->record,
                        "type" => "Capa",
                        "parent_id" => $data2->parent_id,
                        "parent_type" => $data2->parent_type,
                        "division_id" => $data2->division_id,
                        "short_description" => $data2->short_description ? $data2->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data2->intiation_date,
                        "stage" => $data2->status,
                        "date_open" => $data2->create,
                        "date_close" => $data2->updated_at,
                    ]
                );
            }
            if ($data->parent_type == "Internal_audit") {
                $data2 = InternalAudit::where('id', $data->parent_id)->first();
                $data2->create = Carbon::parse($data2->created_at)->format('d-M-Y h:i A');
                array_push(
                    $table,
                    [
                        "id" => $data2->id,
                        "parent" => $data2->parent_record ? $data2->parent_record : "-",
                        "record" => $data2->record,
                        "type" => "Internal-Audit",
                        "parent_id" => $data2->parent_id,
                        "parent_type" => $data2->parent_type,
                        "division_id" => $data2->division_id,
                        "short_description" => $data2->short_description ? $data2->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data2->intiation_date,
                        "stage" => $data2->status,
                        "date_open" => $data2->create,
                        "date_close" => $data2->updated_at,
                    ]
                );
            }
            if ($data->parent_type == "External_audit") {
                $data2 = Auditee::where('id', $data->parent_id)->first();
                $data2->create = Carbon::parse($data2->created_at)->format('d-M-Y h:i A');
                array_push(
                    $table,
                    [
                        "id" => $data2->id,
                        "parent" => $data2->parent_record ? $data2->parent_record : "-",
                        "record" => $data2->record,
                        "type" => "External-Audit",
                        "parent_id" => $data2->parent_id,
                        "parent_type" => $data2->parent_type,
                        "division_id" => $data2->division_id,
                        "short_description" => $data2->short_description ? $data2->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data2->intiation_date,
                        "stage" => $data2->status,
                        "date_open" => $data2->create,
                        "date_close" => $data2->updated_at,
                    ]
                );
            }
            if ($data->parent_type == "Action_item") {
                $data2 = ActionItem::where('id', $data->parent_id)->first();
                $data2->create = Carbon::parse($data2->created_at)->format('d-M-Y h:i A');
                array_push(
                    $table,
                    [
                        "id" => $data2->id,
                        "parent" => $data2->parent_record ? $data2->parent_record : "-",
                        "record" => $data2->record,
                        "type" => "Action-Item",
                        "parent_id" => $data2->parent_id,
                        "parent_type" => $data2->parent_type,
                        "division_id" => $data2->division_id,
                        "short_description" => $data2->short_description ? $data2->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data2->intiation_date,
                        "stage" => $data2->status,
                        "date_open" => $data2->create,
                        "date_close" => $data2->updated_at,
                    ]
                );
            }
            if ($data->parent_type == "Audit_program") {
                $data2 = AuditProgram::where('id', $data->parent_id)->first();
                $data2->create = Carbon::parse($data2->created_at)->format('d-M-Y h:i A');
                array_push(
                    $table,
                    [
                        "id" => $data2->id,
                        "parent" => $data2->parent_record ? $data2->parent_record : "-",
                        "record" => $data2->record,
                        "type" => "Audit-Program",
                        "parent_id" => $data2->parent_id,
                        "parent_type" => $data2->parent_type,
                        "division_id" => $data2->division_id,
                        "short_description" => $data2->short_description ? $data2->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data2->intiation_date,
                        "stage" => $data2->status,
                        "date_open" => $data2->create,
                        "date_close" => $data2->updated_at,
                    ]
                );
            }
            if ($data->parent_type == "Observation") {
                $data2 = Observation::where('id', $data->parent_id)->first();
                $data2->create = Carbon::parse($data2->created_at)->format('d-M-Y h:i A');
                array_push(
                    $table,
                    [
                        "id" => $data2->id,
                        "parent" => $data2->parent_record ? $data2->parent_record : "-",
                        "record" => $data2->record,
                        "type" => "Observation",
                        "parent_id" => $data2->parent_id,
                        "parent_type" => $data2->parent_type,
                        "division_id" => $data2->division_id,
                        "short_description" => $data2->short_description ? $data2->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data2->intiation_date,
                        "stage" => $data2->status,
                        "date_open" => $data2->create,
                        "date_close" => $data2->updated_at,
                    ]
                );
            }
            if ($data->parent_type == "Change_control") {
                $data2 = CC::where('id', $data->parent_id)->first();
                $data2->create = Carbon::parse($data2->created_at)->format('d-M-Y h:i A');
                array_push(
                    $table,
                    [
                        "id" => $data2->id,
                        "parent" => $data2->parent_record ? $data2->parent_record : "-",
                        "record" => $data2->record,
                        "type" => "Change-Control",
                        "parent_id" => $data2->parent_id,
                        "parent_type" => $data2->parent_type,
                        "division_id" => $data2->division_id,
                        "short_description" => $data2->short_description ? $data2->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data2->intiation_date,
                        "stage" => $data2->status,
                        "date_open" => $data2->create,
                        "date_close" => $data2->updated_at,
                    ]
                );
            }
        } else {
            return redirect(url('rcms/qms-dashboard'));
        }

        $table  = collect($table)->sortBy('record')->reverse()->toArray();
        $datag = $this->paginate($table);



        // return redirect(url('rcms/qms-dashboard'));
        return view('frontend.rcms.dashboard', compact('datag'));
    }

    public function ccView($id, $type)
    {


        if ($type == "Supplier-Audit") {
            $data = SupplierAudit::find($id);
            $audit =route('SupplierAuditTrialReport', $data->id);
            $single = route('SupplierSingleReport', $data->id);
            $parent = "childReport/". $data->id;
        }
        if ($type == "Change-Control") {
            $data = CC::find($id);
            $single = "change_control_single_pdf/" . $data->id;
            $audit = "audit/" . $data->id;
        } elseif ($type == "Capa") {
            $data = Capa::find($id);
            $single = "capaSingleReport/" . $data->id;
            $audit = "capaAuditReport/" . $data->id;
        } elseif ($type == "Internal-Audit") {
            $data = InternalAudit::find($id);
            $single = "internalSingleReport/" . $data->id;
            $audit = "internalauditReport/" . $data->id;
        } elseif ($type == "Risk-Assesment") {
            $data = RiskManagement::find($id);
            $single = "riskSingleReport/" . $data->id;
            $audit = "riskAuditReport/" . $data->id;
        } elseif ($type == "Lab-Incident") {
            $data = LabIncident::find($id);
            $single = "LabIncidentSingleReport/" . $data->id;
            $audit = "LabIncidentAuditReport/" . $data->id;
        } elseif ($type == "External-Audit") {
            $data = Auditee::find($id);
            $single = "ExternalAuditSingleReport/" . $data->id;
            $audit = "ExternalAuditTrialReport/" . $data->id;
        } elseif ($type == "Audit-Program") {
            $data = AuditProgram::find($id);
            $single = "auditProgramSingleReport/" . $data->id;
            $audit = "auditProgramAuditReport/" . $data->id;
        } elseif ($type == "Action-Item") {
            $data = ActionItem::find($id);
            $single = "actionitemSingleReport/"  . $data->id;
            $audit = "actionitemAuditReport/" . $data->id;
        } elseif ($type == "Extension") {
            $data = Extension::find($id);
            $single = "extensionSingleReport/" .$data->id;
            $audit = "extensionAuditReport/" .$data->id;

        } elseif ($type == "Observation") {
            $data = Observation::find($id);
            $single = "#";
            $audit = "ObservationAuditTrialShow/" .$data->id;
            $parent="#";
        } elseif ($type == "Effectiveness-Check") {
            $data = EffectivenessCheck::find($id);
            $single = "effectiveSingleReport/" .$data->id;
            $audit = "effectiveAuditReport/" .$data->id;
        } elseif ($type == "Management-Review") {
            $data = ManagementReview::find($id);
            $single = "managementReview/" . $data->id;
            $audit = "managementReviewReport/" . $data->id;
        } elseif ($type == "Root-Cause-Analysis") {
            $data = RootCauseAnalysis::find($id);
            $single = "rootSingleReport/" . $data->id;
            $audit = "rootAuditReport/" . $data->id;
        } elseif ($type == "Deviation") {
            $data = Deviation::find($id);
            $single = "deviationSingleReport/". $data->id;
            $audit = "auditReport/" . $data->id;
            $parent="#";
        } elseif ($type == "Supplier") {
            $data = Supplier::find($id);
            // $single = "deviationSingleReport/". $data->id;
            $single = "supplier-single-report/show/". $data->id;
            $audit = "supplier-audit-trail-pdf/". $data->id;
            $parent="#";
        } elseif ($type == "Supplier Site") {
            $data = SupplierSite::find($id);
            // $single = "deviationSingleReport/". $data->id;
            $single = "supplier-site-single-report/". $data->id;
            $audit = "supplier-site-audit-trail-pdf/". $data->id;
            $parent="#";
        } elseif ($type == "SCAR") {
            $data = SCAR::find($id);
            $single = "scar-single-report/". $data->id;
            $audit = "scar-audit-trail-pdf/". $data->id;
            $parent="#";
        }


        $html = '';
        $html = '<div class="block">
        <div class="record_no">
            Record No. ' . str_pad($data->record, 4, '0', STR_PAD_LEFT) .
            '</div>
        <div class="division">
        ' . Helpers::getDivisionName(session()->get('division')) . '/ ' . $type . '
        </div>
        <div class="status">' .
            $data->status . '
        </div>
            </div>
            <div class="block">
                <div class="block-head">
                    Actions
                </div>
                <div class="block-list">
                    <a href="send-notification" class="list-item">Send Notification</a>
                    <div class="list-drop">
                        <div class="list-item" onclick="showAction()">
                            <div>Run Report</div>
                            <div><i class="fa-solid fa-angle-down"></i></div>
                        </div>
                        <div class="drop-list">
                            <a target="__blank" href="' . $audit . '" class="inner-item">Audit Trail</a>
                            <a target="__blank" href="' . $single . '" class="inner-item">' . $type . ' Single Report</a>
                            <a target="__blank" href="' . $parent . '" class="inner-item">' . $type . ' Parent with immediate child Report</a>
                        </div>
                    </div>
                </div>
            </div>';
        $response['html'] = $html;

        return response()->json($response);
    }

    //----------PAginator

    public function paginate($items, $perPage = 100000, $page = null, $options = ['path' => 'mytaskdata'])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
