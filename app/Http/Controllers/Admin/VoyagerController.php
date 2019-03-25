<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class VoyagerController extends \TCG\Voyager\Http\Controllers\VoyagerController
{
    public function logout()
    {
        if (session()->get('real_id')) {
            $real_id = session()->get('real_id');
            Auth::logout();
            Auth::loginUsingId($real_id);
            session()->forget('real_id');
            return redirect()->route('voyager.dashboard');
        } else {
            Auth::logout();
            return redirect()->route('voyager.login');
        }

    }

    public function saveImage(Request $request)
    {
        //header('Cache-Control: no-cache, must-revalidate');// no necesario?
        //Log::debug($request->all());
        //Specify url path
        $path = storage_path('/app/public/contentbuilder_uploads/');

        //Read image
        $count = $request['count'];
        $b64str = $request['hidimg-' . $count];
        $imgname = $request['hidname-' . $count];
        $imgtype = $request['hidtype-' . $count];

        $customvalue = $request['hidcustomval-' . $count]; //Get customvalue

        //Generate random file name here
        if ($imgtype == 'png') {
            $image = $imgname . '-' . base_convert(rand(), 10, 36) . '.png';
        } else {
            $image = $imgname . '-' . base_convert(rand(), 10, 36) . '.jpg';
        }


        //Check folder. Create if not exist
        $pagefolder = $path;
        if (!file_exists($pagefolder)) {
            mkdir($pagefolder, 0777);
        }


        //Optional: If using customvalue to specify upload folder
        if ($customvalue != '') {
            $pagefolder = $path . $customvalue . '/';
            if (!file_exists($pagefolder)) {
                mkdir($pagefolder, 0777);
            }
        }


        //Save image
        $success = file_put_contents($pagefolder . $image, base64_decode($b64str));
        if ($success === FALSE) {

            if (!file_exists($path)) {
                return "<html><body onload=\"alert('Saving image to folder failed. Folder " . $pagefolder . " not exists.')\"></body></html>";
            } else {
                return "<html><body onload=\"alert('Saving image to folder failed. Please check write permission on " . $pagefolder . "')\"></body></html>";
            }

        } else {
            //Replace image src with the new saved file
            $img_src = asset('storage/contentbuilder_uploads/' . $image);
            return "<html><body onload=\"parent.document.getElementById('img-" . $count . "').setAttribute('src','" . $img_src . "');  parent.document.getElementById('img-" . $count . "').removeAttribute('id') \"></body></html>";
        }
    }

}
