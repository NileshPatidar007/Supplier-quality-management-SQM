@extends('frontend.layout.main')
@section('container')
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#ReferenceDocument').click(function(e) {
                function generateTableRow(serialNumber) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +


                        '<td><input type="text" name="PrimaryPackaging[]"></td>' +
                        '<td><input type="text" name="Material[]"></td>' +
                        '<td><input type="number" name="PackSize[]"></td>' +
                        '<td><input type="text" name="SelfLife[]"></td>' +
                        '<td><input type="text" name="StorageCondition[]"></td>' +
                        '<td><input type="text" name="SecondaryPacking[]"></td>' +
                        '<td><input type="text" name="Remarks[]"></td>' +



                        //     '</tr>';

                        // for (var i = 0; i < users.length; i++) {
                        //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                        // }

                        // html += '</select></td>' + 

                        '</tr>';

                    return html;
                }

                var tableBody = $('#ReferenceDocument_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    @php
        $users = DB::table('users')->get();
    @endphp

    <div class="form-field-head">
        {{-- <div class="pr-id">
            New Child
        </div> --}}
        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            / Medical Device Registration
        </div>
    </div>



    {{-- ! ========================================= --}}
    {{-- !               DATA FIELDS                 --}}
    {{-- ! ========================================= --}}
    <div id="change-control-fields">
        <div class="container-fluid">

            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Registration</button>
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Local Information</button> --}}
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Signatures</button>

            </div>

            <form action="{{ route('medical.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div id="step-form">
                    @if (!empty($parent_id))
                        <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                        <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                    @endif
                    <!-- Tab content -->
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="sub-head">
                                General Information
                            </div> <!-- RECORD NUMBER -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">

                                        <label for="RLS Record Number"><b>Initiator</b></label>

                                        <input type="text" name="initiator_id"
                                            value="{{ $validation->initiator_id ?? Auth::user()->name }}">

                                        {{-- <input type="text"  name="initiator_id" value="{{ $validation->initiator_id=Auth::user()->id }}">  --}}


                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due"><b>Date of Initiation</b></label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span class="text-danger">*</span>
                                            <p>255 characters remaining</p>
                                            <input id="docname" type="text" name="short_description"
                                                value="{{ $data->short_description }}" maxlength="255" required>
                                    </div>
                                </div>

                                {{-- <div class="col-md-6"> --}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="group-input">
                                                <label for="search">
                                                    Assigned To <span class="text-danger"></span>
                                                </label>
                                                <select id="select-assign-to" placeholder="Select..." name="assign_to">
                                                    <option value="">Select a value</option>
                                                    <option value="Vibha" @if (isset($data->assign_to) && $data->assign_to == 'Vibha') selected @endif>
                                                        Vibha</option>
                                                    <option value="Shruti" @if (isset($data->assign_to) && $data->assign_to == 'Shruti') selected @endif>
                                                        Shruti</option>
                                                    <option value="Monika" @if (isset($data->assign_to) && $data->assign_to == 'Monika') selected @endif>
                                                        Monika</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="due-date">Date Due <span class="text-danger"></span></label>
                                                <div class="calenderauditee">
    
                                                    <input type="text" id="due_date_gi" readonly placeholder="DD-MMM-YYYY" />
                                                    <input type="date" name="due_date_gi"
                                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                        oninput="handleDateInput(this)" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    



                                    {{-- <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly
                                            placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($ooc->due_date) }}" {{ $ooc->stage == 0 || $ooc->stage == 8 ? 'disabled' : ''}}/>
                                        <input type="date" name="due_date" {{ $ooc->stage == 0 || $ooc->stage == 8 ? 'disabled' : ''}}  min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                            oninput="handleDateInput(this, 'due_date')" />
                                    </div> --}}



                                    <div class="col-md-6">
                                        <div class="group-input">
                                            <label for="search">
                                                Type <span class="text-danger"></span>
                                            </label>
                                            <p class="text-primary">Registration Type</p>
                                            <select id="select-state" placeholder="Select..." name="registration_type_gi">
                                                <option value="">Select a value</option>
                                                <option value="1" @if ($data->registration_type_gi == 1) selected @endif>1
                                                </option>
                                                <option value="2" @if ($data->registration_type_gi == 2) selected @endif>2
                                                </option>
                                                <option value="3" @if ($data->registration_type_gi == 3) selected @endif>3
                                                </option>
                                            </select>

                                        </div>
                                    </div>


                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="Audit Attachments">File Attachments</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>
                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="Audit_file">
                                                    @if ($data->file_attachment_gi)
                                                        @foreach (json_decode($data->file_attachment_gi) as $file)
                                                            <h6 type="button" class="file-container text-dark"
                                                                style="background-color: rgb(243, 242, 240);">
                                                                <b>{{ $file }}</b>
                                                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                        class="fa fa-eye text-primary"
                                                                        style="font-size:20px; margin-right:-10px;"></i></a>
                                                                <a type="button" class="remove-file"
                                                                    data-file-name="{{ $file }}"><i
                                                                        class="fa-solid fa-circle-xmark"
                                                                        style="color:red; font-size:20px;"></i></a>
                                                            </h6>
                                                        @endforeach
                                                    @endif


                                                </div>
                                                <div class="add-btn">
                                                    <div>Add</div>
                                                    <input type="file" id="HOD_Attachments" name="Audit_file[]"
                                                        value="{{ $data->file_attachment_gi }}"
                                                        oninput="addMultipleFiles(this, 'Audit_file')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                    {{-- <div class="file-attachment-field">
                                <div class="file-attachment-list" id="Audit_file">
                                    @if ($data->file_attachment_gi)
                                    @foreach (json_decode($data->file_attachment_gi) as $file)
                                    <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                        <b>{{ $file }}</b>
                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                        <a type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                    </h6>
                                    @endforeach
                                    @endif
                                </div>
                                <div class="add-btn">
                                    <div>Add</div>
                                    <input type="file" id="Audit_file" name="Audit_file[]" value="{{$data->file_attachment_gi}}" oninput="addMultipleFiles(this, 'Audit_file')" multiple>
                                </div>
                            </div>
 --}}




                                    {{-- ============================================================================================================================= --}}


                                    {{-- 
                            {{-- <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Audit Attachments">File Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                    {{-- <input type="file" id="myfile" name="Initial_Attachment" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                        value="{{ $data->Initial_Attachment }}"> 
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Audit_file">
                                                @if ($data->file_attachment_gi)
                                                @foreach (json_decode($data->file_attachment_gi) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                {{-- <input {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} type="file" id="Audit_file" name="Audit_file[]"
                                                    oninput="addMultipleFiles(this, 'Audit_file')" multiple> 
                                                    <input type="file" id="Audit_file" name="Audit_file[]" value="{{$data->file_attachment_gi}}">
                                            </div>
                                        </div>
                                 </div>
                                   </div> --}}
                            
                                    <div class="sub-head">Registration Information</div>
                                    <div class="col-lg-6">
                                        <div class="group-input">

                                            <label for="RLS Record Number"><b>(Parent) Trade Name</b></label>

                                            <input type="text" name="parent_record_number"
                                                value="{{ $data->parent_record_number }}">


                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">

                                            <label class="" for="RLS Record Number"><b>Local Trade Name</b></label>

                                            <input type="text" name="local_record_number"
                                                value="{{ $data->local_record_number }}">


                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Responsible Department">Zone</label>
                                            <select name="zone_departments">
                                                <option value="">Enter Your Selection Here</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">

                                            <label for="RLS Record Number"><b>Country</b></label>
                                            <p class="text-primary">Auto filter according to selected zone</p>

                                            <input type="text" name="country_number" value="">


                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Responsible Department">Regulatory body</label>
                                            <p class="text-primary">auto filter according to country(if selected)</p>
                                            <select name="regulatory_departments">
                                                <option value="">Enter Your Selection Here</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">

                                            <label for="RLS Record Number"><b>Registration number</b></label>

                                            <input type="number" name="registration_number" value="">


                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Responsible Department">Class (Risk Based)</label>
                                            <p class="text-primary">auto filter according to country</p>
                                            <select name="risk_based_departments">
                                                <option value="">Enter Your Selection Here</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>



                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Responsible Department">Device Approval Type</label>
                                            <p class="text-primary">auto filter according to country</p>
                                            <select name="device_approval_departments">
                                                <option value="">Enter Your Selection Here</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="RLS Record Number"><b>Marketing Authorization Holder</b></label>
                                            <input type="number" name="marketing_auth_number" value="0"
                                                min="0" max="9" step="1">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">

                                            <label for="RLS Record Number"><b>Manufacturer</b></label>

                                            <input type="text" name="manufacturer_number" value="">


                                        </div>
                                    </div>

                                {{-- </div> --}}
                                <div class="group-input">
                                    <label for="audit-agenda-grid">
                                        Packaging Information (0)
                                        <button type="button" name="audit-agenda-grid" id="ReferenceDocument">+</button>
                                        <span class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#document-details-field-instruction-modal"
                                            style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (open)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="ReferenceDocument_details"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 4%">Row#</th>

                                                    <th style="width: 16%">Primary Packaging</th>
                                                    <th style="width: 14%">Material</th>
                                                    <th style="width: 14%">Pack Size</th>
                                                    <th style="width: 14%">Self Life</th>
                                                    <th style="width: 14%">Storage Condition</th>
                                                    <th style="width: 14%">Secondary Packaging</th>
                                                    <th style="width: 16%">Remarks</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input disabled type="text" name="serial[]" value="1">
                                                    </td>

                                                    <td><input type="text" name="packagedetail[0][PrimaryPackaging]">
                                                    </td>
                                                    <td><input type="text" name="packagedetail[0][Material]"></td>
                                                    <td><input type="number" name="packagedetail[0][PackSize]"></td>
                                                    <td><input type="text" name="packagedetail[0][SelfLife]"></td>
                                                    <td><input type="text" name="packagedetail[0][StorageCondition]">
                                                    </td>
                                                    <td><input type="text" name="packagedetail[0][SecondaryPackaging]">
                                                    </td>
                                                    <td><input type="text" name="packagedetail[0][Remarks]"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                {{-- 
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Description"> Description<span class="text-danger">*</span>
                                    <p>255 characters remaining</p>
                                    <textarea placeholder="" name="manufacturing_description"></textarea>
                            </div>
                        </div>
                        </div> --}}







                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Actions">Manufacturing Site<span
                                                    class="text-danger"></span></label>
                                            <textarea placeholder="" name="manufacturing_description"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">

                                            <label for="RLS Record Number"><b>Dossier Parts</b></label>

                                            <input type="text" name="dossier_number" value="">


                                        </div>
                                    </div>




                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="Responsible Department">Related Dossier Document</label>
                                            <select name="dossier_departments">
                                                <option value="">Enter Your Selection Here</option>
                                                <option value="person1">1</option>
                                                <option value="person2">2</option>
                                                <option value="person3">3</option>


                                            </select>
                                        </div>
                                    </div>



                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description"> Description<span class="text-danger">*</span>
                                                <p>255 characters remaining</p>
                                                <textarea placeholder="" name="manufacturing_description"></textarea>
                                        </div>
                                    </div>
                                </div>


                                {{-- <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Actions">Description<span class="text-danger"></span></label>
                                    <textarea placeholder="" name="description"></textarea>
                                </div>
                            </div> --}}




                                <p class="text-primary">Important Dates</p>
                                <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Planned Submission Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="planned_submission_date"
                                                value="{{ Helpers::getdateFormat($data->planned_submission_date) }}"
                                                readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="planned_submission_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                class="hide-input"
                                                oninput="handleDateInput(this, 'planned_submission_date')" />
                                        </div>
                                    </div>
                                </div>


                                {{-- <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Planned Submission Date</label>
                                    <div class="calenderauditee">                                     
                                        <input type="text"  id="planned_submission_date"  value="{{  Helpers::getdateFormat($data->planned_submission_date) }}" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="planned_submission_date"    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                        class="hide-input"
                                        oninput="handleDateInput(this,'planned_submission_date')"/>
                                    </div>
                                </div>
                            </div> --}}

                                {{-- <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Planned Submission Date <span class="text-danger"></span></label>

                                    <div class="calenderauditee">
                                        <input type="text" id="due_date"  placeholder="DD-MMM-YYYY" value="" />
                                        <input type="date" name="planned_submission_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hidden-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>



 --}}


                                <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Actual Submission Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="actual_submission_date"
                                                value="{{ Helpers::getdateFormat($data->actual_submission_date) }}"
                                                readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="actual_submission_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                class="hide-input"
                                                oninput="handleDateInput(this, 'actual_submission_date')" />
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Actual Approval Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="actual_approval_date"
                                                value="{{ Helpers::getdateFormat($data->actual_approval_date) }}" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="actual_approval_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                class="hide-input"
                                                oninput="handleDateInput(this, 'actual_approval_date')" />
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Actual Approval Date <span class="text-danger"></span></label>

                                    <div class="calenderauditee">
                                        <input type="text" id="due_date"  placeholder="DD-MMM-YYYY" value="" />
                                        <input type="date" name="actual_approval_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hidden-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div> --}}

                                <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Actual Rejection Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="actual_rejection_date"
                                                value="{{ Helpers::getdateFormat($data->actual_rejection_date) }}"
                                                readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="actual_rejection_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                class="hide-input"
                                                oninput="handleDateInput(this, 'actual_rejection_date')" />
                                        </div>
                                    </div>
                                </div>





                                {{-- <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Actual Rejection Date <span class="text-danger"></span></label>

                                    <div class="calenderauditee">
                                        <input type="text" id="due_date"  placeholder="DD-MMM-YYYY" value="" />
                                        <input type="date" name="actual_rejection_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hidden-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div> --}}


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Responsible Department">Renewal Rule</label>
                                        <select name="renewal_departments">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="p1">1</option>
                                            <option value="p2">2</option>
                                            <option value="p3">3</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Next Renewal Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="next_renewal_date"
                                                value="{{ Helpers::getdateFormat($data->next_renewal_date) }}" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="next_renewal_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                class="hide-input" oninput="handleDateInput(this, 'next_renewal_date')" />
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Next Renewal Date <span class="text-danger"></span></label>

                                    <div class="calenderauditee">
                                        <input type="text" id="due_date"  placeholder="DD-MMM-YYYY" value="" />
                                        <input type="date" name="next_renewal_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hidden-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div> --}}


                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>

                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>


                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Actual_Amount ">Submitted by :</label>
                                        <div class="static"></div>

                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">

                                        <label for="Division Code"><b>Submitted on :</b></label>
                                        <div class="date"></div>




                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Actual_Amount ">Approved by :</label>
                                        <div class="static"></div>

                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">

                                        <label for="Division Code"><b>Approved on :</b></label>
                                        <div class="date"></div>




                                    </div>
                                </div>



                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>

                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                </div>

                

        </div>
        </form>

    </div>
    </div>

    <style>
        #step-form>div {
            display: none
        }

        #step-form>div:nth-child(1) {
            display: block;
        }
    </style>

    <script>
        VirtualSelect.init({
            ele: '#related_records, #hod'
        });

        function openCity(evt, cityName) {
            var i, cctabcontent, cctablinks;
            cctabcontent = document.getElementsByClassName("cctabcontent");
            for (i = 0; i < cctabcontent.length; i++) {
                cctabcontent[i].style.display = "none";
            }
            cctablinks = document.getElementsByClassName("cctablinks");
            for (i = 0; i < cctablinks.length; i++) {
                cctablinks[i].className = cctablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";

            // Find the index of the clicked tab button
            const index = Array.from(cctablinks).findIndex(button => button === evt.currentTarget);

            // Update the currentStep to the index of the clicked tab
            currentStep = index;
        }

        const saveButtons = document.querySelectorAll(".saveButton");
        const nextButtons = document.querySelectorAll(".nextButton");
        const form = document.getElementById("step-form");
        const stepButtons = document.querySelectorAll(".cctablinks");
        const steps = document.querySelectorAll(".cctabcontent");
        let currentStep = 0;

        function nextStep() {
            // Check if there is a next step
            if (currentStep < steps.length - 1) {
                // Hide current step
                steps[currentStep].style.display = "none";

                // Show next step
                steps[currentStep + 1].style.display = "block";

                // Add active class to next button
                stepButtons[currentStep + 1].classList.add("active");

                // Remove active class from current button
                stepButtons[currentStep].classList.remove("active");

                // Update current step
                currentStep++;
            }
        }

        function previousStep() {
            // Check if there is a previous step
            if (currentStep > 0) {
                // Hide current step
                steps[currentStep].style.display = "none";

                // Show previous step
                steps[currentStep - 1].style.display = "block";

                // Add active class to previous button
                stepButtons[currentStep - 1].classList.add("active");

                // Remove active class from current button
                stepButtons[currentStep].classList.remove("active");

                // Update current step
                currentStep--;
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#Witness_details').click(function(e) {
                function generateTableRow(serialNumber) {

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="WitnessName[]"></td>' +
                        '<td><input type="text" name="WitnessType[]"></td>' +
                        '<td><input type="text" name="ItemDescriptions[]"></td>' +
                        '<td><input type="text" name="Comments[]"></td>' +
                        '<td><input type="text" name="Remarks[]"></td>' +
                        '</tr>';

                    return html;
                }

                var tableBody = $('#Witness_details_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#MaterialsReleased').click(function(e) {
                function generateTableRow(serialNumber) {

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="[]"></td>' +
                        '<td><input type="text" name="[]"></td>' +
                        '<td><input type="text" name="[]"></td>' +
                        '<td><input type="text" name="[]"></td>' +
                        '<td><input type="text" name="[]"></td>' +
                        '</tr>';

                    return html;
                }

                var tableBody = $('#MaterialsReleased-field-table tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#RootCause').click(function(e) {
                function generateTableRow(serialNumber) {

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="[]"></td>' +
                        '<td><input type="text" name="[]"></td>' +
                        '<td><input type="text" name="[]"></td>' +
                        '<td><input type="text" name="[]"></td>' +
                        '<td><input type="text" name="[]"></td>' +
                        '</tr>';

                    return html;
                }

                var tableBody = $('#RootCause-field-instruction-modal tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    <script>
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get today's date
            var today = new Date();

            // Calculate the date 30 days from today
            var dueDate = new Date();
            dueDate.setDate(today.getDate() + 30);

            // Format the date to YYYY-MM-DD
            var day = String(dueDate.getDate()).padStart(2, '0');
            var month = String(dueDate.getMonth() + 1).padStart(2, '0'); // January is 0!
            var year = dueDate.getFullYear();

            var formattedDate = year + '-' + month + '-' + day;

            // Set the value of the date input field
            document.getElementById('due_date_gi').value = formattedDate;
        });

        function handleDateInput(input, hiddenId) {
            var hiddenInput = document.getElementById(hiddenId);
            hiddenInput.value = input.value;
        }
    </script>
@endsection
