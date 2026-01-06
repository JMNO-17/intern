<?php

namespace App\Helpers;

use Carbon\Carbon;
use File;

class common
{
    /**
     * Model Common find method
     */
    public static function find($type, $type_id)
    {
        return $type::find($type_id);
    }

    /**
     * set name mm as name en
     *
     * @param  Illuminate\Http\Request  $request
     */
    public static function setNameMM($request)
    {
        if (empty($request['name_mm'])) {
            $request['name_mm'] = $request['name_en'];
        }

        return $request;
    }

    /**
     * set name mm as name en
     *
     * @param  Illuminate\Http\Request  $request
     */
    public static function getImageSrc($path)
    {
        $src = '/default_image.png';
        if ($path && str_contains($path, '/')) {
            if (file_exists(explode('/', $path, 2)[1])) {
                $src = $path;
            }
        }

        return $src;
    }

    /**
     * @param  UploadedFile  $file
     * @param  string  $path
     * @return string
     */
    public static function storeImage($path, $file)
    {
        if (! file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $extension = $file->getClientOriginalExtension(); // getting image extension
        $name = Carbon::now()->format('Ymd').uniqid().'.'.$extension;

        $file->move($path, $name);

        return '/'.$path.'/'.$name;
    }

    /**
     * @param  UploadedFile  $file
     * @param  string  $path
     * @return string
     */
    public static function storeMedia($path, $file)
    {
        // $path = storage_path('uploads/');
        if (! file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $extension = $file->getClientOriginalExtension();
        $name = Carbon::now()->format('Ymd').uniqid().'.'.$extension;
        $file->move($path, $name);

        return response()->json([
            'name' => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    /**
     * @param  UploadedFile  $file
     * @param  string  $path
     * @return string
     */
    public static function removeMedia($model, $model_id, $type, $fileName)
    {
        // dd($model::IMAGE_PATH.$type.'/'.$fileName, File::exists($model::IMAGE_PATH.$type.'/'.$fileName));
        if (File::exists($model::IMAGE_PATH.$type.'/'.$fileName)) {
            File::delete($model::IMAGE_PATH.$type.'/'.$fileName);
        }

        $modelObject = $model::find($model_id);
        // '/user-avatar.png'
        $modelObject->$type = null;
        $modelObject->save();

        return response()->json(['message' => 'success']);
    }

    /**
     * @param  UploadedFile  $file
     * @param  string  $path
     * @return string
     */
    public static function removeMediaTwoModels($parent_model, $parent_model_id, $type, $child_model, $child_model_column_name, $fileName)
    {
        if (File::exists($parent_model::IMAGE_PATH.$type.'/'.$fileName)) {
            File::delete($parent_model::IMAGE_PATH.$type.'/'.$fileName);
        }

        $child_model::where($child_model_column_name, $parent_model_id)->where('path', '/'.$parent_model::IMAGE_PATH.$type.'/'.$fileName)->forceDelete();

        return response()->json(['message' => 'success']);
    }

    public static function getMorph($model, $type, $type_id)
    {
        return $model::where('type', $type)->where('type_id', $type_id)->latest()->get();
    }

    // countries for contact us page of select option
    public static function getCountries()
    {
        $countries = [
            ['title' => 'Afghanistan'],
            ['title' => 'Albania'],
            ['title' => 'Algeria'],
            ['title' => 'Andorra'],
            ['title' => 'Angola'],
            ['title' => 'Antigua and Barbuda'],
            ['title' => 'Argentina'],
            ['title' => 'Armenia'],
            ['title' => 'Australia'],
            ['title' => 'Austria'],
            ['title' => 'Azerbaijan'],
            ['title' => 'Bahamas'],
            ['title' => 'Bahrain'],
            ['title' => 'Bangladesh'],
            ['title' => 'Barbados'],
            ['title' => 'Belarus'],
            ['title' => 'Belgium'],
            ['title' => 'Belize'],
            ['title' => 'Benin'],
            ['title' => 'Bhutan'],
            ['title' => 'Bolivia'],
            ['title' => 'Bosnia and Herzegovina'],
            ['title' => 'Botswana'],
            ['title' => 'Brazil'],
            ['title' => 'Brunei'],
            ['title' => 'Bulgaria'],
            ['title' => 'Burkina Faso'],
            ['title' => 'Burundi'],
            ['title' => 'Cabo Verde'],
            ['title' => 'Cambodia'],
            ['title' => 'Cameroon'],
            ['title' => 'Canada'],
            ['title' => 'Central African Republic'],
            ['title' => 'Chad'],
            ['title' => 'Chile'],
            ['title' => 'China'],
            ['title' => 'Colombia'],
            ['title' => 'Comoros'],
            ['title' => 'Congo'],
            ['title' => 'Costa Rica'],
            ['title' => 'Croatia'],
            ['title' => 'Cuba'],
            ['title' => 'Cyprus'],
            ['title' => 'Czech Republic'],
            ['title' => 'Denmark'],
            ['title' => 'Djibouti'],
            ['title' => 'Dominica'],
            ['title' => 'Dominican Republic'],
            ['title' => 'Ecuador'],
            ['title' => 'Egypt'],
            ['title' => 'El Salvador'],
            ['title' => 'Equatorial Guinea'],
            ['title' => 'Eritrea'],
            ['title' => 'Estonia'],
            ['title' => 'Eswatini'],
            ['title' => 'Ethiopia'],
            ['title' => 'Fiji'],
            ['title' => 'Finland'],
            ['title' => 'France'],
            ['title' => 'Gabon'],
            ['title' => 'Gambia'],
            ['title' => 'Georgia'],
            ['title' => 'Germany'],
            ['title' => 'Ghana'],
            ['title' => 'Greece'],
            ['title' => 'Grenada'],
            ['title' => 'Guatemala'],
            ['title' => 'Guinea'],
            ['title' => 'Guinea-Bissau'],
            ['title' => 'Guyana'],
            ['title' => 'Haiti'],
            ['title' => 'Honduras'],
            ['title' => 'Hungary'],
            ['title' => 'Iceland'],
            ['title' => 'India'],
            ['title' => 'Indonesia'],
            ['title' => 'Iran'],
            ['title' => 'Iraq'],
            ['title' => 'Ireland'],
            ['title' => 'Israel'],
            ['title' => 'Italy'],
            ['title' => 'Jamaica'],
            ['title' => 'Japan'],
            ['title' => 'Jordan'],
            ['title' => 'Kazakhstan'],
            ['title' => 'Kenya'],
            ['title' => 'Kiribati'],
            ['title' => 'Kuwait'],
            ['title' => 'Kyrgyzstan'],
            ['title' => 'Laos'],
            ['title' => 'Latvia'],
            ['title' => 'Lebanon'],
            ['title' => 'Lesotho'],
            ['title' => 'Liberia'],
            ['title' => 'Libya'],
            ['title' => 'Liechtenstein'],
            ['title' => 'Lithuania'],
            ['title' => 'Luxembourg'],
            ['title' => 'Madagascar'],
            ['title' => 'Malawi'],
            ['title' => 'Malaysia'],
            ['title' => 'Maldives'],
            ['title' => 'Mali'],
            ['title' => 'Malta'],
            ['title' => 'Marshall Islands'],
            ['title' => 'Mauritania'],
            ['title' => 'Mauritius'],
            ['title' => 'Mexico'],
            ['title' => 'Micronesia'],
            ['title' => 'Moldova'],
            ['title' => 'Monaco'],
            ['title' => 'Mongolia'],
            ['title' => 'Montenegro'],
            ['title' => 'Morocco'],
            ['title' => 'Mozambique'],
            ['title' => 'Myanmar'],
            ['title' => 'Namibia'],
            ['title' => 'Nauru'],
            ['title' => 'Nepal'],
            ['title' => 'Netherlands'],
            ['title' => 'New Zealand'],
            ['title' => 'Nicaragua'],
            ['title' => 'Niger'],
            ['title' => 'Nigeria'],
            ['title' => 'North Korea'],
            ['title' => 'North Macedonia'],
            ['title' => 'Norway'],
            ['title' => 'Oman'],
            ['title' => 'Pakistan'],
            ['title' => 'Palau'],
            ['title' => 'Panama'],
            ['title' => 'Papua New Guinea'],
            ['title' => 'Paraguay'],
            ['title' => 'Peru'],
            ['title' => 'Philippines'],
            ['title' => 'Poland'],
            ['title' => 'Portugal'],
            ['title' => 'Qatar'],
            ['title' => 'Romania'],
            ['title' => 'Russia'],
            ['title' => 'Rwanda'],
            ['title' => 'Saint Kitts and Nevis'],
            ['title' => 'Saint Lucia'],
            ['title' => 'Saint Vincent and the Grenadines'],
            ['title' => 'Samoa'],
            ['title' => 'San Marino'],
            ['title' => 'Sao Tome and Principe'],
            ['title' => 'Saudi Arabia'],
            ['title' => 'Senegal'],
            ['title' => 'Serbia'],
            ['title' => 'Seychelles'],
            ['title' => 'Sierra Leone'],
            ['title' => 'Singapore'],
            ['title' => 'Slovakia'],
            ['title' => 'Slovenia'],
            ['title' => 'Solomon Islands'],
            ['title' => 'Somalia'],
            ['title' => 'South Africa'],
            ['title' => 'South Korea'],
            ['title' => 'South Sudan'],
            ['title' => 'Spain'],
            ['title' => 'Sri Lanka'],
            ['title' => 'Sudan'],
            ['title' => 'Suriname'],
            ['title' => 'Sweden'],
            ['title' => 'Switzerland'],
            ['title' => 'Syria'],
            ['title' => 'Tajikistan'],
            ['title' => 'Tanzania'],
            ['title' => 'Thailand'],
            ['title' => 'Timor-Leste'],
            ['title' => 'Togo'],
            ['title' => 'Tonga'],
            ['title' => 'Trinidad and Tobago'],
            ['title' => 'Tunisia'],
            ['title' => 'Turkey'],
            ['title' => 'Turkmenistan'],
            ['title' => 'Tuvalu'],
            ['title' => 'Uganda'],
            ['title' => 'Ukraine'],
            ['title' => 'United Arab Emirates'],
            ['title' => 'United Kingdom'],
            ['title' => 'United States'],
            ['title' => 'Uruguay'],
            ['title' => 'Uzbekistan'],
            ['title' => 'Vanuatu'],
            ['title' => 'Vatican City'],
            ['title' => 'Venezuela'],
            ['title' => 'Vietnam'],
            ['title' => 'Yemen'],
            ['title' => 'Zambia'],
            ['title' => 'Zimbabwe'],
            // if you want to add more countries, you can add here
        ];

        return $countries;
    }
}
