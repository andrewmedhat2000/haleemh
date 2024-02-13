<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setter;
use App\Models\Nursery;
use App\Models\Image;
use App\Models\SetterCertificates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Routing\Annotation\Route;

class CertificateController extends Controller
{

    protected $mainUrl = 'dashboard.certificates.';
    protected $exceptionUrl = 'home';


    public function index(Request $request)
    {
        return redirect()->route( 'dashboard.setters.index')->with('success', [
            'type' => 'success',
        ]);

    }

    public function create(Request $request)
    {
        $setter=$request->setter;

        return view('certificates.create',compact('setter'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $data=$request->all();

        $certificate = SetterCertificates::create($data);

        return redirect()->route('dashboard.certificate.index')->with('success', [
            'type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SetterCertificates $certificate)
    {

        $data['resource'] = $certificate;
        return view($this->mainUrl . 'show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $certificate = SetterCertificates::where('id',$id)->first();
        return view('certificates.edit', compact('certificate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $certificate = SetterCertificates::find($id);
        $certificate->update($data);
        return redirect()->route( 'dashboard.certificate.index')->with('success', [
            'type' => 'success',
        ]);
    }

    public function destroy($id, Request $request)
    {
        $certificate = SetterCertificates::find($id);

        $certificate->delete();

        return redirect()->route( 'dashboard.certificate.index')->with('success', [
            'type' => 'success',
        ]);
     }
}
