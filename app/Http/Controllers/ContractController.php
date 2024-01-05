<?php

namespace App\Http\Controllers;

use App\Models\AFile;
use App\Models\Contact;
use App\Models\Contract;
use App\Models\ContractContact;
use App\Models\Listing;
use App\Models\TagnameObject;
use App\Services\HistoryService;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Contract::all();
        return view('contract.list', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contacts = Contact::all();
        $listings = Listing::all();
        return view('contract.create', compact('contacts', 'listings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token', 'purchasers', 'conditions', 'comment');

        // if ($request->comment) {
        //     $data['comment'] = $request->comment . " " . date('Y-m-d H:i:s') . " " . auth()->user()->name;
        // }

        $contract = Contract::create($data);

        if ($request->purchasers) {
            foreach ($request->purchasers as $purchaser) {
                ContractContact::create([
                    'contract_id' => $contract->id,
                    'contact_id' => $purchaser,
                ]);
            }
        }
        if ($request->conditions) {
            foreach (json_decode($request->conditions) as $condition) {
                $condition_key = str_replace(" ", "_", $condition->value);
                TagnameObject::create([
                    'tag_name' => $condition->value,
                    'target_id' => $contract->id,
                    'type' => 'contract_condition',
                    'tag_date' => $request[$condition_key]
                ]);
            }
        }

        if ($request->comment) {
            foreach ($request->comment as $comment) {
                if ($comment) {
                    TagnameObject::create([
                        'tag_name' => $comment,
                        'target_id' => $contract->id,
                        'type' => 'contract_comment'
                    ]);
                }
            }
        }

        $documents = $request->file('documents');
        if ($documents) {
            foreach ($documents as $file) {
                $attached_path = $file->store('files', 'images');
                $file_name = $file->getClientOriginalName();
                $file_ext = $file->extension();
                AFile::create([
                    'path' => $attached_path,
                    'file_name' => $file_name,
                    'file_ext' => $file_ext,
                    'target_id' => $contract->id,
                    'type' => 'contract_document',
                ]);
            }
        }

        $history = [
            'user_id' => auth()->user()->id,
            'type' => 'created',
            'source' => 'contract',
            'source_id' => $contract->id,
            // 'note' => $contact->first_name . " " . $contact->last_name,
        ];

        HistoryService::addRecord($history);
        return redirect()->route('contract.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        $contacts = Contact::all();
        $listings = Listing::all();
        return view('contract.edit', compact('contract', 'contacts', 'listings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        $data = $request->except('_token', 'purchasers', 'conditions', 'comment');

        // if ($request->comment) {
        //     $data['comment'] = $request->comment . " " . date('Y-m-d H:i:s') . " " . auth()->user()->name;
        // }
        $contract->update($data);

        ContractContact::where([
            'contract_id' => $contract->id,
        ])->delete();

        if ($request->purchasers) {
            foreach ($request->purchasers as $purchaser) {
                ContractContact::create([
                    'contract_id' => $contract->id,
                    'contact_id' => $purchaser,
                ]);
            }
        }

        TagnameObject::where([
            'target_id' => $contract->id,
            'type' => 'contract_condition'
        ])->delete();
        if ($request->conditions) {
            foreach (json_decode($request->conditions) as $condition) {
                $condition_key = str_replace(" ", "_", $condition->value);
                TagnameObject::create([
                    'tag_name' => $condition->value,
                    'target_id' => $contract->id,
                    'type' => 'contract_condition',
                    'tag_date' => $request[$condition_key]
                ]);
            }
        }

        TagnameObject::where([
            'target_id' => $contract->id,
            'type' => 'contract_comment'
        ])->delete();
        if ($request->comment) {
            foreach ($request->comment as $comment) {
                if ($comment) {
                    TagnameObject::create([
                        'tag_name' => $comment,
                        'target_id' => $contract->id,
                        'type' => 'contract_comment'
                    ]);
                }
            }
        }

        $documents = $request->file('documents');
        AFile::where([
            'target_id' => $contract->id,
            'type' => 'contract_document',
        ])->delete();
        if ($documents) {
            foreach ($documents as $file) {
                $attached_path = $file->store('files', 'images');
                $file_name = $file->getClientOriginalName();
                $file_ext = $file->extension();
                AFile::create([
                    'path' => $attached_path,
                    'file_name' => $file_name,
                    'file_ext' => $file_ext,
                    'target_id' => $contract->id,
                    'type' => 'contract_document',
                ]);
            }
        }

        $history = [
            'user_id' => auth()->user()->id,
            'type' => 'edited',
            'source' => 'contract',
            'source_id' => $contract->id,
            'note' => "ID: $contract->id"
        ];

        HistoryService::addRecord($history);

        return redirect()->route('contract.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        $contract->delete();
        $history = [
            'user_id' => auth()->user()->id,
            'type' => 'deleted',
            'source' => 'contract',
            'source_id' => $contract->id,
            // 'note' => $contact->first_name . " " . $contact->last_name,
        ];

        HistoryService::addRecord($history);

        return back();
    }

    public function files($id)
    {
        $contract = Contract::findOrFail($id);
        return view('contract.files', compact('contract'));
    }
}
