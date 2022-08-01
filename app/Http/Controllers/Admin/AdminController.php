<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;

class AdminController extends Controller{

    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['getlogin' , 'postlogin']]);
    }
    
    // get login page
    public function getlogin(){
        return view('admin.login');
    }

    // post login 
    public function postlogin(Request $request){
        $credentials = request(['email', 'password']);

        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();
            return redirect('/admin-panel');
        } else {
            return view('admin.login');
        }
    }

    // logout
    public function logout(){
        $user = Auth::guard('admin')->user();
        Auth::logout();
        return redirect('/admin-panel/login');
    }

    // database backup
    public function backup(){
        $mysqlHostName      = env('DB_HOST');
        $mysqlUserName      = env('DB_USERNAME');
        $mysqlPassword      = env('DB_PASSWORD');
        $DbName             = env('DB_DATABASE');
        $backup_name        = "mybackup.sql";
        $tables             = array("users","admins","ads","categories","contact_us","meta_tags","notifications","settings"); //here your tables...

        $connect = new \PDO("mysql:host=$mysqlHostName;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword",array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $get_all_table_query = "SHOW TABLES";
        $statement = $connect->prepare($get_all_table_query);
        $statement->execute();
        $result = $statement->fetchAll();


        $output = '';
        foreach($tables as $table)
        {
         $show_table_query = "SHOW CREATE TABLE " . $table . "";
         $statement = $connect->prepare($show_table_query);
         $statement->execute();
         $show_table_result = $statement->fetchAll();

         foreach($show_table_result as $show_table_row)
         {
          $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
         }
         $select_query = "SELECT * FROM " . $table . "";
         $statement = $connect->prepare($select_query);
         $statement->execute();
         $total_row = $statement->rowCount();

         for($count=0; $count<$total_row; $count++)
         {
          $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
          $table_column_array = array_keys($single_result);
          $table_value_array = array_values($single_result);
          $output .= "\nINSERT INTO $table (";
          $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
          $output .= "'" . implode("','", $table_value_array) . "');\n";
         }
        }
        $file_name = 'database_backup_on_' . date('y-m-d') . '.sql';
        $file_handle = fopen($file_name, 'w+');
        fwrite($file_handle, $output);
        fclose($file_handle);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
           header('Pragma: public');
           header('Content-Length: ' . filesize($file_name));
           ob_clean();
           flush();
           readfile($file_name);
           unlink($file_name);

        return redirect()->back();
    }

    // get profile 
    public function profile(){
        $admin = Auth::user();
        $data['name'] = $admin->name;
        $data['email'] = $admin->email;        
        return view('admin.profile' , ['data' => $data]);
    }

    // update profile
    public function updateprofile(Request $request){
        $current_admin_id =  Auth::user()->id;
        $check_manager_email = Admin::where('email' , $request->email)->where('id' , '!=' , $current_admin_id)->first();
        if($check_manager_email){
            return redirect()->back()->with('status' , 'Email Exists Before');
        }
        
        $current_manager = Admin::find($current_admin_id);
        $current_manager->name = $request->name;
        $current_manager->email = $request->email;
        if($request->password){
            $current_manager->password = Hash::make($request->password);
        }
        $current_manager->save();
        return redirect()->back();
    }

}