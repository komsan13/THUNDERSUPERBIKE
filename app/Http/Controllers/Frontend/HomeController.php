<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Webpanel\LogsController;
use Intervention\Image\ImageManagerStatic as Image;

//=== Model Backend ===
use App\Models\Backend\NewsModel;
use App\Models\Backend\FaqModel;
use App\Models\Backend\GalleryModel;
use App\Models\Backend\CalculateModel;
use App\Models\Backend\Calculate_imageModel;
use App\Models\Backend\PackageModel;
use App\Models\Backend\Temp_calculate_imageModel;
use App\Models\Backend\Temp_calculateModel;

//=====================

class HomeController extends Controller
{
    protected $prefix = 'front-end';

    public function setLang(Request $request)
	{
		$lang = Session::get('lang');
        $referrer =  $request->headers->get('referer');
        Session::put('lang',$request->lang);
        $newReferer = str_replace('/'.$lang,'/'.$request->lang, $referrer);
        
        return redirect()->intended($newReferer);
	}

    public function index(Request $request)
    {
        return view("$this->prefix.index",[
            'prefix' => $this->prefix,
        ]);
    }

    public function calculate_factory(Request $request)
    {
        return view("$this->prefix.calculate-factory",[
            'prefix' => $this->prefix,
        ]);
    }

    // public function calculate_total_sum(Request $request)
    // {
    //    if($request)
    //    {
    //        $data = new CalculateModel();
    //        $data->firstname = $request->firstname;
    //        $data->lastname = $request->lastname;
    //        $data->phone = $request->phone;
    //        $data->email = $request->email;
    //        $data->line = $request->line;
    //        $data->roof_width = $request->roof_width;
    //        $data->roof_high = $request->roof_high;
    //        $data->elec_sum = $request->elec_sum;
    //        if($data->save())
    //        {
    //             return view("$this->prefix.calculate-total",[
    //                 'prefix' => $this->prefix,
    //                 'row' => CalculateModel::find($data->id),
    //             ]);
    //        }
    //    }
    // }

    public function calculate_total_sum(Request $request)
    {
        if($request)
        {
            DB::beginTransaction();
            $date = date('Ymd');
            $count = Temp_calculateModel::count() + 1;

            $data = new Temp_calculateModel();
            $data->firstname = $request->firstname;
            $data->lastname = $request->lastname;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->line = $request->line;
            $data->roof_width = $request->roof_width;
            $data->roof_high = $request->roof_high;
            $area = 0;
            if($request->roof_width != "" || $$request->roof_high != "")
            {
                $data->smeter = $request->roof_width * $request->roof_high;
                $area = $request->roof_width * $request->roof_high;
            }
            else
            {
                $data->smeter = 0;
            }
            $data->elec_sum = $request->elec_sum;
            $data->order_ref = "acc$date$count";
            $type = "commercial";

            // Result
            $area_setup = 0;
            $ave_bill = 0;

            try{
                $area_setup = $area/6;
                
                if($type == "commercial")
                {
                    $elec = $request->elec_sum;
                    $ave_bill = $elec/4/24/30;
                }
            }
            catch (\Exception $e){
                $area_setup = 0;
                $ave_bill = 0;
            }
            
            $data->low_kw1 = $area_setup;
            $data->low_kw2 = $ave_bill;

            if($area_setup < $ave_bill)
            {
                $value = PackageModel::where('size_kw','<=',$area_setup)->orderby('id','desc')->first();
                if($value)
                {
                    $data->package_id = $value->id;
                   
                }
                else
                {
                    $value1 = PackageModel::where('size_kw','>=',$area_setup)->orderby('id','desc')->first();
                    $data->package_id = $value1->id;
                }
            }
            elseif($ave_bill < $area_setup)
            {
                $value = PackageModel::where('size_kw','<=',$ave_bill)->orderby('id','desc')->first();
                if($value)
                {
                    $data->package_id = $value->id;
                }
                else
                {
                    $value1 = PackageModel::where('size_kw','>=',$ave_bill)->orderby('id','desc')->first();
                    $data->package_id = $value1->id;
                }
            }
            
        
           
            // End Result

            if($data->save())
            {
                $filename = 'elec_' . date('dmY-His');
                $file = $request->elec_upload;
                if ($file) 
                {
                    $lg = Image::make($file->getRealPath());
                    $ext = explode("/", $lg->mime())[1];
                    
                    $height = Image::make($file)->height();
                    $width = Image::make($file)->width();
                    $lg->resize($width, $height)->stream();
                    $newLG = 'upload/calculate/'.$data->id.'/' . $filename . '.' . $ext;
                    $store = Storage::disk('public')->put($newLG, $lg);
                    if($store)
                    {
                        $data1 = new Temp_calculate_imageModel();
                        $data1->_id = $data->id;
                        $data1->type = "elec";
                        $data1->image = $newLG;
                        $data1->save();
                    }
                }

                $filename = 'home_' . date('dmY-His');
                $file = $request->home_upload;
                if ($file) 
                {
                    $lg = Image::make($file->getRealPath());
                    $ext = explode("/", $lg->mime())[1];
                    
                    $height = Image::make($file)->height();
                    $width = Image::make($file)->width();
                    $lg->resize($width, $height)->stream();
                    $newLG = 'upload/calculate/'.$data->id.'/' . $filename . '.' . $ext;
                    $store = Storage::disk('public')->put($newLG, $lg);
                    if($store)
                    {
                        $data1 = new Temp_calculate_imageModel();
                        $data1->_id = $data->id;
                        $data1->type = "home";
                        $data1->image = $newLG;
                        $data1->save();
                    }
                }
                DB::commit();
                return redirect()->away('calculate-total?ref='.$data->order_ref);

                // return view("$this->prefix.calculate-total",[
                //     'prefix' => $this->prefix,
                //     'row' => Temp_calculateModel::find($data->id),
                // ]);
            }
        }
    }

