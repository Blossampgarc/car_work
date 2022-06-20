<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\chat; 
use App\Model\groups; 
use App\Model\group_user; 
use App\Model\block_connection; 
use Auth;
use Crypt;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
 
   public function chat(){

    $id = Auth::user()->id;
    $all_members = User::where("is_active" , 1)->where('id' ,'!=' , 1)->get();
    return view('chat/chat')->with(compact('all_members'));
    
    $data['info']=User::find($id);

    // $block_connection = block_connection::where("user_id" , $id)->where("is_active" , 1)->get()->pluck("requested_userid")->toArray();

    // if($ids==0){
    //     $data['all_users']=User::where('id','!=',$id)->whereNotIn("id" , $block_connection)->get();
    // }else{

    // $data['all_users']=User::where('is_active',1)->whereNotIn("id" , $block_connection)->where('id',$ids)->get();
    // }

    //$groups = groups::where("is_active" ,1 )->where("user_id" , $id)->get();
    //$all_members = User::where('is_active',1)->whereNotIn("id" , $block_connection)->where("id" ,"!=", $id)->get();
    $groups = [];
    $all_members = User::where("is_active" , 1)->get();
    return view('web/chat',$data)->with(compact('groups','all_members'));
    }

    public function chatroom($group_id){
        
    $user = Auth::user();
    if ($group_id == "") {
        return redirect()->back()->with('error','Invalid URL');
    }
    $group_id = Crypt::decryptString($group_id);
    $group = groups::where('is_active',1)->where("id" ,$group_id)->first();
    if (!$group) {
        return redirect()->back()->with('error','No Group Found');
    }
    $group_user = group_user::where("is_active" ,1)->where("user_id" , $user->id)->where("group_id" ,$group->id)->first();
    if (!$group_user) {
        return redirect()->back()->with('error','You are not a User of this group.');
    }
    $chat = chat::where("is_active" ,1)->where("group_id" , $group_id)->get();
    $group_user = group_user::where("is_active" ,1)->where("group_id" ,$group->id)->get();
    
    return view('web/chatroom')->with(compact('group_user','group','chat','user'));
    }

    public function save_msg(Request $request){
        if(Auth::check() == true){
            
            $chatting = new chat();
            $chatting->message = $request->message;
            if (isset($request->group_id)) {
                $chatting->group_id = $request->group_id;
                $chatting->to_user_id = 0;
            }else{
                $chatting->to_user_id = $request->to_user_id;
            }
            $chatting->from_user_id = Auth::user()->id;
            
             if($chatting->save()){

                $fromuser =User::find($chatting->from_user_id);
                
                if (isset($request->group_id)) {
                    $touser =User::find($request->to_user_id);
                    $response['tousername'] = "";
                    $response['touserimage'] = "";
                    $response['to_user_id'] = "";
                }else{
                    $touser =User::find($request->to_user_id);
                    $response['tousername'] = $touser->username;
                    $response['touserimage'] = $touser->profile_pic;
                    $response['to_user_id'] = $request->to_user_id;
                }

                $response['fromusername'] = $fromuser->username;
                $response['fromuserimage'] = $fromuser->profile_pic;
                $response['message'] = $request->message;
                
                $response['from_user_id'] = Auth::user()->id;
                $response['created_at'] = $chatting->created_at->diffForHumans();
                $response['clock']="";
                $response['status'] = true;

             }else{
                $response['status']=false;
             }   
          return json_encode($response);   
        }else
        {
            return redirect('login')->with('notify_error',"Kindly login First");
        }
 }
 
 public function fetch_msg()
    {
        if(Auth::check() == true){
            $fromuser = Auth::user();
            $chatting = chat::where("to_user_id" , $_POST['to'])->where("from_user_id" , $fromuser->id)
            ->orWhere("from_user_id" , $_POST['to'])->where("to_user_id" , $fromuser->id)
            ->where("is_active" ,1)->get();
            if($chatting){
                // to
                $touser =User::find($_POST['to']);
                $body = '';
                foreach($chatting as $chat){
                    //From body
                    if($chat->from_user_id == $fromuser->id){
                        $body .= '<div class="media d-flex mb-4"><div class="p-3 ml-auto speech-bubble">'.$chat->message.'</div><div class="ml-4"><a href="#"><img style="width: 50px;height: 50px;" src="'.asset($fromuser->profile_pic).'" alt="" class="img-fluid rounded-circle" /></a></div></div>';        
                    }else{
                        $body .= '<div class="media d-flex mb-4"><div class="mr-4 thumb-img"><a href="#"><img style="width: 50px;height: 50px;" src="'.asset($touser->profile_pic).'" alt="" class="img-fluid rounded-circle" /></a></div><div class="p-3 mr-auto speech-bubble alt">'.$chat->message.'<br/></div></div>';
                    }
                }
                
                $response['body'] = $body;
                //$response['clock']="";
                $response['status'] = true;

             }else{
                $response['status']=false;
             }   
          return json_encode($response);   
        }else
        {
            return redirect('login')->with('notify_error',"Kindly login First");
        }
    }
 
 public function fetch_msg1()
    {
        // dd($_POST);
        $user = Auth::user();
        $id = Auth::user()->id;
        
        if (!$user) {
           return redirect('login')->with('notify_error',"Kindly login First"); 
        }
        
        $messages = chat::select('message','to_user_id','from_user_id','created_at')->where('is_active',1)->where('from_user_id',$id)->where('to_user_id',$_POST['to'])->orWhere('to_user_id',$id)->where('from_user_id',$_POST['to'])->where('is_active',1)->get();
        // dd($messages);
            $msg_body = "";
            if($user){
                    foreach($messages as $value){

                            // dd($value);
                                    
                                    $dummyimage=asset('web_assets/images/download.png');
                                    $clock=asset('web_assets/images/clock.png');
                                if($value->from_user_id == $id){
                                    $toname = $user->user_name;
                                    $toimage=asset($user->profile_pic);
                                   $userimage=(!empty($value->to->profile_pic))?$toimage:$dummyimage;
                                    
                                    //Sender Member
                                    $msg_body = $msg_body . '<div class="profile-inner-full-chat">';
                                    $msg_body = $msg_body . '<div class="profile-inner-full-chat-from">';
                                    $msg_body = $msg_body . '<ul>';
                                    $msg_body = $msg_body . '<li class="profile-inner-full-chat-from-image"><img src="'.$userimage.'"><span></span></li>';
                                    $msg_body = $msg_body . '<li class="profile-inner-full-chat-from-text">';
                                    $msg_body = $msg_body . '<div class="profile-inner-full-chat-from-name">';
                                    $msg_body = $msg_body . '<h1>'.$toname.'</h1>';
                                    $msg_body = $msg_body . '<div class="chat-dropdown-report">';
                                    
                                    // $msg_body = $msg_body . '<nav class="navbar navbar-expand-lg"> <div class="collapse navbar-collapse" id="navbarSupportedContent"> <ul class="navbar-nav mr-auto"> <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> ... </a> <div class="dropdown-menu" aria-labelledby="navbarDropdown"> <a class="dropdown-item" href="#">Report</a> </div> </li> </ul> </div> </nav>';
                                    $msg_body = $msg_body . '</div></div>';
                                    $msg_body = $msg_body . '<p>'.$value->message.'<span><img src="'.$clock.'">'. $value->created_at->diffForHumans().'</span></p>';
                                    $msg_body = $msg_body . '</li></ul></div></div>';

                                }else{
                                    // Receiver Member
                                    $fromname = $value->from->user_name;
                                     $fromimage=asset('uploads/profile/'.$value->from->profile_image);
                                     $userimage=(!empty($value->from->profile_image))?$fromimage:$dummyimage;
                                    $msg_body = $msg_body . '<div class="profile-inner-full-chat profile-inner-full-chat-right">';
                                    $msg_body = $msg_body . '<div class="profile-inner-full-chat-from">';
                                    $msg_body = $msg_body . '<ul>';
                                   
                                    $msg_body = $msg_body . '<li class="profile-inner-full-chat-from-text profile-inner-full-chat-from-right-text">';
                                    $msg_body = $msg_body . '<div class="profile-inner-full-chat-from-name profile-inner-full-chat-from-name-right-chat">';
                                    $msg_body = $msg_body . '<div class="chat-dropdown-report">  </div>';
                                    // <nav class="navbar navbar-expand-lg"> <div class="collapse navbar-collapse" id="navbarSupportedContent"> <ul class="navbar-nav mr-auto"> <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> ... </a> <div class="dropdown-menu" aria-labelledby="navbarDropdown"> <a class="dropdown-item" href="#">Report</a> </div> </li> </ul> </div> </nav>
                                     $msg_body = $msg_body . '<h1>'.$fromname.'</h1>';
                                     $msg_body = $msg_body . '</div>';
                                     $msg_body = $msg_body . '<p><span><img src="'.$clock.'">'. $value->created_at->diffForHumans().'</span>'.$value->message.'</p>';
                                     $msg_body = $msg_body . '</li>';
                                     $msg_body = $msg_body . '<li class="profile-inner-full-chat-from-image"><img src="'.$userimage.'"><span></span></li>';
                                     $msg_body = $msg_body . '</ul></div></div>';
                                }
                            }

                }

            $response = json_encode($msg_body);
            return $response;
            }

    public function group_submit(Request $request)
    {
        $user = Auth::user();
        $groups  = new groups;

        $groups->user_id = $user->id;
        $groups->name = $request->group_name;
        $groups->save();

        $body["status"] = 1;
        $body["group_id"] = $groups->id;
        $response = json_encode($body);
        return $response;
    }

    public function addgroup_submit(Request $request)
    {
        $user = Auth::user();
        
        $members = $_POST['member_id'];
        if (count($members) < 1) {
            $body["status"] = 0;
            $body["msg"] = "No member seleced";
            $response = json_encode($body);
            return $response;
        }
        $group_main_user = group_user::where("is_active" , 1)->where("user_id" , $user->id)->where("group_id" , $request->group_id)->first();
        if (!$group_main_user) {

            $group_user = new group_user;
            $group_user->user_id = $user->id;
            $group_user->group_id = $request->group_id;
            $group_user->save();
        }
        $i = 0;
        foreach ($members as $key => $value) {
            $group_main_user = group_user::where("is_active" , 1)->where("user_id" , $value)->where("group_id" , $request->group_id)->first();
            if ($group_main_user) {
                
            }else{
                $group_user = new group_user;
                $group_user->user_id = $value;
                $group_user->group_id = $request->group_id;
                $group_user->save();
                $i++;
            }
        }
       
        $body["status"] = 1;
        if ($i == 0) {
            $body["msg"] = "All Member added in your group";
        }else{
            $body["msg"] = "Only ".$i." member added in your group.";
            
        }
        
        $response = json_encode($body);
        return $response;
    }

    
}