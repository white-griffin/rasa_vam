<?php

namespace App\Http\Controllers\Api;

use App\Enums\GenderType;
use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoanAdsResource;
use App\Http\Resources\UserProfileResource;
use App\Models\LoanAd;
use App\Services\MediaService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function getProfile()
    {
        try {
            $user = auth()->user();
            return ApiResponse::Success('عملیات موفق', UserProfileResource::make($user->profile));
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return ApiResponse::Fail(Response::HTTP_INTERNAL_SERVER_ERROR, 'خطا در عملیات');
        }
    }

    public function updateProfile()
    {
        $user = auth()->user();
        $profile = $user->profile;
        $data = $this->profileData($profile);

        DB::beginTransaction();
        try {
            $profile->update($data);
            $user->update($data);
            DB::commit();

            return ApiResponse::Success('عملیات موفق');
        } catch (\Exception $exception) {
            DB::rollBack();
            return ApiResponse::Fail(Response::HTTP_INTERNAL_SERVER_ERROR, 'خطا در عملیات');
        }
    }

    private function profileData($profile)
    {
        $media = app(MediaService::class);
        $data = request()->validate([
            'first_name' => ['nullable', 'string', 'max:50'],
            'last_name' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($profile->user->id)],
            'birth_date' => ['nullable', 'date'],
            'national_code' => ['nullable', 'digits:10', Rule::unique('user_profiles', 'national_code')->ignore($profile->id)],
            'gender' => ['nullable', Rule::in(array_map(fn (GenderType $type) => $type->value, GenderType::cases()))],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'address' => ['nullable'],
            'province_id' => ['nullable'],
            'city_id' => ['nullable'],

        ], [
            'email.email' => 'فرمت ایمیل صحیح نیست',
            'email.unique' => 'این ایمیل قبلا ثبت شده است',
            'national_code.digits' => 'کد ملی باید ۱۰ رقم باشد',
            'national_code.unique' => 'این کد ملی قبلا ثبت شده است',
            'gender.in' => 'جنسیت انتخاب شده معتبر نیست',
            'avatar.image' => 'فایل آواتار باید تصویر باشد',
            'avatar.mimes' => 'فرمت تصویر آواتار معتبر نیست',
            'avatar.max' => 'حجم تصویر آواتار نباید بیشتر از ۲ مگابایت باشد',
        ]);

        $data = array_filter(
            $data,
            fn($value) => !is_null($value)
        );

        if (request()->hasFile('avatar')) {
            $data['avatar'] = $media->replace(
                $profile->avatar,
                request()->file('avatar'),
                'users/avatars'
            );
        }
        return $data;
    }

    public function loans()
    {
        try {
            $loans = LoanAdsResource::collection(
              auth()->user()->loans
            );
            return ApiResponse::Success('عملیات موفق',$loans);
        }catch (\Exception $exception){
            return ApiResponse::Fail(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }
}