  public function calculate_total(Request $request)
    {
        $data = Temp_calculateModel::where('order_ref',$request->ref)->first();
        if($data)
        {
            return view("$this->prefix.calculate-total",[
                'prefix' => $this->prefix,
                'rows' => $data,
                'package' => PackageModel::find($data->package_id),
                'img1' => Temp_calculate_imageModel::where(['_id'=>$data->id, 'type'=>'elec'])->first(),
                'img2' => Temp_calculate_imageModel::where(['_id'=>$data->id, 'type'=>'home'])->first(),
            ]);
        }
        else
        {
            return view("$this->prefix.index",[
                'prefix' => $this->prefix,
            ]); 
        }
       
    }

    public function quotation(Request $request)
    {
        dd($request);
    }
    
    
    public function news(Request $request)
    {
        $lang = Session('lang');
        return view("$this->prefix.news",[
            'prefix' => $this->prefix,
            'rows' => NewsModel::select(['tb_news.*',"name_$lang as name","short_detail_$lang as short_detail","detail_$lang as detail"])->where('status','on')->orderby('sort','asc')->limit(2)->get(),
            'rows1' => NewsModel::select(['tb_news.*',"name_$lang as name","short_detail_$lang as short_detail","detail_$lang as detail"])->where('status','on')->orderby('sort','asc')->get(),
        ]);
    }

    public function news_detail(Request $request,$id)
    {
        $lang = Session('lang');
        $data = NewsModel::select(['tb_news.*',"name_$lang as name","short_detail_$lang as short_detail","detail_$lang as detail"])->where('id',$id)->first();
        
        return view("$this->prefix.news-detail",[
            'prefix' => $this->prefix,
            'row' => $data,
            'gallerys' => GalleryModel::where(['_id'=>$id, 'type' => 'news'])->get(),
            'news' => NewsModel::select(['tb_news.*',"name_$lang as name","short_detail_$lang as short_detail","detail_$lang as detail"])->where('id','!=',$id)->get(),
        ]);
    }
    
    public function faqs(Request $request)
    {
        $lang = Session('lang');
        return view("$this->prefix.faqs",[
            'prefix' => $this->prefix,
            'rows' => FaqModel::select(['tb_faq.*',"name_$lang as name","detail_$lang as detail"])->where('status','on')->orderby('sort','asc')->get(),
            
        ]);
    }
}
