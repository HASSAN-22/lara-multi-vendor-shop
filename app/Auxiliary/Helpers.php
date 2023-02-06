<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;
use Carbon\Carbon;

if(! function_exists('limit')){
    function limit(string $data, int $count, string $separator = '...'){
        return Str::limit(strip_tags($data), $count, $separator);
    }
}


if(! function_exists('removeFile')){
    function removeFile($image){
        if(!empty($image)){
            if(file_exists(public_path($image))){
                $image = str_replace('/storage','',$image);
                \Illuminate\Support\Facades\Storage::delete('/public' . $image);;
            }
        }
    }
}


function discount(int $amount, int $discount){
    return ($amount - ($amount * ($discount / 100)));
}


if(! function_exists('removeFiles')){
    function removeFiles($images){
        foreach ($images as $image){
            if(!empty($image)){
                if(file_exists(public_path($image))){
                    $image = str_replace('/storage','',$image);
                    \Illuminate\Support\Facades\Storage::delete('/public' . $image);;
                }
            }
        }
    }
}

if(! function_exists('slug')){
    function slug(string $title){
        return Str::slug($title);
    }
}

if(! function_exists('notifyForAdmins')){
    function notifyForAdmins(int $postId, string $notifyClass, string $action){
        $notifyClass = "App\Notifications\\" . $notifyClass;
        foreach(User::where('access','admin')->get() as $user){
            $user->notify(new $notifyClass($postId, $action));
        }
    }
}

if(! function_exists('notifyForUser')){
    function notifyForUser(int $postId, int $userId, string $notifyClass, string $action){
        $notifyClass = "App\Notifications\\" . $notifyClass;
        $user = User::find($userId);
        $user->notify(new $notifyClass($postId, $action));
    }
}

if(! function_exists('readNotification')){
    function readNotification(string $notifyClass, string $notifKey, int $postId){
        $user = auth()->user();
        if($user->isAdmin()){
            $admins = User::where('access','admin')->get()->pluck('id')->toArray();
            \Illuminate\Support\Facades\DB::table('notifications')
                ->whereIn('notifiable_id',$admins)
                ->where('type','App\Notifications\\'.$notifyClass)
                ->whereJsonContains('data->'.$notifKey,$postId)->delete();

        }else{
            $user->unreadNotifications()->where('type','App\Notifications\\'.$notifyClass)->whereJsonContains('data->'.$notifKey,$postId)->delete();
        }

    }
}

if(! function_exists('setEnvironmentValue')){
    function setEnvironmentValue(array $envValues){
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        $str .= "\r\n";
        if (count($envValues) > 0) {
            foreach ($envValues as $envKey => $envValue) {

                $keyPosition = strpos($str, "$envKey=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                if (is_bool($keyPosition) && $keyPosition === false) {
                    $str .= "$envKey=$envValue";
                    $str .= "\r\n";
                } else {
                    $str = str_replace($oldLine, "$envKey=$envValue", $str);
                }
            }
        }
        $str = substr($str, 0, -1);
        if (!file_put_contents($envFile, $str)) {
            return false;
        }
        app()->loadEnvironmentFrom($envFile);
        if (file_exists(App::getCachedConfigPath())) {
            Artisan::call("config:cache");
        }
    }
}

if(! function_exists('calculateRating')){
    function calculateRating($ratings){
        return number_format(($ratings->sum('rating') /  $ratings->count()),1);
    }
}

if(! function_exists('responseMessage')){
    function responseMessage($data, string $action, string $successMessage='', string $errorMessage=''){
        switch ($action){
            case 'create': return $data ? back()->with(['alert'=>$successMessage != '' ? $successMessage : 'Created successfully','color'=>'success'])
                : back()->with('error',$errorMessage != '' ? $errorMessage : 'Server error') ;break;
            case 'update': return $data ? back()->with(['alert'=>$successMessage != '' ? $successMessage : 'Updated successfully','color'=>'success'])
                : back()->with('error',$errorMessage != '' ? $errorMessage : 'Server error') ;break;
            case 'delete': return $data ? back()->with(['alert'=>$successMessage != '' ? $successMessage : 'Deleted successfully','color'=>'success'])
                : back()->with('error',$errorMessage != '' ? $errorMessage : 'Server error') ;break;
            case 'manual': return back()->with('manual',$successMessage);break;
        }
    }
}
