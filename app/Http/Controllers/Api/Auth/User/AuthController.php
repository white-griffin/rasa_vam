<?php

namespace App\Http\Controllers\Api\Auth\User;

use App\Constants\Constant;
use App\Enums\ActivityStatus;
use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Ipe\Sdk\Facades\SmsIr;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'mobile' => 'required|numeric|min:7',
        ],[
            'mobile.required' => 'شماره تماس را وارد کنید',
            'mobile.min' => 'شماره تماس را کامل وارد کنید',
            'mobile.numeric' => 'فرمت شماره تلفن صحیح نیست ',
        ]);

        try {
            $user = User::firstOrCreate(
                [
                    'mobile' => request('mobile')
                ],[
                    'mobile' => request('mobile')
                ]
            );

            $otp_code = mt_rand(1000, 9999);
            $user->update(['otp_code' => $otp_code]);
            $user->tokens()->delete();
            $sendOtp = $this->sendOtp($user->mobile, $otp_code);
            if ($sendOtp['code'] != 1){

                return ApiResponse::Fail(501,'خطا در ارسال کد'
                    ,$sendOtp);
            }

            return ApiResponse::Success('رمز ارسال شد');

        }catch (\Exception $exception){
            return ApiResponse::Fail(500,'خطا در برقراری ارتباط');
        }

    }

    public function checkCode(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
            'otp_code' => 'required',
        ],[
            'otp_code.required' => 'وارد کردن کد تایید الزامی است ',
        ]);

        try {

            $user = User::whereMobile(request('mobile'))->first();

            if ($user->otp_code == request('otp_code')){
                $user->activity_status = ActivityStatus::ACTIVE->value;
                $user->save();
                $user->tokens()->delete();

                return ApiResponse::Success('با موفقیت وارد شدید',
                    [
                        'token' => $user->createToken("API TOKEN")->plainTextToken,
                    ]);


            }else{
                return ApiResponse::Fail(403,'کد تایید صحیح نیست');

            }
        }catch (\Exception $exception){
            return ApiResponse::Fail(500,$exception->getMessage());
        }
    }

    public function logOut()
    {
        try {
            request()->user()->tokens()->delete();
            return ApiResponse::Success('با موفقیت خارج شدید');

        } catch (Exception $e) {
            return ApiResponse::Fail(500,$e->getMessage());
        }
    }

    private function sendOtp($mobile,$otpCode)
    {

        try {
            $templateId = 123456; // شناسه الگو
            $parameters = [
                [
                    "name" => "Code",
                    "value" => $otpCode
                ]
            ];

            $response = SmsIr::verifySend($mobile, $templateId, $parameters);

            return [
                'code' => $response->status,
                'message' => $response->message,
            ];
        }catch (\Exception $exception){
            return [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ];
        }
    }
}
