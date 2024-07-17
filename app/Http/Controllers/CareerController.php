<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SoapClient;
use Illuminate\Support\Facades\Log;
use App\Models\Career;
use App\Models\User;

class CareerController extends Controller
{
    public function showForm()
    {
        return view('career.form');
    }
    public function getApp()
    {
        $applications = Career::all();
        foreach ($applications as $application) {
            $application->education_details = json_decode($application->education_details, true);
            $application->work_details = json_decode($application->work_details, true);
            $application->reference_details = json_decode($application->reference_details, true);
            $application->language_details = json_decode($application->language_details, true);
            $application->experience_details = json_decode($application->experience_details, true);
        }
        return view('career.list', compact('applications'));
    }

    public function verifyTCKimlik(Request $request)
    {
        $request->validate([
            'tckimlik_no' => 'required|numeric|digits:11',
            'ad' => 'required|string',
            'soyad' => 'required|string',
            'dogum_yili' => 'required|numeric|digits:4',
        ]);

        $tckimlikNo = $request->input('tckimlik_no');
        $ad = $request->input('ad');
        $soyad = $request->input('soyad');
        $dogumYili = $request->input('dogum_yili');

        try {
            $client = new SoapClient('https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx?WSDL');

            $response = $client->TCKimlikNoDogrula([
                'TCKimlikNo' => $tckimlikNo,
                'Ad' => $ad,
                'Soyad' => $soyad,
                'DogumYili' => $dogumYili,
            ]);

            $result = $response->TCKimlikNoDogrulaResult;

            return response()->json([
                'success' => $result,
                'data' => $result ? compact('tckimlikNo', 'ad', 'soyad', 'dogumYili') : [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bir hata oluştu: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function submitCareerForm(Request $request)
    {
        try {
            $request->validate([
                'tckimlik_no' => 'required|numeric|digits:11',
                'ad' => 'required|string',
                'soyad' => 'required|string',
                'dogum_yili' => 'required|numeric|digits:4',
                'email' => 'required|email',
                'phone' => 'required|string',
                'gender' => 'required|string',
                'birth_place' => 'required|string',
                'blood_type' => 'required|string',
                'social_media' => 'required|string',
                'address' => 'required|string',
                'position' => 'required|string',
                'marital_status' => 'required|string',
                'driving_license' => 'required|string',
                'note' => 'nullable|string',
                'education.*.type' => 'required|string',
                'education.*.school' => 'required|string',
                'education.*.department' => 'required|string',
                'education.*.graduation_year' => 'required|string',
                'work.*.name' => 'nullable|string',
                'work.*.phone' => 'nullable|string',
                'work.*.department' => 'nullable|string',
                'work.*.position' => 'nullable|string',
                'work.*.start_date' => 'nullable|string',
                'work.*.finish_date' => 'nullable|string',
                'reference.*.type' => 'nullable|string',
                'reference.*.name' => 'nullable|string',
                'reference.*.phone' => 'nullable|string',
                'language.*.type' => 'nullable|string',
                'language.*.level' => 'nullable|string',
                'language.*.experience' => 'nullable|string',
                'experience.*.type' => 'nullable|string',
                'experience.*.level' => 'nullable|string',
                'experience.*.year' => 'nullable|string',
                'criminal_record' => 'required|string',
                'disability_situation' => 'required|string',
                'travel_ban' => 'required|string',
                'smoking' => 'required|string',
            ]);

            // Tüm form verilerini al
            $formData = $request->all();

            // education alanını JSON formatına dönüştür
            if (isset($formData['education'])) {
                $formData['education_details'] = json_encode($formData['education']);
                unset($formData['education']);
            }
            // work alanını JSON formatına dönüştür
            if (isset($formData['work'])) {
                $formData['work_details'] = json_encode($formData['work']);
                unset($formData['work']);
            }
            // reference alanını JSON formatına dönüştür
            if (isset($formData['reference'])) {
                $formData['reference_details'] = json_encode($formData['reference']);
                unset($formData['reference']);
            }
            // language alanını JSON formatına dönüştür
            if (isset($formData['language'])) {
                $formData['language_details'] = json_encode($formData['language']);
                unset($formData['language']);
            }
            // experience alanını JSON formatına dönüştür
            if (isset($formData['experience'])) {
                $formData['experience_details'] = json_encode($formData['experience']);
                unset($formData['experience']);
            }

            // Veritabanına kaydet
            $application = Career::create($formData);

            return response()->json([
                'success' => true,
                'message' => 'Başvuru tamamlandı.',
                'application_id' => $application->id,
            ]);
        } catch (\Exception $e) {
            Log::error('Form submission error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Bir hata oluştu: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function appointPersonal(Request $request, $careerId)
    {
        $career = Career::findOrFail($careerId);
        $name = $career->ad . ' ' . $career->soyad;
    
        $user = new User();
        $user->name = $name;
        $user->email = $career->email;
        $user->phone = $career->phone;
        $user->position = $request->input('position'); // Pozisyon seçimini al
        $user->password = bcrypt('123');
    
        $user->role = 'personal';
    
        $user->save();
        $career->delete();
    
        return redirect()->back()->with('success', 'Kullanıcıya personal rolü başarıyla atanmıştır.');
    }
    

    public function deleteCareer($careerId)
    {
        $career = Career::findOrFail($careerId);
        $career->delete();

        return redirect()->back()->with('success', 'Başvuru başarıyla silindi.');
    }
}
