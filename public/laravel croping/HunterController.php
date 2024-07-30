<?php
/***********************************************/
# Company Name    :                             
# Author          : JD                            
# Created Date    : 03-06-2020                           
# Controller Name : HunterController               
# Purpose         : Hunter Management             
/***********************************************/

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\User;
use App\Gender;
use DB;
use Mail;

use App\Exports\HunterExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Traits\GeneralMethods;
use Exception, Image,Storage;
use \Validator;
use Carbon\Carbon;


class HunterController extends Controller
{
    use GeneralMethods;
    public $controllerName  = 'Hunter';
    public $management;
    public $modelName       = 'User';
    public $breadcrumb;
    public $routePrefix     = 'hunters';
    public $listUrl         = 'hunters.list';
    public $viewFolderPath  = 'admin/hunters';

    /*
        * Function Name :  __construct
        * Purpose       :  It sets some public variables for being accessed throughout this
        *                   controller and its related view pages
        * Author        :
        * Created Date  : 
        * Modified date :          
        * Input Params  :  N/A
        * Return Value  :  Mixed
   */
    public function __construct()
    {
        parent::__construct();
        $this->management      = 'Hunter';
        // Begin: Assign breadcrumb for view pages
        $this->assignBreadcrumb();
        // End: Assign breadcrumb for view pages
        // Variables assign for view page
        $this->assignShareVariables();
    }

    /**
        * Function Name :  index
        * Purpose       :  This function is for the hunter listing and searching
        * Author        :
        * Created Date  : 
        * Modified date :        
        * Input Params  :  Request $request
        * Return Value  :  return to listing page
    */

