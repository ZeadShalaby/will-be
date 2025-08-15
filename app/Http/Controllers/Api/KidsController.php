<?php

namespace App\Http\Controllers\Api;

use App\Models\Kids;
use App\Models\Tests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKidRequest;

class KidsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', );
    }

    /**
     * Store a newly created kid in storage.
     *
     * @param  \App\Http\Requests\StoreKidRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(StoreKidRequest $request)
    {
        try {
            // =====================================================
            // 1️⃣ التحقق من البيانات وتحويل تاريخ الميلاد
            // =====================================================
            $validatedData = $request->validated();
            $validatedData['user_id'] = auth()->id();
            $validatedData['birth_date'] = \Carbon\Carbon::createFromFormat(
                'd-m-Y',
                $validatedData['birth_date']
            )->format('Y-m-d');

            // =====================================================
            // 2️⃣ استخراج الملفات وحفظها في متغيرات منفصلة
            // =====================================================
            $childPhotos = $validatedData['child_photos'] ?? [];
            $motherId = $validatedData['mother_id'] ?? null;
            $fatherId = $validatedData['father_id'] ?? null;
            $birthCert = $validatedData['birth_certificate'] ?? null;

            $cbc = $validatedData['cbc'] ?? null;
            $urin = $validatedData['urin'] ?? null;
            $stool = $validatedData['stool'] ?? null;

            // =====================================================
            // 3️⃣ إزالة الملفات من validatedData قبل الحفظ
            // =====================================================
            unset(
                $validatedData['child_photos'],
                $validatedData['mother_id'],
                $validatedData['father_id'],
                $validatedData['birth_certificate'],
                $validatedData['cbc'],
                $validatedData['urin'],
                $validatedData['stool']
            );

            // =====================================================
            // 4️⃣ إنشاء سجل الطفل
            // =====================================================
            $kid = Kids::create($validatedData);

            // =====================================================
            // 5️⃣ حفظ ملفات الطفل العامة
            // =====================================================
            $this->saveKidFiles($kid, $childPhotos, $motherId, $fatherId, $birthCert);

            // =====================================================
            // 6️⃣ إنشاء سجل التحاليل وحفظ الملفات
            // =====================================================
            $tests = Tests::create(['kid_id' => $kid->id]);
            $this->saveTestFiles($tests, $cbc, $urin, $stool);

            // =====================================================
            // 7️⃣ الرد النهائي
            // =====================================================
            return response()->json([
                'status' => true,
                'data' => $kid->load('media', 'tests.media'),
                'msg' => 'تم تسجيل الطفل والتحاليل بنجاح'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('apiValidation.Something went wrong'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * حفظ ملفات الطفل العامة
     */
    protected function saveKidFiles($kid, $childPhotos, $motherId, $fatherId, $birthCert)
    {
        $generalFiles = [
            'child_photos' => $childPhotos,
            'mother_id' => $motherId,
            'father_id' => $fatherId,
            'birth_certificate' => $birthCert,
        ];

        foreach ($generalFiles as $type => $files) {
            $files = is_array($files) ? $files : [$files];
            foreach ($files as $file) {
                if ($file) {
                    $path = $file->store("kids/$type", 'public');
                    $kid->media()->create([
                        'media_type' => $type,
                        'media' => $path,
                    ]);
                }
            }
        }
    }

    /**
     * حفظ ملفات التحاليل
     */
    protected function saveTestFiles($tests, $cbc, $urin, $stool)
    {
        $testFiles = [
            'cbc' => $cbc,
            'urin' => $urin,
            'stool' => $stool,
        ];

        foreach ($testFiles as $type => $file) {
            if ($file) {
                $path = $file->store("tests/$type", 'public');
                $tests->media()->create([
                    'media_type' => $type,
                    'media' => $path,
                ]);
            }
        }
    }


}