    public function index(Request $request)
    {
        try{
            $data['keyword']        = '';
            if($request->keyword !=''){
                // search section
                $data['keyword'] = $request->keyword;
                
                $data['records'] = User::where('user_type','=',config('global.HUNTER_USER_TYPES'))->Where('first_name','like','%'.$data['keyword'].'%')->OrWhere('last_name','like','%'.$data['keyword'].'%')->orderBy('id','desc')->paginate(config('global.ADMIN_RECORDS_PER_PAGE'));  
            }else{
                $data['records'] = User::where('user_type','=',config('global.HUNTER_USER_TYPES'))->orderBy('id','desc')->paginate(config('global.ADMIN_RECORDS_PER_PAGE'));
            }
            return view($this->viewFolderPath.'.list', $data);
        }catch(Exception $e){
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
        
    }

    /**
        * Function Name :  add
        * Purpose       :  This function renders the User add form
        * Author        :
        * Created Date  : 
        * Modified date :          
        * Input Params  :  N/A
        * Return Value  :  return to add page

    */

    public function add()
    {
        return view($this->viewFolderPath.'.add');
    }

    /**
        * Function Name :  store
        * Purpose       :  This function use for User addition.
        * Author        :
        * Created Date  : 
        * Modified date :          
        * Input Params  :  Request $request
        * Return Value  :  loads listing page on success and load add page for any error during the operation

    */

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'first_name'            => 'required',
                'last_name'             => 'required',
                'phone'                 => 'required',
                'user_type'             => 'required',
                'email'                 => 'required|email|unique:users',
                'password'              => 'required|min:5',
               
            ],
            [
                'first_name.required'     => 'First Name is Required',
                'last_name.required'      => 'Last Name is Required',
                'email.required'          => 'Email is Required',
                'phone.required'          => 'Phone is Required',
                'password.required'       => 'Password is Required',
                'user_type.required'      => 'User Type is Required',
                
            ]
        );
        try{
            $model                      = new User;
            $model->first_name          = $request->first_name;
            $model->last_name           = $request->last_name;
            $model->email               = $request->email;
            $model->phone               = $request->phone;
            $model->password            = $request->password;
            $model->user_type           = $request->user_type;
            
            $model->status              = $request->status;
            $model->save();

            // getting default meta data
            $settings  = \Helpers::getSiteSettingsData();
            //Mail sending start
            $data                           = [];
            $fromEmail                      = $settings['from_email']; // From email id
            $from                           = $settings['from_email_name'];  // From name
            $toEmail                        = $request->email; //To email id
            $toName                         = $request->first_name.' '.$request->last_name;  // To email name    
            $data['userName']               = $request->first_name.' '.$request->last_name;  
            $data['emailHeaderSubject']     = 'Registration Successful'; 
            $data['loginEmail']             = $request->email;
            $data['password']               = $request->password; 
            // email message
            $data['content_message']    = "Thanks for showing interest to our care giving program."; 
            Mail::send('emails.user-registration-admin', $data, function($sent) use($data,$toEmail,$toName,$fromEmail,$from)
            {
                $sent->from($fromEmail, $from);                                
                $sent->to($toEmail, $toName)->subject(\GlobalVars::SITE_ADDRESS_NAME.': '.$data['emailHeaderSubject']);
            });
            // Mail sending end

            return \Redirect::Route($this->listUrl)->with('success', 'Record added Successfully');
        }catch(Exception $e){
            throw new \App\Exceptions\AdminException($e->getMessage());
        }       
    }

    /**
        * Function Name :  edit
        * Purpose       :  This function renders the User edit form
        * Author        :
        * Created Date  : 
        * Modified date :          
        * Input Params  :  intiger $id
        * Return Value  :  loads user edit page
    */

    public function edit($id)
    {
        try{
            $data['id'] = $id;
            $data['record'] = User::find($id);

            // $headerNotification['message'] = 'Admin enters into hunter edit page';
            // $headerNotification['link'] = '';
            // $headerNotification['type'] = 'ProfileUpdate';
            // $this->sendAdminNotification($headerNotification);


            //Notification::send(User::find(2), new HeaderTopNotifications($headerNotification));
            //User::find(1)->notify(new HeaderTopNotifications($data['record']));

            $data['genders'] = Gender::pluck('name','slug');
            if(!$data['record']){
                throw new Exception("No result was found for id: $id");
            }
            return view($this->viewFolderPath.'.edit', $data);
        }catch(Exception $e){
            throw new \App\Exceptions\AdminException($e->getMessage());
        }      
    }

    /**
        * Function Name :  update
        * Purpose       :  This function use for update records of User.
        * Author        :
        * Created Date  : 
        * Modified date :          
        * Input Params  :  Request $request, intiger $id
        * Return Value  :  loads listing page on success and load edit page for any error during the operation
    */

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'first_name'    => 'required',
                'last_name'     => 'required',
                'email'         => 'required|email|unique:users,email,'.$id,
                //'phone'         => 'required|regex:/^(\+\d{1,2}\s?)?1?\-?\.?\s?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/',
                'phone'         => 'required|regex:/^(?=.*[0-9])[- +()0-9]+$/',
                'dob'         => 'required|before_or_equal:' . Carbon::now()->subYears(18)->toDateString(),
                
            ],
            [
                'first_name.required'     => 'First Name is Required',
                'last_name.required'      => 'Last Name is Required',
                'email.required'          => 'Email is Required',
                'phone.required'          => 'Phone is Required',
            ]
        );
        try{
            //dd($request->all());
            $model = User::find($id);
            $model->first_name          = $request->first_name;
            $model->last_name           = $request->last_name;
            //$model->email               = $request->email;
            $model->phone               = $request->phone;
            $model->gender               = $request->gender;
            $model->location               = $request->location;
            $model->address               = $request->address;
            $model->dob               = date('Y-m-d',strtotime($request->dob));
            $model->bio               = $request->bio;
           // $model->user_type           = $request->user_type;
           // $model->status              = $request->status;
            if($request->imagedata){
                $image = $request->imagedata;

                list($type, $image) = explode(';', $image);
                list(, $image)      = explode(',', $image);
                $image = base64_decode($image);
                $image_name= 'thumb_'.strtotime(date('Y-m-d H:i:s')).'.png';
                $temppath = public_path('uploads/'.$image_name);

                file_put_contents($temppath, $image);

                $path = $this->saveUrlFileToS3($temppath,config('global.FRONT_USER_PROFILE_IMAGE_PATH'),false);
                if($path['status']){
                    $model->user_logo     = config('global.FRONT_USER_PROFILE_IMAGE_PATH').'/'.$path['fileName'];
                    unlink($temppath);
                } 
               
            }
            $model->save();
            return \Redirect::Route($this->listUrl)->with('success', 'Record updated Successfully');
        }catch(Exception $e){
            throw new \App\Exceptions\AdminException($e->getMessage());
        }        
    }


    /**
        * Function Name :  delete
        * Purpose       :  This function use for delete records from User.
        * Author        :
        * Created Date  : 
        * Modified date :          
        * Input Params  :  intiger $id
        * Return Value  :  loads listing page
    */

    public function delete($id)
    {
        try{
            $model = User::find($id);
            $model->delete();
            return \Redirect::Route($this->listUrl)->with('success', 'Record deleted Successfully');
        }catch(Exception $e){
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
 
    /**
        * Function Name :  view
        * Purpose       :  This function renders the User edit form
        * Author        :
        * Created Date  : 
        * Modified date :          
        * Input Params  :  integer $id
        * Return Value  :  loads user view page
    */

    public function view($id)
    {
        try{
            $data['id'] = $id;
            $data['record'] = User::find($id);
            if(!$data['record']){
                throw new Exception("No result was found for id: $id");
            }
            return view($this->viewFolderPath.'.view', $data);
        }catch(Exception $e){
            throw new \App\Exceptions\AdminException($e->getMessage());
        }      
    }
    
    public function export() 
    {
        return Excel::download(new HunterExport, 'hunter_'.date('YmdHis').'.xlsx');
    }


}
